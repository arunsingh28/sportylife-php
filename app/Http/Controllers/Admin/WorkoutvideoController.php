<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Jobs\compressVideo;
use App\Models\Notifications;
use App\Models\User;
use App\Models\Workoutcategories;
use App\Models\Workoutvideos;
use FFMpeg;
use Illuminate\Http\Request;

class WorkoutvideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $workoutvideos = Workoutvideos::with('workoutcategorydata')->orderBy("created_at", "desc")->get();
        return view('admin.workoutvideos', compact('workoutvideos'));
    }
    public function add()
    {
        $workoutcate = Workoutcategories::where('status', '1')->get();
        return view('admin.workoutvideoAdd', compact('workoutcate'));
    }
    public function post(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'status' => 'required',
            'video' => 'required|mimes:mp4',
        ]);
        $input = $request->only('category_id', 'title', 'status');
        if ($request->video) {
            $videoName = $request->video->store('/videos');
            $input['video'] = 'uploads/' . $videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid() . time() . '.png';
            $thumbnail = 'uploads/images/' . $imageTo;

            FFMpeg::fromDisk('videos')
                ->open($videoFrom[1])
                ->getFrameFromSeconds(1)
                ->export()
                ->toDisk('thumbnail')
                ->save($imageTo);

            $new = 'compressed' . $videoFrom[1];
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['video'] = "uploads/videos/" . $new;

            $input['thumbnail'] = $thumbnail;
        }
        $insert = Workoutvideos::create($input);
        if ($insert) {
            // $get_data = Workoutvideos::where('id', $insert->id)->first();
            // $users = User::where('role_id', '!=', '1')->get();
            // foreach ($users as $user) {
            //     $title = "New Workout Video available!!!";
            //     $body = "New Workout Video available : " . $get_data->title . ".";
            //     $input1['type_id'] = null;
            //     $input1['title'] = $title;
            //     $input1['status'] = '0';
            //     $input1['user_id'] = $user->id;
            //     $insert = Notifications::create($input1);
            //     $notification = array('body' => $body, 'title' => $get_data->title);
            //     $extraNotificationData = array('click_action' => "workout_video", 'image' => $get_data->thumbnail);
            //     if (!empty($user->device_token)) {
            //         $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
            //         // $abc = ApiHelper::sendNotification("cFPZ0cOZS1So55Yp1maCeR:APA91bG3GWwgF2BjRMwQi2vPbIT77U1F1aOfNez9zGEMi_iDKJMXr3NPNxXg85EOdOVKoiVr7nXvqjnbfNl6miHT8ut69jJ1E6K_PeKdsaq1twM9c6vY5NzET3AYYzmk6RphjhWDaUGV", $notification, $extraNotificationData);
            //         \Log::info("workout_video notification send." . $abc);
            //     }
            // }
            return redirect()->route('workoutvideos')->withSuccess("Added Successfully.");
        } else {
            return redirect()->route('workoutvideos')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $workout = Workoutvideos::where('id', $id)->first();
        $workoutcate = Workoutcategories::all();
        if ($workout) {
            return view('admin.workoutvideoUpdate', compact('workout', 'workoutcate'));
        } else {
            return redirect()->route('workoutvideos')->withError("Not workout video Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'status' => 'required',
            'video' => 'mimes:mp4',
        ]);
        $input = $request->only('category_id', 'title', 'status');
        if ($request->video) {
            $videoName = $request->video->store('/videos');
            $input['video'] = 'uploads/' . $videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid() . time() . '.png';
            $thumbnail = 'uploads/images/' . $imageTo;

            FFMpeg::fromDisk('videos')
                ->open($videoFrom[1])
                ->getFrameFromSeconds(1)
                ->export()
                ->toDisk('thumbnail')
                ->save($imageTo);

            $new = 'compressed' . $videoFrom[1];
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['video'] = "uploads/videos/" . $new;

            $input['thumbnail'] = $thumbnail;
        }

        $insert = Workoutvideos::where('id', $request->id)->update($input);
        if ($insert) {
            // $get_data = Workoutvideos::where('id', $request->id)->first();
            // $users = User::where('role_id', '!=', '1')->get();
            // foreach ($users as $user) {
            //     $title = "New Workout Video available!!!";
            //     $body = "New Workout Video available : " . $get_data->title . ".";
            //     $input1['type_id'] = null;
            //     $input1['title'] = $title;
            //     $input1['status'] = '0';
            //     $input1['user_id'] = $user->id;
            //     $insert = Notifications::create($input1);
            //     $notification = array('body' => $body, 'title' => $get_data->title);
            //     $extraNotificationData = array('click_action' => "workout_video", 'image' => $get_data->thumbnail);
            //     if (!empty($user->device_token)) {
            //         $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
            //         // $abc = ApiHelper::sendNotification("cFPZ0cOZS1So55Yp1maCeR:APA91bG3GWwgF2BjRMwQi2vPbIT77U1F1aOfNez9zGEMi_iDKJMXr3NPNxXg85EOdOVKoiVr7nXvqjnbfNl6miHT8ut69jJ1E6K_PeKdsaq1twM9c6vY5NzET3AYYzmk6RphjhWDaUGV", $notification, $extraNotificationData);
            //         \Log::info("workout_video notification send." . $abc);
            //     }
            // }
            return redirect()->route('workoutvideos')->withSuccess("Workoutvideo Update Successfully.");
        } else {
            return redirect()->route('workoutvideos')->withError("Updation Failed.");
        }
    }
    public function delete($id)
    {
        $workoutvideo = Workoutvideos::find($id);
        if ($workoutvideo->delete()) {
            return redirect()->route('workoutvideos')->withSuccess(" Deleted Successfully.");
        } else {
            return redirect()->route('workoutvideos')->withError("Error! Please Try Again.");
        }
    }
    public function changeWorkoutStatus(Request $request)
    {
        $workoutvideo = Workoutvideos::find($request->id);
        $workoutvideo->status = $request->status;
        $workoutvideo->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //workout category
    public function category()
    {
        $workoutcats = Workoutcategories::all();
        return view('admin.workoutCategory', compact('workoutcats'));
    }
    public function categoryAdd()
    {
        return view('admin.workoutCategoryAdd');
    }
    public function categoryPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $insert = Workoutcategories::create($input);
        if ($insert) {
            return redirect()->route('workout-category')->withSuccess("Category Added Successfully.");
        } else {
            return redirect()->route('workout-category')->withError("Not Added Successfully.");
        }
    }
    public function categoryEdit($id)
    {
        $workoutcat = Workoutcategories::where('id', $id)->first();
        if ($workoutcat) {
            return view('admin.workoutCategoryUpdate', compact('workoutcat'));
        } else {
            return redirect()->route('workout-category')->withError("Data Not Available.");
        }
    }

    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $insert = Workoutcategories::where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('workout-category')->withSuccess("Update Successfully.");
        } else {
            return redirect()->route('workout-category')->withError("Updation Failed.");
        }
    }
    public function categoryDelete($id)
    {
        $workoutcat = Workoutcategories::find($id);
        if ($workoutcat->delete()) {
            return redirect()->route('workout-category')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('workout-category')->withError("Error! Please Try Again.");
        }
    }
    public function changeWorkoutCategoryStatus(Request $request)
    {
        $workoutcat = Workoutcategories::find($request->id);
        $workoutcat->status = $request->status;
        $workoutcat->save();

        return response()->json(['success' => 'Status change successfully.']);
    }
}
