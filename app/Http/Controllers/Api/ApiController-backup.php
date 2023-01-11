<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Str;
use Hash;
use Auth;
use App\Models\User;
use App\Models\Languages;
use App\Models\Categories;
use App\Models\Servicepackages;
use App\Models\Servicecategories;
use App\Models\User_carts;
use App\Models\Settings;
use App\Models\User_queries;
use App\Models\Faqcategories;
use App\Models\Faqdatas;
use App\Models\Sliders;
use App\Models\Notifications;
use App\Models\Workoutcategories;
use App\Models\Workoutvideos;
use App\Models\User_cart_items;
use App\Models\User_orders;
use App\Models\User_order_items;
use App\Models\Nutrition_categories;
use App\Models\Nutrition_recipe_categories;
use App\Models\Nutrition_recipes;
use App\Models\User_diaries;
use App\Models\Recipe_comments;
use App\Models\Recipe_likes;
use App\Models\Nutrition_blogs;
use App\Models\Nutrition_blog_likes;
use App\Models\Nutrition_blog_comments;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_diet_datas;
use App\Models\User_completed_meals;
use App\Models\Meal;
use App\Models\User_waterlevels;
use App\Models\Addon_persons;
use App\Models\Live_videos;
use App\Models\Live_video_users;
use App\Models\User_search_keywords;
use App\Models\States;
use App\Models\Cities;
use App\Models\Sports_curriculums;
use App\Models\Ingredients;
use App\Models\Phonecodes;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Token;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Session;
use PDF;
class ApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            $rules = [
                'email'     => 'required',
                'password'  => 'required',
                'device_token'  => 'nullable',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $password = $request->password;
            $email = $request->email;
            // if (!auth()->attempt($input)) {
            //     return response()->json(['statusCode' => 999, 'message' => 'Enter Correct Password']);
            // }
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $data = auth()->user();
                if ($data->is_verify == '0') {
                    $otp = "112233";
                    // $otp = rand(100000,999999);
                    \Mail::raw('Your Verification code is: '.$otp , function ($message) use($data) {
                        $message->to($data->email)
                        ->subject("OTP");
                    });
                    $input1['otp'] = $otp;
                    $user1 =  User::where('id', $data->id)->update($input1);
                    $data['otp'] = $otp;
                    return response()->json(['statusCode' => 200, 'message' => 'OTP sent to your email.', 'data' => $data]);
                }
                // $user_tokens = auth()->user()->tokens;
                Token::where('user_id', auth()->user()->id)->update(['revoked' => true]);
                $user = User::where('id',auth()->user()->id)->update(['device_token'=>$request->device_token]);
                $data['access_token'] = auth()->user()->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Login successfully.', 'data' => $data]);
            }elseif (Auth::attempt(['phone' => $email, 'password' => $password])) {
                $data = auth()->user();
                if ($data->is_verify == '0') {
                    $otp = "112233";
                    // $otp = rand(100000,999999);
                    \Mail::raw('Your Verification code is: '.$otp , function ($message) use($data) {
                        $message->to($data->email)
                        ->subject("OTP");
                    });
                    $input1['otp'] = $otp;
                    $user1 =  User::where('id', $data->id)->update($input1);
                    $data['otp'] = $otp;
                    return response()->json(['statusCode' => 200, 'message' => 'OTP sent to your email.', 'data' => $data]);
                }
                // $user_tokens = auth()->user()->tokens;
                Token::where('user_id', auth()->user()->id)->update(['revoked' => true]);
                $user = User::where('id',auth()->user()->id)->update(['device_token'=>$request->device_token]);
                $data['access_token'] = auth()->user()->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Login successfully.', 'data' => $data]);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Oppes! You have entered invalid credentials']);
            }
            // $input = $request->only('email', 'password');
            // if (!auth()->attempt($input)) {
            //     return response()->json(['statusCode' => 999, 'message' => 'Enter Correct Password']);
            // }
            // $data = auth()->user();
            // if ($data->is_verify == '0') {
            //     $otp = "112233";
            //     // $otp = rand(100000,999999);
            //     \Mail::raw('Your Verification code is: '.$otp , function ($message) use($data) {
            //         $message->to($data->email)
            //         ->subject("OTP");
            //     });


            //     // $this->sendOtp($otp,$data->phone);
                    
            //     $input1['otp'] = $otp;
            //     $user1 =  User::where('id', $data->id)->update($input1);
            //     $data['otp'] = $otp;
            //     return response()->json(['statusCode' => 200, 'message' => 'OTP sent to your email.', 'data' => $data]);
            // }
            // // $user_tokens = auth()->user()->tokens;
            // Token::where('user_id', auth()->user()->id)->update(['revoked' => true]);
            // $user = User::where('id',auth()->user()->id)->update(['device_token'=>$request->device_token]);
            // $data['access_token'] = auth()->user()->createToken('authToken')->accessToken;
            // return response()->json(['statusCode' => 200, 'message' => 'Login successfully.', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function sendOtp($otp,$phone)
    {
        $workingkey="1201159168063308595";
        $phone=$phone;
        $message= $otp." is your OTP (One Time Password) for completing your registration on sportylife. It is usable once. Please do not share OTP with anyone.";
        
        $senderid="MSAAPP";
        $url=sprintf("http://alerts.kapsystem.com/api/web2sms.php?workingkey=%s&to=%s&sender=%s&message=%s", $workingkey, $phone,$senderid, urlencode($message));
        // $url=sprintf("http://alerts.kapsystem.com/api/web2sms.php?workingkey=".$workingkey."&to=".$phone."&sender=".$senderid."&message=".urlencode($message), $workingkey, $phone,$senderid, urlencode($message));
        // $url=sprintf("http://203.122.58.168/prepaidgetbroadcast/PrepaidGetBroadcast?userid=missionsports&pwd=user@123&msgtype=s&ctype=1&sender=".$senderid."&pno=".$phone."&msgtxt=".$message."&alert=0");
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch,CURLOPT_TIMEOUT, '3');  $content = trim(curl_exec($ch));  
        $result = curl_exec($ch);
        curl_close($ch);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, false);
        // $result = curl_exec($ch);
        // curl_close($ch);
        print_r($result);exit;
    }
    public function register(Request $request)
    {
        try {
            $rules = [
                'first_name' => ' required',
                'last_name' => ' required',
                // 'email' => 'required|email|unique:users,email',
                'email' => 'required|email',
                // 'phone' => 'numeric|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone',
                'phone' => 'numeric|regex:/^([0-9\s\-\+\(\)]*)$/',
                'dob' => 'required',
                'gender' => 'required',
                'country_code' => 'required',
                'city' => 'nullable',
                'state' => 'nullable',
                'language_id' => 'required',
                'password' => 'required|confirmed',
                'google_id' => 'nullable',
                'yahoo_id' => 'nullable',
                'weight' => 'nullable',
                'weight_type' => 'nullable',
                'height_type' => 'nullable',
                'height_feet' => 'nullable',
                'height_inch' => 'nullable',
                'refer_by' => 'nullable',
                'device_token' => 'nullable',
            ];
            $messages = [
                'first_name.required' => 'The First Name field is required.',
                'last_name.required' => 'The Last Name field is required.',
                'email.required' => 'The Email field is required.',
                'phone.numeric' => 'The Phone No. must be a number',
                'dob.required' => 'The Date of Birth field is required.',
                'gender.required' => 'The Gender field is required.',
                'language_id.required' => 'The Language field is required.',
                'password.required' => 'The Password field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $exist_user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
            if (!empty($exist_user)) {
                if ($exist_user->is_verify == '1') {
                    $exist_email = User::where('email', $request->email)->first();
                    if (!empty($exist_email)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Email already Registered.']);
                    }else{
                        return response()->json(['statusCode' => 999, 'message' => 'Mobile already Registered.']);
                    }
                    // return response()->json(['statusCode' => 999, 'message' => 'User already Registered.']);
                }
            }
            $input = $request->only('first_name','last_name', 'email', 'phone','language_id', 'dob', 'gender','city','state','weight','weight_type','height_type','height_feet','height_inch','refer_by','country_code','school_name','school_address' );
            $input['name'] = @$request->first_name.' '.@$request->last_name;
            $input['gender'] = strtolower($request->gender);
            if ($input['gender'] == "female") {
                $input['image'] = "uploads/images/dummy_female.png";
            }else{
                $input['image'] = "uploads/images/dummy_male.png";
            }
            $input['referral_code'] = "SPL".rand(100000,999999);
            if ($request->google_id) {
                $input['google_id'] = $request->google_id;
                $input['is_social'] = '1';
            }
            if ($request->yahoo_id) {
                $input['yahoo_id'] = $request->yahoo_id;
                $input['is_social'] = '1';
            }
            $input['role_id'] = '2';
            $input['is_verify'] = '0';
            $input['device_token'] = $request->device_token;
            $input['password'] = Hash::make($request->password);
            if (!empty($exist_user)) {
                $user =  $exist_user->update($input);
                $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
            }else{
                $user =  User::create($input);
            }
            // $check = array('email'=> $request->email);
            // $user =  User::updateOrCreate($check, $input);
            if ($user) {
                $otp = "112233";
                // $otp = rand(100000,999999);
                \Mail::raw('Your Verification code is: '.$otp , function ($message) use($request) {
                    $message->to($request->email)
                    ->subject("OTP");
                });
                $input1['otp'] = $otp;
                $user1 =  User::where('id', $user->id)->update($input1);
                $user['otp'] = $otp;
                $user['access_token'] = $user->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Registered Successfully.', 'data' => $user]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Registration Failed.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function languageList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Languages::where('status','1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Data Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function checkSocialSignup(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'google_id' => 'nullable',
                'yahoo_id' => 'nullable',
            ];
            $messages = [
                'first_name.required' => 'The First Name field is required.',
                'last_name.required' => 'The Last Name field is required.',
                'email.required' => 'The Email field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user_data =  User::where('email',$request->email)->where('is_social','1')->first();
            if (!empty($user_data)) {
                $user_data['login_status'] = '1';
                $user_data['access_token'] = $user_data->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Login Successfully.', 'data' => $user_data]);
            }else{
                $user_data['login_status'] = '0';
                $user_data['access_token'] = NULL;
                return response()->json(['statusCode' => 200, 'message' => 'Create an account.', 'data' => $user_data]);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function home(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $userdata =  User::where('id',auth()->user()->id)->first();
            $user_id = auth()->user()->id;
            $userdata->profile_status = '50';
            if ($userdata->height_feet) {
                $userdata->profile_status = $userdata->profile_status + 10;
            }
            if ($userdata->weight) {
                $userdata->profile_status = $userdata->profile_status + 10;
            }
            if ($userdata->city) {
                $userdata->profile_status = $userdata->profile_status + 10;
            }
            if ($userdata->state) {
                $userdata->profile_status = $userdata->profile_status + 10;
            }
            if ($userdata->image) {
                $userdata->profile_status = $userdata->profile_status + 10;
            }
            // print_r($userdata->profile_status);exit;
            $sliders =  Sliders::where('status','1')->orderBy('position','asc')->get();
            $mission =  Settings::where('type','mission')->first();
            $vision =  Settings::where('type','vision')->first();
            $category =  Categories::where('status','1')->get();
            $order_data =  User_orders::where('user_id',$user_id)->where('payment_status',"complete")->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->count();
            if (!empty($order_data)) {
                if ($order_data >= 1) {
                    $userdata->is_purchase = '1';
                }else{
                    $userdata->is_purchase = '0';
                }
            }else{
                $userdata->is_purchase = '0';
            }
            if (!empty($userdata)) {
                return response()->json(['statusCode' => 200, 'message' => ' Home .','data' => array('userdata'=> $userdata, 'sliders'=> $sliders, 'mission'=> $mission, 'vision'=> $vision, 'category'=> $category)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function userDetails(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user =  User::find(auth()->user()->id);
            if ($user) {
                $user->profile_status = '50';
                if ($user->height_feet) {
                    $user->profile_status = $user->profile_status + 10;
                }
                if ($user->weight) {
                    $user->profile_status = $user->profile_status + 10;
                }
                if ($user->city) {
                    $user->profile_status = $user->profile_status + 10;
                }
                if ($user->state) {
                    $user->profile_status = $user->profile_status + 10;
                }
                if ($user->image) {
                    $user->profile_status = $user->profile_status + 10;
                }
                $user->sport_name = "Football";
                $user->sport_image = "sports/footbal.png";
                $user->active_plan = "Basic";
                
                $package_data =  User_orders::with('packagedata','order_items.category')->where('user_id',$user->id)->where('payment_status',"complete")->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->orderBy('created_at','desc')->get();
                if (!empty($package_data)) {
                    $user->package_data = $package_data;
                    foreach ($package_data as $key => $value) {
                        $addonpackage = Servicepackages::where('parent_id',$value->packagedata->id)->first();
                        if (!empty($addonpackage)) {
                            if ($value->packagedata->addon == '1') {
                                if ($addonpackage->addon_price_type == "sport") {
                                    $value->addon_price_sport = $addonpackage->price;
                                    $value->addon_price_person = 0;
                                }else{
                                    $value->addon_price_sport = 0;
                                    $value->addon_price_person = $addonpackage->price;
                                }
                            }
                        }else{
                            $value->addon_price_sport = 0;
                            $value->addon_price_person = 0;
                        }
                    }
                }else{
                    $user->package_data = [];
                }

                $getpackage_data = $this->getUserPackage();
                if(!empty($getpackage_data[0])){
                    $user->active_plan = $getpackage_data[0]['package'][0]['package_data']['title'] ;
                }elseif($user->is_active_freetrial == '1'){
                    $user->active_plan = "Free Trial";
                }else{
                    $user->active_plan = "No Plan Active";
                }
                return response()->json(['statusCode' => 200, 'message' => 'User Details.', 'data' => $user]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'User Not Found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function getUserPackage(){
        $user = auth()->user();
        $order_data =  User_orders::where('user_id',$user->id)->where('payment_status',"complete")->orderBy('created_at','desc')->get();
        $result=array();
        if (!empty($order_data[0])) {
            foreach ($order_data as $key => $value) {
                $result[$key]=$value;
                $order_items = User_order_items::select('package_id')->where('order_primary_id',$value->id)->distinct()->get();
                $package=array();
                
                if (!empty($order_items[0])) {
                    foreach ($order_items as $key1 => $value1) {
                        $index = $value1->package_id;
                        $order_package_items = User_order_items::where('order_primary_id',$value->id)->where('package_id',$index)->orderBy("category_year_srno","desc")->get();
                        $package_detail = Servicepackages::where('id',$value1->package_id)->first();
                        
                        $addon_package_detail = Servicepackages::where('parent_id',$value1->package_id)->first();
                        $value1->package_data =  $package_detail;
                        if (!empty($addon_package_detail)) {
                            $value1->addon_package_data =  $addon_package_detail;
                            if ($value1->package_data->addon == '1') {
                                if ($addon_package_detail->addon_price_type == "sport") {
                                    $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
                                    $value1->addon_package_data->addon_price_person = 0;
                                }else{
                                    $value1->addon_package_data->addon_price_sport = 0;
                                    $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
                                }
                            }
                        }else{
                            $value1->addon_package_data =  NULL;
                        }
                        $package[$key1]=$value1;
                        $value1->expiry_date =  $order_package_items[0]['end_date'];
                        
                        $items=array();
                        foreach($order_package_items as $key2=>$value2)
                        {
                            $items[$key2]=$value2;
                        }
                        $package[$key1]['item']=$items;
                        
                        $category_detail = array();
                        foreach ($package[$key1]['item'] as $key3 => $value3) {
                            $category_detail = Servicecategories::where('id',$value3->category_id)->first();
                            $value3->category_detail =  $category_detail;
                        }
                    }
                }else{
                    if ($value->type == "addon_person" || $value->type == "addon_sport") {
                        $package_detail = Servicepackages::where('id',$value->package_id)->first();
                        $package[0]['package_data']=$package_detail;
                    }
                }
                
                 $result[$key]['package']=$package;
            }
        }
        
        return $result;
    }
    public function profileUpdate(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required',
                'first_name' => 'nullable',
                'last_name' => 'nullable',
                'dob' => 'nullable',
                'gender' => 'nullable',
                'language_id' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'weight' => 'nullable',
                'weight_type' => 'nullable',
                'height_type' => 'nullable',
                'height_feet' => 'nullable',
                'height_inch' => 'nullable',
                'image' => 'nullable',
            ];
            $messages = [
                'user_id.required' => 'The User Id field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input = $request->only('first_name','last_name', 'dob', 'gender', 'language_id','city','state','weight','weight_type','height_type','height_feet','height_inch','school_name','school_address');
            if (!empty($request->gender)) {
                $input['gender'] = strtolower($request->gender);
            }
            if (!empty($request->first_name) || !empty($request->last_name)) {
                $input['name'] = @$request->first_name.' '.@$request->last_name;
            }
            if ($request->image) {
                $imageName = $request->image->store('/images');
                $input['image'] = 'uploads/'. $imageName;
            }
            $user =  User::where('id', $request->user_id)->update($input);
            if ($user) {
                $user =  User::find($request->user_id);
                return response()->json(['statusCode' => 200, 'message' => 'Profile Update Successfully.', 'data' => $user]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Update Failed.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function forgotPassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required',
            ];
            $messages = [
                'email.required' => 'The Email field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user =  User::where('email',$request->email)->first();
            if (!empty($user)) {
                $otp = "112233";
                // $otp = rand(100000,999999);
                \Mail::raw('Your Verification code is: '.$otp , function ($message) use($request) {
                    $message->to($request->email)
                    ->subject("OTP");
                });
                $input['otp'] = $otp;
                $user =  User::where('email', $request->email)->update($input);
                if ($user) {
                    $user_data =  User::where('email',$request->email)->first();
                    return response()->json(['statusCode' => 200, 'message' => 'OTP Sent Successfully.', 'data' => $user_data]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'OTP Not Send.']);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'User Not Exists.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function verifyOtp(Request $request)
    {
        try {
            $rules = [
                'email' => 'required',
                'otp' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input = $request->only('name', 'age', 'gender', 'language_id','weight','height');
            $user =  User::where('email', $request->email)->where('otp', $request->otp)->first();
            if ($user) {
                $input['otp'] = NULL;
                $input['is_verify'] = '1';
                $user =  User::where('email', $request->email)->update($input);
                $user_data =  User::where('email',$request->email)->first();
                return response()->json(['statusCode' => 200, 'message' => 'OTP verify successfully.', 'data' => $user_data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Invalid OTP.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function changePassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required',
                'password' => 'required|confirmed',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input['password'] = Hash::make($request->password);
            $user =  User::where('email', $request->email)->update($input);
            if ($user) {
                $user_data =  User::where('email', $request->email)->first();
                return response()->json(['statusCode' => 200, 'message' => 'Password Update Successfully.', 'data' => $user_data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Updation Failed.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function logout(Request $request) {
        try {
            if (auth()->check()) {
                $request->user()->token()->revoke();
            }
            return response()->json(['statusCode' => 200, 'message' => 'You have been successfully logged out!']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 422, 'message' => $e->getMessage()]);
        }
    }
    public function contactUs(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required|numeric',
                'subject' => 'required',
                'description' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input = $request->only('user_id','subject', 'description');
            $input['status'] = 'pending';
            $data =  User_queries::create($input);
            if ($data) {
                $data =  User_queries::with('userdata')->where('id',$data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => 'Query Submit Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Submission Failed.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function pages(Request $request)
    {
        try {
            $rules = [
                // 'type' => 'required',
            ];
            $messages = [
                // 'type.required' => 'The Page Type field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Settings::whereIn('type',['privacy_policy_content','splash','app_version','app_update_message','app_service'])->get();
            if ($data[0]) {
                $arr = [];
                foreach ($data as $key => $value) {
                    $arr[$value->type] = $value->value;
                }
                return response()->json(['statusCode' => 200, 'message' => 'Page Found.','data' => $arr]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Invalid Type.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function inviteHistory(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  User::where('refer_by',auth()->user()->referral_code)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Invite History.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No History.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function faqList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Faqcategories::with('faqdata')->where('status','1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' FAQ List Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No FAQs.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function notificationList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Notifications::where('user_id',auth()->user()->id)->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if (empty($value->image)) {
                        $value->image = "uploads/images/notification_icon.png";
                    }
                }
                return response()->json(['statusCode' => 200, 'message' => 'Notification List Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Notification.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function removeNotification(Request $request)
    {
        try {
            $rules = [
                'notification_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Notifications::where('id',$request->notification_id)->where('user_id',auth()->user()->id)->first();
            if (!empty($data)) {
                $data =  Notifications::where('id',$request->notification_id)->where('user_id',auth()->user()->id)->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Notification Remove Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Notification not found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    //services start
    public function categoryList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Categories::where('status', '1')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if (!$value->image) {
                        $value['image'] = "uploads/images/demo-logo.png";
                    }
                }
                return response()->json(['statusCode' => 200, 'message' => 'Category List.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Category Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function serviceCategoryList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Servicecategories::where('status', '1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Service Category List.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Service Category Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function freeTrial(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user =  auth()->user();
            $currentdate = date("Y-m-d H:i:s");
            $freetrial_duration = Carbon::createFromFormat('Y-m-d H:i:s', $currentdate)->addDays(7);
            $user->update(['is_active_freetrial'=>'1', 'freetrial_duration'=>$freetrial_duration]);
            if (!empty($user)) {
                return response()->json(['statusCode' => 200, 'message' => 'Update Successfully.', 'data' => $user]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Updatation Failed.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function servicePackageList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $category =  Servicecategories::where('status', '1')->get();
            $data =  Servicepackages::where('status', '1')->where('id','!=','4')->where('parent_id',NULL)->get();
            if (!empty($category[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Service Packages List.', 'data' => array('category_data'=>$category, 'package_data'=>$data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Service Packages Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function servicePackageDetail(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric',
                // 'category_data' => 'required',
            ];
            $messages = [
                'id.required' => 'The Package Id field is required.',
                // 'category_data.required' => 'The Category Data field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $packagedata =  Servicepackages::where('id', $request->id)->first();
            if (!empty($packagedata)) {
                $categorydata =  Servicecategories::where('status', '1')->get();
                $currentuserpackage = "";
                $is_active_freetrial = auth()->user()->is_active_freetrial;
                // $categorydata = [];
                // $categoryids = $request->category_data;
                // foreach ($categoryids as $key => $value) {
                //     $category =  Servicecategories::where('id', $value['id'])->first();
                //     array_push($categorydata,$category);
                // }
                return response()->json(['statusCode' => 200, 'message' => 'Service Packages Details.','user_package' => $currentuserpackage,'is_active_freetrial' => $is_active_freetrial, 'data' => array('packagedata'=>$packagedata, 'category_data'=>$categorydata)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Details Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function addtoCart(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required|numeric',
                'category_data' => 'required',
                'package_id' => 'required|numeric',
                'price' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input = $request->only('user_id','package_id', 'price');
            $data =  User_carts::create($input);
            if ($data) {
                $categorydata = [];
                $categoryids = $request->category_data;
                foreach ($categoryids as $key => $value) {
                    $input1['cart_id'] = $data->id;
                    $input1['package_id'] = $request->package_id;
                    $input1['category_id'] = $value['id'];
                    $input1['category_year_srno'] = $value['value'];
                    $data1 =  User_cart_items::create($input1);
                    $category =  Servicecategories::where('id', $value['id'])->first();
                    array_push($categorydata,$category);
                }
                $data =  User_carts::with('packagedata')->where('id',$data->id)->first();
                $data->categorydata = $categorydata;
                $cart_count =  User_carts::where('user_id', $request->user_id)->count();
                return response()->json(['statusCode' => 200, 'message' => 'Item added into cart successfully.','cart_count'=> $cart_count,'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Item Not Added.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function removefromCart(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required|numeric',
                'item_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  User_carts::where('id', $request->item_id)->where('user_id', $request->user_id)->first();
            if (!empty($data)) {
                $data =  User_carts::where('id', $request->item_id)->where('user_id', $request->user_id)->delete();
                $data1 =  User_cart_items::where('cart_id', $request->item_id)->delete();
                $cart_count =  User_carts::where('user_id', $request->user_id)->count();
                return response()->json(['statusCode' => 200, 'message' => 'Item removed from cart successfully.', 'cart_count'=> $cart_count,'data' => $data]);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Item Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function userCartList(Request $request)
    {
        try {
            $rules = [
                //  'click_type' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user_id = auth()->user()->id;
            $data =  User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type',$request->click_type)->get();
            if ($data->count() > 0) {
                $cart_count =  User_carts::where('user_id', $user_id)->where('click_type',$request->click_type)->count();
                $user_data =  User::where('id', $user_id)->first();
                $settings =  Settings::where('id', "1")->where('type', "gst")->first();
                $total_price = '0';
                $addonperson = [];
                foreach ($data as $key => $value) {
                    $total_price = $total_price + $value->price;
                    $items =  User_cart_items::where('cart_id', $value->id)->orderBy('category_year_srno','asc')->get();
                    $categorydata = [];
                    foreach ($items as $key1 => $value1) {
                        $category =  Servicecategories::where('id', $value1->category_id)->first();
                        array_push($categorydata,$category);
                    }
                    $value->categorydata = $categorydata;
                    $value->packagedata->remaining_adult_count = "0";
                    $value->packagedata->remaining_kid_count = "0";
                    $existsaddon = Addon_persons::where('user_id',$user_id)->where('package_id',$value->package_id)->get();
                    
                    if ($request->type == "sport") {
                        $addon_adult_count = $value->packagedata->addon_adult_count;
                        $addon_kid_count = $value->packagedata->addon_kid_count;
                        if (!empty($existsaddon[0])) {
                            $addonperson = $existsaddon;
                           $adultcount =  $existsaddon->where('addon_type',"adult")->count();
                           if (!empty($adultcount)) {
                               $value->packagedata->remaining_adult_count = $addon_adult_count - $adultcount;
                               if ($value->packagedata->remaining_adult_count < 0) {
                                   $value->packagedata->remaining_adult_count = 0;
                               }
                            }else{
                               $value->packagedata->remaining_adult_count = $addon_adult_count ;
                           }
                           $kidcount =  $existsaddon->where('addon_type',"kid")->count();
                           if (!empty($kidcount)) {
                               $value->packagedata->remaining_kid_count = $addon_kid_count - $kidcount;
                               if ($value->packagedata->remaining_kid_count < 0) {
                                   $value->packagedata->remaining_kid_count = 0;
                               }
                            }else{
                               $value->packagedata->remaining_kid_count = $addon_kid_count ;
                           }
                        }else{
                            $value->packagedata->remaining_adult_count = $addon_adult_count ;
                            $value->packagedata->remaining_kid_count = $addon_kid_count ;
                        }
                    }else{
                        if (!empty($existsaddon[0])) {
                            $addonperson[] = $existsaddon[0];
                            $value->packagedata->remaining_adult_count = '0' ;
                            $value->packagedata->remaining_kid_count = '0' ;
                        }else{
                            $value->packagedata->remaining_adult_count = '1' ;
                            $value->packagedata->remaining_kid_count = '1' ;
                        }
                        $value->packagedata->addon_adult_count = '1' ;
                        $value->packagedata->addon_kid_count = '1' ;
                    }
                }

                $discount_amount = 0;
                if ($user_data->refer_by != NULL && $user_data->is_use_refer == 0) {
                    $referby_user =  User::where('referral_code',$user_data->refer_by)->first();
                    if (!empty($referby_user)) {
                        $refer_discount =  Settings::where('type','refer_discount')->first();
                        $discount_amount = round(($total_price * $refer_discount->value / 100),2); 
                    }
                }
                $total_price_after_discount = $total_price - $discount_amount; 
                $gst_amount = ($total_price_after_discount * $settings->value)/100;
                $final_amount = $total_price_after_discount + $gst_amount;
                $order_id = "SPL".rand(100000,999999).time();
                return response()->json(['statusCode' => 200, 'message' => 'Items List Available.',  'total_price' => round($total_price,2),'discount_amount'=>$discount_amount,'total_price_after_discount'=>$total_price_after_discount,'gst_percentage' => $settings->value,'gst_amount' => round($gst_amount,2),'final_amount' => round($final_amount,2),'cart_count' => $cart_count, 'order_id' => $order_id, 'data' => array('userdata'=> $user_data,'items'=>$data,'addonpersons'=>$addonperson),]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Items Not Found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function removePerson(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) { 
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Addon_persons::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($data)) {
                $data->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Person removed successfully.', 'data' => $data]);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function buynow(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
                'user_id' => 'required|numeric',
                // 'category_data' => 'required',
                'package_id' => 'required|numeric',
                'price' => 'required',
                'click_type' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $click_type = $request->click_type;
            $data =  Servicepackages::where('id', $request->package_id)->first();
            if (!empty($data)) {
                if ($click_type == "buynow") {
                    $pervious_cartdata =  User_carts::where('click_type',"buynow")->where('user_id', $request->user_id)->get();
                    if (!empty($pervious_cartdata[0])) {
                        foreach ($pervious_cartdata as $key => $value) {
                            $itemdata =  User_cart_items::where('cart_id', $value->id)->delete();
                        }
                        $deletecartdata =  User_carts::where('click_type',"buynow")->where('user_id', $request->user_id)->delete();
                    }
                }
                
                $input = $request->only('type','user_id','package_id', 'price');
                $input['click_type'] = $click_type;
                $cartdata =  User_carts::create($input);
                $categorydata = [];
                if ($request->type == "sport" || $request->type == "addon_sport") {
                    $categoryids = $request->category_data;
                    foreach ($categoryids as $key => $value) {
                        $input1['cart_id'] = $cartdata->id;
                        $input1['package_id'] = $request->package_id;
                        $input1['category_id'] = $value['id'];
                        $input1['category_year_srno'] = $value['value'];
                        $data1 =  User_cart_items::create($input1);
                        $category =  Servicecategories::where('id', $value['id'])->first();
                        array_push($categorydata,$category);
                    }
                }
                $data->categorydata = $categorydata;
                
                $user_data =  User::where('id', $request->user_id)->first();
                $settings =  Settings::where('type', "gst")->first();
                $total_price = $request->price;
                $discount_amount = 0;
                if ($user_data->refer_by != NULL && $user_data->is_use_refer == 0) {
                    $referby_user =  User::where('referral_code',$user_data->refer_by)->first();
                    if (!empty($referby_user)) {
                        $refer_discount =  Settings::where('type','refer_discount')->first();
                        $discount_amount = round(($total_price * $refer_discount->value / 100),2); 
                    }
                }
                
                
                $total_price_after_discount = $total_price - $discount_amount; 
                $gst_amount = ($total_price_after_discount * $settings->value)/100;
                $final_amount = $total_price_after_discount + $gst_amount;
                return response()->json(['statusCode' => 200, 'message' => 'Product Details.',  'total_price' => round($total_price,2),'discount_amount'=>$discount_amount,'total_price_after_discount'=>$total_price_after_discount,'gst_percentage' => $settings->value,'gst_amount' => round($gst_amount,2),'final_amount' => round($final_amount,2), 'data' => array('userdata'=> $user_data,'items'=>$data),]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Product Details Not Found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function addonPerson(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required',
                'addon_type' => 'required',
                'user_id' => 'required|numeric',
                'package_id' => 'required|numeric',
                'person_first_name' => 'required',
                'person_last_name' => 'required',
                'person_email' => 'required',
                'person_phone' => 'required|numeric',
                'dob' => 'required',
                'gender' => 'required',
                'city' => 'nullable',
                'state' => 'nullable',
                'weight' => 'nullable',
                'weight_type' => 'nullable',
                'height_type' => 'nullable',
                'height_feet' => 'nullable',
                'height_inch' => 'nullable',
                'language_id' => 'required',
                'relation' => 'nullable',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            // $existsaddon = Addon_persons::where('user_id',$request->user_id)->where('package_id',$request->package_id)->get();
            // if (!empty($existsaddon[0])) {
            //     $packagedata =  Servicepackages::where('id', $request->package_id)->first();
            //     $package_adultcount = $packagedata->addon_adult_count;
            //     $exists_adultcount =  $existsaddon->where('addon_type',"adult")->count();
            //     $package_kidcount = $packagedata->addon_kid_count;
            //     $exists_kidcount =  $existsaddon->where('addon_type',"kid")->count();
            //     if ($request->addon_type == "adult") {
            //         if ($exists_adultcount > 0) {
            //             if ($exists_adultcount >= $package_adultcount) {
            //                 return response()->json(['statusCode' => 999, 'message' => 'Adults Limit Reached!']);
            //             }
            //         }
            //     }
            //     if ($request->addon_type == "kid") {
            //         if ($exists_kidcount > 0) {
            //             if ($exists_kidcount >= $package_kidcount) {
            //                 return response()->json(['statusCode' => 999, 'message' => 'Kids Limit Reached!']);
            //             }
            //         }
            //     }
            // }
            $input1 = $request->only('order_id','addon_type','user_id','package_id','person_first_name','person_last_name', 'person_email', 'person_phone', 'dob', 'gender','city','state','weight','weight_type','height_type','height_feet','height_inch','language_id','relation' );
            $input1['status'] = '0';
            $data =  Addon_persons::create($input1);
            if ($input1) {
                return response()->json(['statusCode' => 200, 'message' => 'Added Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Added Successfully!']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function orderPlace(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
                'click_type' => 'required',
                'order_id' => 'required',
                'user_id' => 'required|numeric',
                'first_name' => 'nullable',
                'last_name' => 'nullable',
                'email' => 'nullable',
                'phone' => 'nullable|numeric',
                'package_id' => 'required|numeric',
                'total_price' => 'required',
                'gst_percentage' => 'required',
                'gst_amount' => 'required',
                'final_amount' => 'required',
                'category_data' => 'nullable',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $packagedata = Servicepackages::where('id', $request->package_id)->first();
            $input = $request->only('user_id','first_name','last_name', 'email', 'phone', 'package_id', 'total_price', 'gst_percentage', 'gst_amount', 'final_amount','discount_amount','click_type');
            $input['order_id'] = $request->order_id;
            $input['status'] = "1";
            $input['name'] = @$request->first_name.' '.@$request->last_name;
            $input['type'] = $request->type;
            $input['payment_status'] = "pending";
            $input['start_date'] = date('Y-m-d H:i:s');
            // $input['end_date'] = date('Y-m-d H:i:s', strtotime('+'.@$packagedata->package_duration.' years'));
            $data =  User_orders::create($input);
            if ($data) {
                if ($request->type == "sport" || $request->type == "addon_sport") {
                    if (!empty($request->category_data[0])) {
                        $categoryids = $request->category_data;
                        foreach ($categoryids as $key => $value) {
                            $input1['order_primary_id'] = $data->id;
                            $input1['order_id'] = $data->order_id;
                            $input1['package_id'] = $request->package_id;
                            $input1['category_id'] = $value['id'];
                            $input1['category_year_srno'] = $value['value'];
                            $key1 = $key + 1;
                            $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                            $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                            // $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $orderdata->created_at)->addYear($key1)->subDays(1);
                            if ($value['value'] == 1) {
                                $input1['status'] = '1';
                            }else {
                                $input1['status'] = '0';
                            }
                            $data1 =  User_order_items::create($input1);
                        }
                    }
                }
                $payment_link = route("razorpay-payment",array('orderid'=> $data->order_id));
                return response()->json(['statusCode' => 200, 'message' => 'Payment Link.','data' => $payment_link]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Link.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    //razorpay payment start
    public function razorpayPaymentPage(Request $request)
    {
        $orderdata =  User_orders::where('order_id',$request->orderid)->first();
        $user =  User::where('id',$orderdata->user_id)->first();
        $order_amount = $orderdata->final_amount;
        // $discount = 0;
        // if ($user->refer_by != NULL && $user->is_use_refer == 0) {
        //     $referby_user =  User::where('referral_code',$user->refer_by)->first();
        //     if (!empty($referby_user)) {
        //         $refer_discount =  Settings::where('type','refer_discount')->first();
        //         $discount = round(($order_amount * $refer_discount->value / 100),2); 
        //         $order_amount = $orderdata->final_amount - $discount;
        //     }
        // }
        
        $api = new Api(config('payments.razorpay_key'),config('payments.razorpay_secret'));
        $order = $api->order->create(array(
            'receipt' => $orderdata->orderid,
            'amount' => $order_amount * 100,
            'currency' => 'INR',
        ));
        $pay_orderid = $order['id'];
        $orderdata =  User_orders::where('order_id',$request->orderid)->update(array('razorpay_orderid'=>$pay_orderid));
        return view('razorpayView',compact('user','order','orderdata'));
    }
    public function razorpayPaymentcallback(Request $request)
    {
        $orderdata =  User_orders::where('razorpay_orderid',$request->razorpay_order_id)->update(array('razorpay_id'=>$request->razorpay_payment_id,'payment_status'=>"complete"));
        if (!empty($orderdata)) {
            $orderdetail =  User_orders::where('razorpay_orderid',$request->razorpay_order_id)->first();
            @$addon_person_data =  Addon_persons::where('user_id', $orderdetail->user_id)->where('order_id',$orderdetail->order_id)->update(array('cart_id'=>NULL,'status'=>'1'));
            $pervious_cartdata =  User_carts::where('user_id', $orderdetail->user_id)->where('click_type', $orderdetail->click_type)->get();
            $user =  User::where('id', $orderdetail->user_id)->first();
            if (!empty($user)) {
                $user->is_use_refer = '1';
                if ($user->is_complete_freetrial != '1') {
                    // $user->is_active_freetrial = '0';
                    $user->is_complete_freetrial = '1';
                    $user->freetrial_duration = date("Y-m-d H:i:s");
                }
                $user->save();
            }
            if (!empty($pervious_cartdata[0])) {
                foreach ($pervious_cartdata as $key => $value) {
                    $itemdata =  User_cart_items::where('cart_id', $value->id)->delete();
                }
                $deletecartdata =  User_carts::where('user_id', $orderdetail->user_id)->where('click_type', $orderdetail->click_type)->delete();
            }
            return redirect(route("razorpay-payment-data",array('status'=> '1')));
        }else{
            return redirect(route("razorpay-payment-data",array('status'=> '0')));
        }
    }
    public function razorpayPaymenturl(Request $request)
    {

        if ($request->status == '1') {
            // echo "success";
            $status = $request->status;
            return view('payment-response',compact('status'));
        }else{
            $orderdata =  User_orders::where('razorpay_orderid',$request->orderid)->update(array('razorpay_id'=>$request->payid,'payment_status'=>"failed"));
            // echo "failed";
            $status = '0';
            return view('payment-response',compact('status'));
        }
    }
    //razorpay payment end
    //services end
    // Nutritions start
    public function nutritionCategoryList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            } 
            $user_id = auth()->user()->id;
            $data =  Nutrition_categories::where('status', '1')->get();
            $todaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d'))->get();
            $yesterdaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d',strtotime("-1 day")))->get();
            $height_feet = auth()->user()->height_feet;
            $height_inch = auth()->user()->height_inch;
            $weight = auth()->user()->weight;
            $t_calorie = 0;
            $t_protein = 0;
            $t_carbs = 0;
            $t_fats = 0;
            $y_calorie = 0;
            $y_protein = 0;
            $y_carbs = 0;
            $y_fats = 0;
            $frq_id = [];
            foreach ($todaymealsdata as $key => $value) {
                $frq_id[] = $value->category_id;
                if ($value->meal_id != NULL) {
                    $mealdetail =  Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                    if (!empty($mealdetail)) {
                        $t_calorie = $t_calorie +  $mealdetail->calorie;
                        $t_protein = $t_protein + $mealdetail->protein;
                        $t_carbs = $t_carbs + $mealdetail->carbs;
                        $t_fats = $t_fats + $mealdetail->fats;
                    }
                } 
            }
            $uni_cat = array_unique($frq_id);
            $usermealdata =  Nutrition_diet_datas::where('user_id', $user_id)->first();
            if (!empty($usermealdata->diet)) {
                foreach ($usermealdata->diet as $key1 => $value1) {
                    if (in_array($value1['frequency_id'], $uni_cat)) {
                        $mealdetail =  Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                        $t_calorie = $t_calorie +  ($mealdetail->calorie * $value1['quantity']);
                        $t_protein = $t_protein + ($mealdetail->protein * $value1['quantity']);
                        $t_carbs = $t_carbs + ($mealdetail->carbs * $value1['quantity']);
                        $t_fats = $t_fats + ($mealdetail->fats * $value1['quantity']);
                    }
                }
            }
            $y_frq_id = [];
            foreach ($yesterdaymealsdata as $key => $value) {
                $y_frq_id[] = $value->category_id;
                if ($value->meal_id != NULL) {
                    $mealdetail =  Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                    if (!empty($mealdetail)) {
                        $y_calorie = $y_calorie +  $mealdetail->calorie ;
                        $y_protein = $y_protein + $mealdetail->protein ;
                        $y_carbs = $y_carbs + $mealdetail->carbs ;
                        $y_fats = $y_fats + $mealdetail->fats ;
                    }
                } 
            }
            $y_uni_cat = array_unique($y_frq_id);
            if (!empty($usermealdata->diet)) {
                foreach ($usermealdata->diet as $key1 => $value1) {
                    if (in_array($value1['frequency_id'], $y_uni_cat)) {
                        $mealdetail =  Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                        $y_calorie = $y_calorie +  ($mealdetail->calorie * $value1['quantity']);
                        $y_protein = $y_protein + ($mealdetail->protein * $value1['quantity']);
                        $y_carbs = $y_carbs + ($mealdetail->carbs * $value1['quantity']);
                        $y_fats = $y_fats + ($mealdetail->fats * $value1['quantity']);
                    }
                }
            }
            // foreach ($yesterdaymealsdata as $key => $value) {
            //     $usermealdata =  Nutrition_diet_datas::where('user_id', $user_id)->first();
            //     if (!empty($usermealdata->diet)) {
            //         foreach ($usermealdata->diet as $key1 => $value1) {
            //             $mealdetail =  Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
            //             $y_calorie = $y_calorie +  ($mealdetail->calorie * $value1['quantity']);
            //             $y_protein = $y_protein + ($mealdetail->protein * $value1['quantity']);
            //             $y_carbs = $y_carbs + ($mealdetail->carbs * $value1['quantity']);
            //             $y_fats = $y_fats + ($mealdetail->fats * $value1['quantity']);
            //         }
            //     }
            // }
            $t_waterlevel = 0;
            $y_waterlevel = 0;
            $today_waterlevel_data = User_waterlevels::where('user_id', $user_id)->where('date', date('Y-m-d'))->first();
            if (!empty($today_waterlevel_data)) {
                $t_waterlevel = $today_waterlevel_data->water_level;
            }
            $yesterday_waterlevel_data = User_waterlevels::where('user_id', $user_id)->where('date', date('Y-m-d',strtotime("-1 day")))->first();
            if (!empty($yesterday_waterlevel_data)) {
                $y_waterlevel = $yesterday_waterlevel_data->water_level; 
            }
            $nutrition_details = array('today'=> array('calorie' => $t_calorie,'protein' => $t_protein,'carbs' => $t_carbs,'fats' => $t_fats,'height_feet' => $height_feet,'height_inch' => $height_inch,'weight' => $weight, ), 'yesterday'=> array('calorie' => $y_calorie,'protein' => $y_protein,'carbs' => $y_carbs,'fats' => $y_fats,'height_feet' => $height_feet,'height_inch' => $height_inch,'weight' => $weight, ));
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Nutrition Category List.','today_waterlevel' => $t_waterlevel,'yesterday_waterlevel' => $y_waterlevel, 'data' => array('nutrition_details'=> $nutrition_details, 'category_data' => $data,)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Nutrition Category Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function nutritionRecipeList(Request $request)
    {
        try {
            $rules = [
                'keyword' => 'nullable',
                // 'limit' => 'nullable',
                // 'offset' => 'nullable',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $keyword  = $request->keyword;
            // $limit  = $request->limit ? $request->limit : '1';
            // $offset  = $request->offset ? $request->offset : '0';
            $data =  Nutrition_recipe_categories::with('nutrition_recipedata')
            ->whereHas('nutrition_recipedata',function($query) use($keyword){
                $query->where('title','LIKE','%'.$keyword.'%');
                // $query->skip($offset)->take($limit);
            })->where('status','1')->get();
            // $data =  Nutrition_recipe_categories::with('nutrition_recipedata')->where('status','1')->get()
            //         ->map(function($data) {
            //             $data->setRelation('nutrition_recipedata', $data->nutrition_recipedata->take(1));
            //             return $data;
            //         });
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Nutrition Recipes List Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Nutrition Recipes.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function nutritionRecipeListbyCategory(Request $request)
    {
        try {
            $rules = [
                'category_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_recipes::where('category_id',$request->category_id)->get();
            if (!empty($data[0])) {
                $category_data =  Nutrition_recipe_categories::where('id',$request->category_id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Nutrition Recipes List Available.','data' => array('category_data'=>$category_data, 'recipelist'=>$data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Nutrition Recipes.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function nutritionRecipeDetails(Request $request)
    {
        try {
            $rules = [
                'recipe_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_recipes::where('id',$request->recipe_id)->first();
            if (!empty($data)) {
                
                $viewcount = $data->view_count + 1;
                $updateviewcount =  Nutrition_recipes::where('id', $request->recipe_id)->update(['view_count' => $viewcount]);
                $data =  Nutrition_recipes::where('id',$request->recipe_id)->first();
                $likedata =  User_diaries::where('recipe_id',$request->recipe_id)->where('user_id',auth()->user()->id)->first();
                if (!empty($likedata)) {
                    $data->is_like = 1;
                }else{
                    $data->is_like = 0;
                }
                $favdata =  Recipe_likes::where('recipe_id',$request->recipe_id)->where('user_id',auth()->user()->id)->first();
                if (!empty($favdata)) {
                    $data->is_favourite = 1;
                }else{
                    $data->is_favourite = 0;
                }
                    $arr = [];
                    foreach ($data->ingredients as $key => $value) {
                        $ingredientsdata =  Ingredients::where('id',$value['name'])->first();
                        if (!empty($ingredientsdata)) {
                            $arr[$key]['name'] = $ingredientsdata->title;
                            $arr[$key]['quantity'] = $value['quantity'];
                        }else{
                            $arr[$key]['name'] = $value['name'];
                            $arr[$key]['quantity'] = $value['quantity'];
                        }
                    }
                    unset($data->ingredients);
                    $data->ingredients = $arr;
                return response()->json(['statusCode' => 200, 'message' => ' Recipe Details Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Recipe Details.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function addRemoveDiary(Request $request)
    {
        try {
            $rules = [
                // 'user_id' => 'required|numeric',
                'recipe_id' => 'required|numeric',
                // 'type' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_recipes::where('id',$request->recipe_id)->first();
            if (!empty($data)) {
                if (@$request->type == "favourite") {
                    $favourite_data =  Recipe_likes::where('recipe_id',$request->recipe_id)->where('user_id',auth()->user()->id)->first();
                    if (empty($favourite_data)) {
                        $input = $request->only('recipe_id');
                        $input['user_id'] = auth()->user()->id;
                        $data1 =  Recipe_likes::create($input);
                        $likecount = $data->like_count + 1;
                        $updatelikecount =  Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        if (!empty($data1)) {
                            return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Favourite Successfully.','data' => $data1]);
                        }
                        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                    }else{
                        $favourite_data->delete();
                        $likecount = $data->like_count - 1;
                        $data1 =  Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        return response()->json(['statusCode' => 200, 'message' => ' Recipe Removed From Favourite.','data' => $favourite_data]);
                    }
                }else{
                    $likedata =  User_diaries::where('recipe_id',$request->recipe_id)->where('user_id',auth()->user()->id)->first();
                    if (empty($likedata)) {
                        $input = $request->only('recipe_id');
                        $input['user_id'] = auth()->user()->id;
                        $input['status'] = '1';
                        $data1 =  User_diaries::create($input);
                        $likecount = $data->like_count + 1;
                        $updatelikecount =  Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        if (!empty($data1)) {
                            return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Diary Successfully.','data' => $data1]);
                        }
                        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                    }else{
                        $likedata->delete();
                        $likecount = $data->like_count - 1;
                        $data1 =  Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        return response()->json(['statusCode' => 200, 'message' => ' Recipe Removed From Diary.','data' => $likedata]);
                    }
                }
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Found.']);
            }
            // $input = $request->only('recipe_id');
            // $input['user_id'] = auth()->user()->id;
            // $input['status'] = '1';
            // $data =  User_diaries::create($input);
            // if (!empty($data)) {
            //     $data =  User_diaries::with('recipedata')->where('id',$data->id)->first();
            //     return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Diary Successfully.','data' => $data]);
            // }
            // return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function addRecipeComment(Request $request)
    {
        try {
            $rules = [
                'recipe_id' => 'required|numeric',
                'message' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input = $request->only('user_id','recipe_id','message');
            $input['user_id'] = auth()->user()->id;
            $input['status'] = '1';
            $data =  Recipe_comments::create($input);
            if (!empty($data)) {
                $data =  Recipe_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function shareRecipe(Request $request)
    {
        try {
            $rules = [
                'recipe_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_recipes::where('id',$request->recipe_id)->first();
            if (!empty($data)) {
                $count = $data->share_count + 1;
                $data1 =  Nutrition_recipes::where('id',$request->recipe_id)->update(['share_count'=>$count]);
                if (!empty($data1)) {
                    return response()->json(['statusCode' => 200, 'message' => ' Recipe Shared.','data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function recipeCommentList(Request $request)
    {
        try {
            $rules = [
                'recipe_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Recipe_comments::with('userdata','recipedata.recipe_categorydata')->where('recipe_id',$request->recipe_id)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Comments List.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Comments.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function nutritionBlogsList(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_blogs::where('status','1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Blogs Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Blog.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function nutritionBlogsDetails(Request $request)
    {
        try {
            $rules = [
                'blog_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_blogs::where('id',$request->blog_id)->first();
            if (!empty($data)) {
                $view_count = $data->view_count + 1;
                $data->update(['view_count'=>$view_count]);
                $likedata =  Nutrition_blog_likes::where('blog_id',$request->blog_id)->where('user_id',auth()->user()->id)->first();
                if (!empty($likedata)) {
                    $data->is_like = 1;
                }else{
                    $data->is_like = 0;
                }
                $commentlist =  Nutrition_blog_comments::with('userdata')->where('blog_id', $request->blog_id)->orderBy('created_at','desc')->get();
                $data->view_count = (string)$data->view_count;
                return response()->json(['statusCode' => 200, 'message' => ' Blog Details Available.','data' =>  array('blog_data' => $data, 'commentlist'=> $commentlist )]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Blog Details.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function likeNutritionBlog(Request $request)
    {
        try {
            $rules = [
                'blog_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_blogs::where('id',$request->blog_id)->first();
            if (!empty($data)) {
                $likedata =  Nutrition_blog_likes::where('blog_id',$request->blog_id)->where('user_id',auth()->user()->id)->first();
                if (empty($likedata)) {
                    $input = $request->only('blog_id');
                    $input['user_id'] = auth()->user()->id;
                    $data1 =  Nutrition_blog_likes::create($input);
                    if (!empty($data1)) {
                        $likecount = $data->like_count + 1;
                        $data->update(['like_count'=>$likecount]);
                        return response()->json(['statusCode' => 200, 'message' => ' Blog Liked.','data' => $data1]);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                }else{
                    $likedata->delete();
                    $likecount = $data->like_count - 1;
                    $data->update(['like_count'=>$likecount]);
                    return response()->json(['statusCode' => 200, 'message' => ' Blog Removed From Liked.','data' => $likedata]);
                }
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Nutrition blog Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function shareNutritionBlog(Request $request)
    {
        try {
            $rules = [
                'blog_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_blogs::where('id',$request->blog_id)->first();
            if (!empty($data)) {
                $count = $data->share_count + 1;
                $data1 =  Nutrition_blogs::where('id',$request->blog_id)->update(['share_count'=>$count]);
                if (!empty($data1)) {
                    return response()->json(['statusCode' => 200, 'message' => ' Nutrition Blog Shared.','data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Nutrition Blog Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function addNutritionBlogComment(Request $request)
    {
        try {
            $rules = [
                'blog_id' => 'required|numeric',
                'message' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $input = $request->only('user_id','blog_id','message');
            $input['user_id'] = auth()->user()->id;
            $input['status'] = '1';
            $data =  Nutrition_blog_comments::create($input);
            if (!empty($data)) {
                // $data =  Nutrition_blog_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function nutritionBlogCommentList(Request $request)
    {
        try {
            $rules = [
                'blog_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_blog_comments::with('userdata','blogdata')->where('blog_id',$request->blog_id)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Blog Comments List.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Comments.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function dietChart(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            // $day_name = $request->dayname;
            //  $data =  Nutrition_diet_frequencies::withCount('dietdata')->with(['dietdata'=>function($query){
            //     $query->where('user_id', '=', auth()->user()->id);
            //     // $query->where('user_id', '=', auth()->user()->id)->where('day_name',"sunday");
            //     }])
            //  ->where('status','1')
            //  ->having('dietdata_count', '>', 0)
            //  ->get();
             $data =  Nutrition_diet_datas::where('user_id', '=', auth()->user()->id)->get();
             $frqudata =  Nutrition_diet_frequencies::all();
             $mealdata =  Meal::all();
             $frqudata_arr = [];
             $mealdata_arr = [];
             foreach ($frqudata as $key => $value) {
                 $frqudata_arr[$value->id] = $value->title;
             }
             foreach ($mealdata as $key => $value) {
                 $mealdata_arr[$value->id] = $value->title;
             }
             foreach ($data as $key => $value) {
                 $customarr = [];
                 foreach ($value['diet'] as $key1 => $value1) {
                     $customarr[$value1['frequency_id']][] = $value1;  
                 }
                 $customarr1 = [];
                 foreach ($customarr as $key4 => $value4) {
                     $customarr1[ $key4]['frequency_id'] = $value4[0]['frequency_id']; 
                     $customarr1[ $key4]['frequency_name'] = $frqudata_arr[$value4[0]['frequency_id']]; 
                      $customarr2 = [];
                    foreach ($value4 as $key2 => $value2) {
                            $customarr2[$key2]['meal'] =$value2['meal']; 
                            $customarr2[$key2]['quantity'] = $value2['quantity']; 
                            $customarr2[$key2]['meal_name'] =$mealdata_arr[$value2['meal']]; 
                    }
                      $customarr1[$key4]['meal'] =   $customarr2;
                }
                  $customarr1 = array_values($customarr1);
             }
            if (!empty($data[0])) {
                $data1 = [
                    'title' => auth()->user()->name ?? 'Sportylife',
                    'date' => date('m/d/Y'),
                    'customarr1' => $customarr1
                ];
                $my_pdf_name = 'uploads/dietchart' . auth()->user()->id . '.pdf';
                $my_pdf_path = 'public/'.$my_pdf_name;
                $pdf = PDF::loadView('dietPDF', $data1)->save($my_pdf_path);
                $userdata = Auth::user();
                $userdata->dietchart_pdf = $my_pdf_name ;
                $userdata->save();
                $note = array('bowl' => '100g','cup' => '100ml','glass' => '200ml','tbsp' => '15g','tsp' => '5g');
                $pdfurl = asset(auth()->user()->dietchart_pdf);
                return response()->json(['statusCode' => 200, 'message' => ' Diet Chart Available.','data' => array('pdf'=> $pdfurl, 'note'=> $note,'diet'=>$customarr1)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Diet Chart.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function mealsCategoryList(Request $request)
    {
        try {
            $rules = [];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Nutrition_diet_frequencies::where('status', '1')->get();
            if (!empty($data[0])) {
                $addonmealcount = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('meal_id','!=',NULL)->count();
                foreach ($data as $key => $value) {
                    $is_mealcompletedata = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('category_id',$value->id)->where('meal_id',NULL)->first();
                    if (!empty($is_mealcompletedata)) {
                        $value->is_complete = "1";
                    }else{
                        $value->is_complete = "0";
                    }
                } 
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'addon_mealcount' => $addonmealcount, 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function mealsCompleted(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $currentdate = date('Y-m-d');
            $user_id = auth()->user()->id;
            if ($request->type == "addon") {
                $data =  User_completed_meals::where('user_id', $user_id)->where('date',$currentdate)->where('meal_id','!=',NULL)->delete();
                $meal_data = $request->meal_data;
                foreach ($meal_data as $key => $value) {
                    $input['user_id'] = $user_id;
                    $input['date'] = $currentdate;
                    $input['category_id'] = $value['category_id'];
                    if (!empty($value['meal_id'])) {
                        foreach ($value['meal_id'] as $key1 => $value1) {
                            $input['meal_id'] = $value1;
                            $data1 =  User_completed_meals::create($input);
                        }
                    }else{
                        $data1 =  User_completed_meals::create($input);
                    }
                }
            }else{
                $data =  User_completed_meals::where('user_id', $user_id)->where('date',$currentdate)->where('meal_id', NULL)->delete();
                $meal_data = $request->meal_data;
                foreach ($meal_data as $key => $value) {
                    $input['user_id'] = $user_id;
                    $input['date'] = $currentdate;
                    $input['category_id'] = $value['category_id'];
                    $input['meal_id'] = NULL;
                    // if (!empty($value['meal_id'])) {
                    //     foreach ($value['meal_id'] as $key1 => $value1) {
                    //         $input['meal_id'] = $value1;
                    //         $data1 =  User_completed_meals::create($input);
                    //     }
                    // }else{
                    //     $data1 =  User_completed_meals::create($input);
                    // }
                    $data1 =  User_completed_meals::create($input);
                }
            }
            // $check = array('user_id'=> $user_id, 'date' => $currentdate );
            // $data =  User_completed_meals::updateOrCreate($check, $input);
            if (!empty($data1)) {
                $data =  User_completed_meals::with('categorydata', 'mealdata')->where('date',$currentdate)->where('user_id',$user_id)->get();
                return response()->json(['statusCode' => 200, 'message' => ' Data Update Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function mealsHistory(Request $request)
    {
        try {
            $rules = [
                // 'breakfast' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user_id = auth()->user()->id;
            $data =  User_completed_meals::with('categorydata', 'mealdata')->where('user_id',$user_id)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'History Found.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function mealsDetails(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user_id = auth()->user()->id;
            $data =  User_completed_meals::with('categorydata', 'mealdata')->where('id', $request->id)->where('user_id', $user_id)->first();
            if (!empty($data)) {
                return response()->json(['statusCode' => 200, 'message' => 'History Details Found.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function mealsList(Request $request)
    {
        try {
            $rules = [
                'frequency_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Meal::where('frequency_id',$request->frequency_id)->where('status','1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function myDiary(Request $request)
    {
        try {
            $rules = [
                // 'id' => 'required|numeric',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user_id = auth()->user()->id;
            $data =  User_diaries::with('recipedata', 'userdata')->where('user_id', $user_id)->get();
            if (!empty($data)) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    // Nutritions end
    // FRC Start
    public function frc(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  auth()->user();
            if (!empty($data)) {
                if ($data->height_type == "Inch" || $data->height_type == "Feet") {
                    $height_cm = (($data->height_feet * 12) + $data->height_inch) * 2.54;
                }else{
                    $height_cm = $data->height_feet + ($data->height_inch / 10);
                }
                
                
                if($data->gender == "female"){
                    $data->ibw = number_format(($height_cm - 105),2); // ibw = height(cm) - 105
                }else{
                    $data->ibw = number_format(($height_cm - 100),2); // ibw = height(cm) - 100
                }

                $height_mtr = $height_cm / 100;
                if ($data->weight_type == "Lbs" ) {
                    $kgweight = $data->weight / 2.205;
                }else{
                    $kgweight = $data->weight;
                }
                $data->bmi = number_format(($kgweight/($height_mtr*$height_mtr)),2); // BMI = Weight(kg) /height (m)2
                $estimator = $data->bmi;
                if ($estimator < 18.5) {
                    $data->frc_category = 'Underweight';
                    $data->frc_color = 'blue'; //dark blue
                    $data->bmi_range = 'Below 18.5'; //dark blue
                }elseif ($estimator >= 18.5 && $estimator <= 24.99) {
                    $data->frc_category = 'Normal weight';
                    $data->frc_color = 'green'; //green
                    $data->bmi_range = '18.5 - 24.9'; //green
                }elseif ($estimator >= 25 && $estimator <= 29.99) {
                    $data->frc_category = 'Overweight';
                    $data->frc_color = 'yellow'; //yellow
                    $data->bmi_range = '25.0 - 29.9'; //yellow
                }elseif ($estimator >= 30 && $estimator <= 34.99) {
                    $data->frc_category = 'Obesity Class I';
                    $data->frc_color = 'orange'; //orange
                    $data->bmi_range = '30.0 - 34.9'; //orange
                }elseif ($estimator >= 35 && $estimator <= 39.99) {
                    $data->frc_category = 'Obesity Class II';
                    $data->frc_color = 'pink'; //pink
                    $data->bmi_range = '35.0 - 39.9'; //pink
                }elseif ($estimator >= 40) {
                    $data->frc_category = 'Obesity Class III';
                    $data->frc_color = 'red'; //red
                    $data->bmi_range = 'Above 40'; //red
                }

                // if ($estimator >= 18.5 && $estimator <= 22.4) {
                //     $data->frc_category = 'Normal';
                //     $data->frc_color = 'green'; //green
                //     $data->bmi_range = '18.5 - 24.9'; //green
                // }elseif ($estimator >= 22.5 && $estimator <= 29.99) {
                //     $data->frc_category = 'Overweight';
                //     $data->frc_color = 'yellow'; //yellow
                //     $data->bmi_range = '25.0 - 29.9'; //yellow
                // }elseif ($estimator >= 30 && $estimator <= 34.99) {
                //     $data->frc_category = 'Obese 1';
                //     $data->frc_color = 'orange'; //orange
                //     $data->bmi_range = '30.0 - 34.9'; //orange
                // }elseif ($estimator >= 35 && $estimator <= 39.99) {
                //     $data->frc_category = 'Obese 2 ';
                //     $data->frc_color = 'pink'; //pink
                //     $data->bmi_range = '35.0 - 39.9'; //pink
                // }elseif ($estimator >= 40) {
                //     $data->frc_category = 'Obese 3';
                //     $data->frc_color = 'red'; //red
                //     $data->bmi_range = 'Above 40'; //red
                // }
                
                return response()->json(['statusCode' => 200, 'message' => ' FRC Data.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    // FRC Start
    public function userWaterLevel(Request $request)
    {
        try {
            $rules = [
                'water_level' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user_id = auth()->user()->id;
            $currentdate = date('Y-m-d');
            $check = array('user_id'=> $user_id, 'date' => $currentdate );
            $input['water_level'] = $request->water_level;
            $data =  User_waterlevels::updateOrCreate($check, $input);
            if (!empty($data)) {
                $data1 =  User_waterlevels::with('userdata')->where('id', $data->id)->first();
                if (auth()->user()->status == "1") {
                    $data1->is_block = '0';
                }else{
                    $data1->is_block = '1';
                }
                $app_version =  Settings::where('type',"app_version")->first();
                $app_update_message =  Settings::where('type',"app_update_message")->first();
                $force_logout =  Settings::where('type',"force_logout")->first();
                $data1->app_version = $app_version->value;
                $data1->app_update_message = $app_update_message->value;
                $data1->force_logout = $force_logout->value;
                return response()->json(['statusCode' => 200, 'message' => 'Data Update Successfully.','data' => $data1]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Updatation Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function workoutVideos(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            // $currentdate_time = date("Y-m-d H:i:s");
            $currentdate_time = Carbon::now();
            $data =  Workoutcategories::with('workoutvideodata')->where('status','1')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if ($value->id == '6') {
                        unset($value->workoutvideodata);
                        // $workoutvideodata = [];
                        $recorded_video =  Live_videos::where('status','1')->whereDate('end_date_time','<=',$currentdate_time)->select('id','category_id','title','thumbnail','video','status','start_date_time','created_at','updated_at')->get();
                        foreach ($recorded_video as $key1 => $value1) {
                            $livetime = Carbon::parse($value1->start_date_time)->addMinutes(30);
                            if ($livetime <= $currentdate_time) {
                                $value->workoutvideodata[] = $value1;
                            }else{
                                $value->workoutvideodata = $recorded_video;
                            }
                        } 
                        // $value->workoutvideodata = $workoutvideodata; 
                    }
                }
                // $data = array_merge($data->toArray(), $recorded_video->toArray());
                return response()->json(['statusCode' => 200, 'message' => 'Workout Video List Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Workout Video.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function liveVideo(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $currentdate_time = date("Y-m-d H:i:s");
            // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->get();
            // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $today = Carbon::now();
            $today_name = Carbon::now()->format("l");
            if ($today_name == "Monday") {
                $nextday = Carbon::now()->addDay(2); 
                $second_nextday = Carbon::now()->addDay(4);
                $third_nextday = '';
            }
            if ($today_name == "Tuesday") {
                $nextday = Carbon::now()->addDay(1); 
                $second_nextday = Carbon::now()->addDay(3);
                $third_nextday = Carbon::now()->addDay(6);
            }
            if ($today_name == "Wednesday") {
                $nextday = Carbon::now()->addDay(2); 
                $second_nextday = Carbon::now()->addDay(5);
                $third_nextday = '';
            }
            if ($today_name == "Thursday") {
                $nextday = Carbon::now()->addDay(1); 
                $second_nextday = Carbon::now()->addDay(4);
                $third_nextday = Carbon::now()->addDay(6);
            }
            if ($today_name == "Friday") {
                $nextday = Carbon::now()->addDay(3); 
                $second_nextday = Carbon::now()->addDay(5);
                $third_nextday = '';
            }
            if ($today_name == "Saturday") {
                $nextday = Carbon::now()->addDay(2); 
                $second_nextday = Carbon::now()->addDay(4);
                $third_nextday = Carbon::now()->addDay(6);
            }
            if ($today_name == "Sunday") {
                $nextday = Carbon::now()->addDay(1); 
                $second_nextday = Carbon::now()->addDay(3);
                $third_nextday = Carbon::now()->addDay(5);
            }
            // $today = Carbon::now()->addDay(6);
            // $nextday = Carbon::now()->addDay(6)->addDay(1); 
            // $second_nextday = Carbon::now()->addDay(6)->addDay(3);
            // $third_nextday = Carbon::now()->addDay(6)->addDay(6);
            // print_r($today->format("l")); 
            // print_r($nextday->format("l"));
            // print_r($second_nextday->format("l")); 
            // print_r($third_nextday->format("l")); 
            // exit;
            $nextday_name = $nextday->format("l");
            $second_nextday_name = $second_nextday->format("l");
            if (!empty($third_nextday)) {
                $third_nextday_name = $third_nextday->format("l");
                $day_arr = [$nextday,$second_nextday,$third_nextday];
                $day_name = [$nextday_name,$second_nextday_name,$third_nextday_name];
            }else{
                $day_arr = [$today,$nextday,$second_nextday];
                $day_name = [$today_name,$nextday_name,$second_nextday_name];
            }
            // $day_arr = [$today,$nextday,$second_nextday];
            // $day_name = [$today_name,$nextday_name,$second_nextday_name];
            // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $data = [];
            foreach ($day_arr as $key1 => $value1) {
                $item_data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereDate('start_date_time', $value1)->get();
                if (!empty($item_data[0])) {
                    foreach ($item_data as $key => $value) {
                        if ($value->start_date_time <= $currentdate_time) {
                            $value->is_play = "1";
                        }else{
                            $value->is_play = "0";
                        }
                        $date = Carbon::parse($value->start_date_time);
                        $now = Carbon::now();
                        $value->difference = $date->diffInSeconds($now);
                        $value->dayname = $date->format('l');
                        $value->start_date_time = date("H:i a",strtotime($value->start_date_time));
                        $value->end_date_time = date("H:i a",strtotime($value->end_date_time));
                    }
                }
                $data[0][strval($value1->format("l"))] = $item_data;
            }
            // print_r($data);exit;
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array("day_name"=> $day_name, "video_data"=>$data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function liveVideoTest(Request $request)
    {
        try { 
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $currentdate_time = date("Y-m-d H:i:s");
            $today = Carbon::now();
            $today_name = Carbon::now()->format("l");
            if ($today_name == "Monday") {
                $nextday = Carbon::now()->addDay(2); 
                $second_nextday = Carbon::now()->addDay(4);
                $third_nextday = '';
            }
            if ($today_name == "Tuesday") {
                $nextday = Carbon::now()->addDay(1); 
                $second_nextday = Carbon::now()->addDay(3);
                $third_nextday = Carbon::now()->addDay(6);
            }
            if ($today_name == "Wednesday") {
                $nextday = Carbon::now()->addDay(2); 
                $second_nextday = Carbon::now()->addDay(5);
                $third_nextday = '';
            }
            if ($today_name == "Thursday") {
                $nextday = Carbon::now()->addDay(1); 
                $second_nextday = Carbon::now()->addDay(4);
                $third_nextday = Carbon::now()->addDay(6);
            }
            if ($today_name == "Friday") {
                $nextday = Carbon::now()->addDay(3); 
                $second_nextday = Carbon::now()->addDay(5);
                $third_nextday = '';
            }
            if ($today_name == "Saturday") {
                $nextday = Carbon::now()->addDay(2); 
                $second_nextday = Carbon::now()->addDay(4);
                $third_nextday = Carbon::now()->addDay(6);
            }
            if ($today_name == "Sunday") {
                $nextday = Carbon::now()->addDay(1); 
                $second_nextday = Carbon::now()->addDay(3);
                $third_nextday = Carbon::now()->addDay(5);
            }
            // $today = Carbon::now()->addDay(6);
            // $nextday = Carbon::now()->addDay(6)->addDay(1); 
            // $second_nextday = Carbon::now()->addDay(6)->addDay(3);
            // $third_nextday = Carbon::now()->addDay(6)->addDay(6);
            // print_r($today->format("l")); 
            // print_r($nextday->format("l"));
            // print_r($second_nextday->format("l")); 
            // print_r($third_nextday->format("l")); 
            // exit;
            $nextday_name = $nextday->format("l");
            $second_nextday_name = $second_nextday->format("l");
            if (!empty($third_nextday)) {
                $third_nextday_name = $third_nextday->format("l");
                $day_arr = [$nextday,$second_nextday,$third_nextday];
                $day_name = [$nextday_name,$second_nextday_name,$third_nextday_name];
            }else{
                $day_arr = [$today,$nextday,$second_nextday];
                $day_name = [$today_name,$nextday_name,$second_nextday_name];
            }
            // $day_arr = [$today,$nextday,$second_nextday];
            // $day_name = [$today_name,$nextday_name,$second_nextday_name];
            // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $data = [];
            foreach ($day_arr as $key1 => $value1) {
                $item_data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereDate('start_date_time', $value1)->get();
                if (!empty($item_data[0])) {
                    foreach ($item_data as $key => $value) {
                        if ($value->start_date_time <= $currentdate_time) {
                            $value->is_play = "1";
                        }else{
                            $value->is_play = "0";
                        }
                        $date = Carbon::parse($value->start_date_time);
                        $now = Carbon::now();
                        $value->difference = $date->diffInSeconds($now);
                        $value->dayname = $date->format('l');
                        $value->start_date_time = date("H:i:s",strtotime($value->start_date_time));
                        $value->end_date_time = date("H:i:s",strtotime($value->end_date_time));
                    }
                }
                $data[0][strval($value1->format("l"))] = $item_data;
            }
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array("day_name"=> $day_name, "video_data"=>$data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function liveVideoDetails(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $currentdate_time = date("Y-m-d H:i:s");
            $data =  Live_videos::where('id', $request->id)->where('status','1')->where('end_date_time','>=',$currentdate_time)->first();
            if (!empty($data)) {
                if ($data->start_date_time <= $currentdate_time) {
                    $data->is_play = "1";
                }else{
                    $data->is_play = "0";
                }
                $user = auth()->user();
                $date = Carbon::parse($data->start_date_time);
                $now = Carbon::now();
                $data->difference = $date->diffInSeconds($now);
                $data->dayname = $date->format('l');
                $data->start_date = date("l, M d, Y",strtotime($data->start_date_time)); 
                $data->start_date_time = date("H:i a",strtotime($data->start_date_time));
                $data->end_date_time = date("H:i a",strtotime($data->end_date_time));
                // $data->active_plan = "No Active Plan";
                
                $package_data =  User_orders::with('order_items.category')->where('user_id',$user->id)->where('payment_status',"complete")->whereDate('start_date','<=',date('Y-m-d'))->orderBy('created_at','desc')->get();
                if (!empty($package_data[0])) {
                    $package_data_items =  User_order_items::select('package_id')->where('order_primary_id',$package_data[0]['id'])->distinct()->get();
                    // print_r($package_data_items->toArray());exit;
                    $pack = Servicepackages::where('id',$package_data_items[0]['package_id'])->first();
                    $data->active_plan = $pack->title;
                    $data->package_data = $pack;


                    // $data->active_plan = $package_data[0]->packagedata->title;
                    // $data->package_data = $package_data;
                    // foreach ($package_data as $key => $value) {
                    //     $addonpackage = Servicepackages::where('parent_id',$value->packagedata->id)->first();
                    //     if (!empty($addonpackage)) {
                    //         if ($value->packagedata->addon == '1') {
                    //             if ($addonpackage->addon_price_type == "sport") {
                    //                 $value->addon_price_sport = $addonpackage->price;
                    //                 $value->addon_price_person = 0;
                    //             }else{
                    //                 $value->addon_price_sport = 0;
                    //                 $value->addon_price_person = $addonpackage->price;
                    //             }
                    //         }
                    //     }else{
                    //         $value->addon_price_sport = 0;
                    //         $value->addon_price_person = 0;
                    //     }
                    // }
                }else{
                    $data->active_plan = "No Active Plan";
                    $data->package_data = [];
                }
                // $data->package_data = [];

                $getpackage_data = $this->getUserPackage();
                if(!empty($getpackage_data[0])){
                    $data->active_plan = $getpackage_data[0]['package'][0]['package_data']['title'] ;
                }elseif($user->is_active_freetrial == '1'){
                    $data->active_plan = "Free Trial";
                }else{
                    $data->active_plan = "No Plan Active";
                }
                return response()->json(['statusCode' => 200, 'message' => 'Details Found.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function liveVideoUser(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required|numeric',
                'video_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  Live_videos::where('id',$request->video_id)->first();
            if (!empty($data)) {
                $data->view_count = $data->view_count + 1;
                $data->save();
                $input = $request->only('video_id','user_id');
                $check = array('user_id'=> $request->user_id, 'video_id' => $request->video_id);
                $data1 =  Live_video_users::updateOrCreate($check, $input);
                return response()->json(['statusCode' => 200, 'message' => ' Added successfully.','data' => $data1]);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function search(Request $request)
    {
        try {
            $rules = [
                'keyword' => 'nullable',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $keyword  = $request->keyword;
            $user_id = auth()->user()->id;
            if (!empty($keyword)) {
                $check = array('user_id'=> $user_id, 'title' => $keyword );
                $input['user_id'] = $user_id;
                $input['title'] = $keyword;
                $data =  User_search_keywords::updateOrCreate($check, $input);
            }
            $recipe_data =  Nutrition_recipes::where('title','LIKE','%'.$keyword.'%')->where('status','1')->select('id','title','type','uploads','thumbnail')->get();
            $blog_data =  Nutrition_blogs::where('title','LIKE','%'.$keyword.'%')->where('status','1')->select('id','title','image')->get();
            foreach ($recipe_data as $key => $value) {
                $value->search_type = "recipe";
                if ($value->type == "video") {
                    $value->image = $value->thumbnail;
                }else{
                    $value->image = $value->uploads;
                }
            }
            foreach ($blog_data as $key1 => $value1) {
                $value1->search_type = "blog";
            }
            $recent_search = User_search_keywords::where('user_id',$user_id)->get();
            $favourite_data =  Recipe_likes::with('recipedata')->where('user_id', $user_id)->get();
            if (!empty($recipe_data[0]) || !empty($blog_data[0])) {
                $data = array_merge($recipe_data->toArray(), $blog_data->toArray());
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('search_data'=>$data, 'recent_search'=> $recent_search, 'favourite_data'=> $favourite_data)]);
            }
            $data = [];
            return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('search_data'=>$data, 'recent_search'=> $recent_search, 'favourite_data'=> $favourite_data)]);
            // return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function clearSerchHistory(Request $request)
    {
        try {
            $rules = [
                // 'notification_id' => 'required|numeric',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  User_search_keywords::where('user_id',auth()->user()->id)->get();
            if (!empty($data[0])) {
                $data =  User_search_keywords::where('user_id',auth()->user()->id)->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Cleared Successfully.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function updatePassword(Request $request)
    {
        try {
            $rules = [
                'current_password' => 'required',
                'password' => 'required|confirmed',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $user = auth()->user();
            $check = Hash::check($request->current_password, $user->password);
            if ($check) {
                $input['password'] = Hash::make($request->password);
                $user =  auth()->user()->update($input);
                if ($user) {
                    $user_data =  User::where('email', $request->email)->first();
                    return response()->json(['statusCode' => 200, 'message' => 'Password Update Successfully.', 'data' => $user_data]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Updation Failed.']);
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'The current password does not match.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function sportsCurriculum(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            // $currentdate_time = date("Y-m-d H:i:s");
            $data =  Sports_curriculums::where('status','1')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if ($value->type == "sports") {
                        $category =  Servicecategories::where('id', $value->category)->first();
                        $value->category_title = $category->title;
                    }else{
                        if ($value->category == "sporty_kid_7") {
                            $value->category_title = "Sports Kid (4 to 7)";
                        }else{
                            $value->category_title = "Sports Kid (7 to 9)";
                        }
                    }
                }
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function checkFreetrialExpiry(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $data =  User::where(function ($query){
                                $query->where('freetrial_duration', '!=', NULL)
                                    ->where('freetrial_duration', '<', date("Y-m-d H:i:s"));
                            })->where('is_active_freetrial','1')->where('status','1')->get();
            if (!empty($data[0])) {
               foreach ($data as $key => $value) {
                    if ($value->freetrial_duration < date("Y-m-d H:i:s")) {
                        // $value->is_active_freetrial = '0';
                        $value->is_complete_freetrial = '1';
                        $value->freetrial_duration = date("Y-m-d H:i:s");
                        $value->save();
                    }
                }
                return response()->json(['statusCode' => 200, 'message' => 'Updated Successfully.']);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function sendLiveSessionNotification(Request $request)
    {
        try {
            $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $currentdate_time = Carbon::now();
            $add_tenmin_time = Carbon::now()->addMinutes(10);
            $add_thirtymin_time = Carbon::now()->addMinutes(30);
            $currentdate = date("Y-m-d");
            $users = User::where('id', '!=', '1')->get();
            // $data =  Live_videos::where('status','1')->where('start_date_time','=',$add_tenmin_time)->get();
            $data =  Live_videos::where(function ($query) use($add_tenmin_time, $add_thirtymin_time){
                $query->where('start_date_time', '=', $add_tenmin_time)
                    ->orWhere('start_date_time', '=', $add_thirtymin_time);
            })->where('status','1')->get();
            if (!empty($data[0])) {
               foreach ($data as $key => $value){
                   foreach ($users as $user){
                       $title = "Session Reminder!!!";
                       $body = "Your Live session ".$value->title." will start soon.";
                        $input['type_id']=NULL;
                        $input['title']=$title;
                        $input['status']='0';
                        $input['user_id']=$user->id;
                        $insert = Notifications::create($input);
                        $notification = array('body' => $body,'title' => $value->title );
                        $extraNotificationData = array('click_action' => "live_session", 'image' => $value->thumbnail );
                        if (!empty($user->device_token)) {
                            $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
                        }
                    }
                    return response()->json(['statusCode' => 200, 'message' => 'Send Successfully.']);
                }
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function getCityState(Request $request)
    {
        try {
            $rules = [
                'keyword' => 'nullable',
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }
                return response()->json(['statusCode' => 999, 'message' => $error]);
            }
            $keyword  = $request->keyword;
            $state_data =  States::where('name','LIKE','%'.$keyword.'%')->select('id','name')->orderBy('name',"asc")->get();
            $city_data =  Cities::where('name','LIKE','%'.$keyword.'%')->select('id','name')->orderBy('name',"asc")->get();
            $phonecode_data =  Phonecodes::select('id','phone_code','country_name')->orderBy('country_name',"asc")->get();
            if (!empty($state_data[0]) || !empty($city_data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('state_data'=>$state_data, 'city_data'=> $city_data, 'country_code' => $phonecode_data)]);
            }
            return response()->json(['statusCode' => 200, 'message' => 'No Data Available.','data' => array('state_data'=>$state_data, 'city_data'=> $city_data, 'country_code' => $phonecode_data)]);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    // PDF
    // public function generatePDF(Request $request)
    // {
    //     $data =  Nutrition_diet_datas::where('user_id', '=', auth()->user()->id)->get();
    //     $frqudata =  Nutrition_diet_frequencies::all();
    //     $mealdata =  Meal::all();
    //     $frqudata_arr = [];
    //     $mealdata_arr = [];
    //     foreach ($frqudata as $key => $value) {
    //         $frqudata_arr[$value->id] = $value->title;
    //     }
    //     foreach ($mealdata as $key => $value) {
    //         $mealdata_arr[$value->id] = $value->title;
    //     }
    //     foreach ($data as $key => $value) {
    //         $customarr = [];
    //         foreach ($value['diet'] as $key1 => $value1) {
    //             $customarr[$value1['frequency_id']][] = $value1;  
    //         }
    //         $customarr1 = [];
    //         foreach ($customarr as $key4 => $value4) {
    //             $customarr1[ $key4]['frequency_id'] = $value4[0]['frequency_id']; 
    //             $customarr1[ $key4]['frequency_name'] = $frqudata_arr[$value4[0]['frequency_id']]; 
    //             $customarr2 = [];
    //         foreach ($value4 as $key2 => $value2) {
    //                 $customarr2[$key2]['meal'] =$value2['meal']; 
    //                 $customarr2[$key2]['quantity'] = $value2['quantity']; 
    //                 $customarr2[$key2]['meal_name'] =$mealdata_arr[$value2['meal']]; 
    //         }
    //             $customarr1[$key4]['meal'] =   $customarr2;
    //     }
    //         $customarr1 = array_values($customarr1);
    //     }
    //     $data1 = [
    //         'title' => auth()->user()->name ?? 'Sportylife',
    //         'date' => date('m/d/Y'),
    //         'customarr1' => $customarr1
    //     ];
    //     $my_pdf_name = 'uploads/dietchart' . auth()->user()->id . '.pdf';
    //     $my_pdf_path = 'public/'.$my_pdf_name;
    //     $pdf = PDF::loadView('dietPDF', $data1)->save($my_pdf_path);
    //     $userdata = Auth::user();
    //     $userdata->dietchart_pdf = $my_pdf_name ;
    //     $userdata->save();
    //     // return $pdf->download('sportylife.pdf');
    //     return response()->download($my_pdf_path);
    // }
    // PDF
}
