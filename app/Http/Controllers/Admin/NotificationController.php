<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\Languages;
use App\Models\Servicepackages;
use App\Models\Workoutcategories;
use App\Models\User_orders;
use App\Helpers\ApiHelper;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index(Request $request)
    {
        if (empty($from_date) && !empty($to_date)) {
            return redirect()->back()->withError('From Date is required!');
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (!empty($from_date)) {
            $data = Notifications::whereDate('created_at',$from_date)->latest()->paginate(10);
        }elseif (!empty($from_date) && !empty($to_date)) {
            $data = Notifications::whereDate('created_at','<=',$from_date)->whereDate('created_at','>=',$to_date)->latest()->paginate(10);
        }else{
            $data = Notifications::latest()->paginate(10);
        }
        return view('admin.notifications.index', compact('data'));
    }

    public function add()
    {
        $users = User::where('status','1')->where('role_id','!=','1')->where('user_type','user')->get();
        $language = Languages::where('status','1')->get();
        $package =  Servicepackages::where('status', '1')->where('parent_id',NULL)->get();
        $workoutcate = Workoutcategories::where('status', '1')->get();
 
        return view('admin.notifications.create',compact('users','language','package','workoutcate'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'title' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'body' => 'required',
        ]);

        $input = $request->only('title','type');
        $type = $request->type;
        
        if($request->hasFile('image')) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/' . $imageName;
        }
        $input['data'] = $request->only('title','type', 'body');
        $input['status']='0';
        
        if ($type == "language") {
            $input['type_id']= $request->language_id;
            $users = User::where('language_id', $request->language_id)->get();
        }elseif ($type == "package") {
            $input['type_id']= $request->package_id;
            if ($request->package_id == "4") {
                $users = User::where('is_active_freetrial', '1')->get();
            }else{
                $package_data =  User_orders::where('package_id',$request->package_id)->where('payment_status',"complete")->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->select('user_id')->get();
                $users = User::whereIn('id',$package_data)->get();
            }
        }elseif ($type == "individual_user") {
            $input['type_id']= $request->user_id;
            $users = User::where('id', $request->user_id)->get();
        }elseif ($type == "live_session") {

            $input['type_id']= $request->live_session_cat;
            $user_type = $request->user_type;
            $users_data = User::where('id', '!=', '1')->get();
            $user_ids = [];
            foreach ($users_data as $key => $user) {
                $date = Carbon::parse($user->dob);
                $now = Carbon::now();
                $age = $date->diff($now)->format('%y');
                if ( !empty($user->device_token) && $user_type == "adult" && $age > 18) {
                    $user_ids[] = $user->id;
                }
                if (!empty($user->device_token) &&  $user_type != "adult" && $age <= 18) {
                    $user_ids[] = $user->id;
                }
            }
            $users = User::whereIn('id', $user_ids)->get();
        }else{
            $input['type_id']= NULL;
            $users = User::where('id', '!=', '1')->get();
        }
        if (empty($users[0])) {
            return redirect()->route('notifications-add')->withError('No Users Available For this category.');
        }    

        foreach ($users as $user){
            $input['user_id']=$user->id;
            $insert = Notifications::create($input);
            $notification = array('body' => $request->body,'title' => $request->title );
            $extraNotificationData = array('click_action' => "admin", 'image' => @$request->image );
            if (!empty($user->device_token)) {
                $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
            }
        }
        if ($insert) {
            return redirect()->route('notifications')->withSuccess('Added Successfully.');
        } else {
            return redirect()->route('notifications')->withError('Adding Failed.');
        }
    }

    public function delete($id)
    {
        $data = Notifications::find($id);
        if ($data->delete()) {
            return redirect()->route('notifications')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('notifications')->withError("Error! Please Try Again.");
        }
    }



    
}
