<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nutrition_blogs;
use App\Models\User;
use App\Models\Notifications;
use App\Helpers\ApiHelper;

use Str;

class NutritionBlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }
    public function index()
    {
        $data = Nutrition_blogs::all();
        return view('admin.nutritionBlogs',compact('data'));
    }
    public function add()
    {
        return view('admin.nutritionBlogAdd');
    }
    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg',
            'description' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'description', 'status');
        // $input['slug'] = str_replace(' ','-',strtolower($request->title));
        $input['slug'] = Str::slug($request->title, '-');
        $imageName = $request->image->store('/images');
        $input['image'] = 'uploads/'. $imageName;
        $insert = Nutrition_blogs::create($input);
        if($insert) {

            $get_data = Nutrition_blogs::where('id', $insert->id)->first();
            $users = User::where('role_id', '!=', '1')->get();
            foreach ($users as $user) {
                $title = "New Blog Available!!!";
                $body = "New Blog available : " . $get_data->title . ".";
                $input1['type_id'] = null;
                $input1['title'] = $title;
                $input1['status'] = '0';
                $input1['user_id'] = $user->id;
                $insert = Notifications::create($input1);
                $notification = array('body' => $body, 'title' => $get_data->title);
                $extraNotificationData = array('click_action' => "nutrition_blog", );
                if (!empty($user->device_token)) {
                    $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
                    // $abc = ApiHelper::sendNotification("cFPZ0cOZS1So55Yp1maCeR:APA91bG3GWwgF2BjRMwQi2vPbIT77U1F1aOfNez9zGEMi_iDKJMXr3NPNxXg85EOdOVKoiVr7nXvqjnbfNl6miHT8ut69jJ1E6K_PeKdsaq1twM9c6vY5NzET3AYYzmk6RphjhWDaUGV", $notification, $extraNotificationData);
                    \Log::info("workout_video notification send." . $abc);
                }
            }

            return redirect()->route('nutrition-blogs')->withSuccess("Added Successfully.");
        }else{
            return redirect()->route('nutrition-blogs')->withError("Not Added Successfully.");
        }
    }

    public function edit($id)
    {
        $data = Nutrition_blogs::where('id',$id)->first();
        if($data) {
            return view('admin.nutritionBlogUpdate',compact('data'));
        }else{
            return redirect()->route('nutrition-blogs')->withError("Not Data Available.");
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
            'description' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'description', 'status');
        // $input['slug'] = str_replace(' ','-',strtolower($request->title));
        $input['slug'] = Str::slug($request->title, '-');
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/'. $imageName;
        }
        $insert = Nutrition_blogs::where('id',$request->id)->update($input);
        if($insert) {
            // $get_data = Nutrition_blogs::where('id', $request->id)->first();
            // $users = User::where('role_id', '!=', '1')->get();
            // foreach ($users as $user) {
            //     $title = "New Blog Available!!!";
            //     $body = "New Blog available : " . $get_data->title . ".";
            //     $input1['type_id'] = null;
            //     $input1['title'] = $title;
            //     $input1['status'] = '0';
            //     $input1['user_id'] = $user->id;
            //     $insert = Notifications::create($input1);
            //     $notification = array('body' => $body, 'title' => $get_data->title);
            //     $extraNotificationData = array('click_action' => "nutrition_blog", );
            //     if (!empty($user->device_token)) {
            //         $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
            //         // $abc = ApiHelper::sendNotification("cFPZ0cOZS1So55Yp1maCeR:APA91bG3GWwgF2BjRMwQi2vPbIT77U1F1aOfNez9zGEMi_iDKJMXr3NPNxXg85EOdOVKoiVr7nXvqjnbfNl6miHT8ut69jJ1E6K_PeKdsaq1twM9c6vY5NzET3AYYzmk6RphjhWDaUGV", $notification, $extraNotificationData);
            //         \Log::info("workout_video notification send." . $abc);
            //     }
            // }
            return redirect()->route('nutrition-blogs')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('nutrition-blogs')->withError("Updation Failed.");
        }
    }

    public function delete($id)
    {
        $data = Nutrition_blogs::find($id);
        if($data->delete()) {
            return redirect()->route('nutrition-blogs')->withSuccess("Deleted Successfully.");
        }else{
            return redirect()->route('nutrition-blogs')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Nutrition_blogs::find($request->id);
        $data->status = $request->status;
        $data->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
