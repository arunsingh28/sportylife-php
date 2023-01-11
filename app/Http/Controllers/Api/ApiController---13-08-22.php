<?php
namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Addon_persons;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Faqcategories;
use App\Models\Ingredients;
use App\Models\Languages;
use App\Models\Live_videos;
use App\Models\Live_video_users;
use App\Models\Meal;
use App\Models\News_feeds;
use App\Models\News_feed_comments;
use App\Models\News_feed_likes;
use App\Models\Notifications;
use App\Models\Nutrition_blogs;
use App\Models\Nutrition_blog_comments;
use App\Models\Nutrition_blog_likes;
use App\Models\Nutrition_categories;
use App\Models\Nutrition_diet_datas;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_quotes;
use App\Models\Nutrition_recipes;
use App\Models\Nutrition_recipe_categories;
use App\Models\Phonecodes;
use App\Models\Recipe_comments;
use App\Models\Recipe_likes;
use App\Models\Servicecategories;
use App\Models\Servicepackages;
use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Sports_curriculums;
use App\Models\States;
use App\Models\User;
use App\Models\User_carts;
use App\Models\User_cart_items;
use App\Models\User_completed_meals;
use App\Models\User_diaries;
use App\Models\User_faq_datas;
use App\Models\User_orders;
use App\Models\User_order_items;
use App\Models\User_queries;
use App\Models\User_search_keywords;
use App\Models\User_waterlevels;
use App\Models\Workoutcategories;
use App\Models\Workoutvideos;
use Auth;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Laravel\Passport\Token;
use PDF;
use Razorpay\Api\Api;
use Validator;

class ApiController extends Controller
{

    // public function __construct()
    // {
    //     date_default_timezone_set('Asia/Kolkata');
    // }

    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required',
                'password' => 'required',
                'device_token' => 'nullable',
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
            if (Auth::attempt(['email' => $email,'user_type' => 'user', 'password' => $password, 'status' => "1"])) {
                $data = auth()->user();
                if ($data->is_verify == '0') {
                    $otp = "112233";
                    // $otp = rand(100000,999999);
                    $sendmobileotp = ApiHelper::sendMobileOtp($otp, $data->phone);
                    $sendemail = ApiHelper::sendEmailOtp($otp, $data->email);

                    $input1['otp'] = $otp;
                    $user1 = User::where('id', $data->id)->update($input1);
                    $data['otp'] = $otp;
                    return response()->json(['statusCode' => 200, 'message' => 'OTP sent to your email and mobile.', 'data' => $data]);
                }
                // $user_tokens = auth()->user()->tokens;
                // Token::where('user_id', auth()->user()->id)->update(['revoked' => true]);
                $user = User::where('id', auth()->user()->id)->update(['device_token' => $request->device_token]);
                $data['access_token'] = auth()->user()->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Login successfully.', 'data' => $data]);
            } elseif (Auth::attempt(['phone' => $email,'user_type' => 'user', 'password' => $password,'status' => "1"])) {
                $data = auth()->user();
                if ($data->is_verify == '0') {
                    $otp = "112233";
                    // $otp = rand(100000,999999);
                    $sendmobileotp = ApiHelper::sendMobileOtp($otp, $data->phone);
                    $sendemail = ApiHelper::sendEmailOtp($otp, $data->email);

                    $input1['otp'] = $otp;
                    $user1 = User::where('id', $data->id)->update($input1);
                    $data['otp'] = $otp;
                    return response()->json(['statusCode' => 200, 'message' => 'OTP sent to your email and mobile.', 'data' => $data]);
                }
                // $user_tokens = auth()->user()->tokens;
                // Token::where('user_id', auth()->user()->id)->update(['revoked' => true]);
                $user = User::where('id', auth()->user()->id)->update(['device_token' => $request->device_token]);
                $data['access_token'] = auth()->user()->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Login successfully.', 'data' => $data]);
            } else {
                $user = User::where('email', $email)->orWhere('phone', $email)->where('user_type', "user")->first();
                if ($user) {
                    if (!Hash::check($password, $user->password)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Login Fail, Please check your password']);
                    }
                    if ($user->status == '0') {
                        return response()->json(['statusCode' => 999, 'message' => 'Login Fail, Your account has been Deactivated. Please contect administrator.']);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Oppes! You have entered invalid credentials']);
                }else{
                    return response()->json(['statusCode' => 999, 'message' => 'User Not Found']);
                }
            }

        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
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
                'dob' => 'nullable',
                'gender' => 'required',
                'country_code' => 'required',
                'city' => 'nullable',
                'state' => 'nullable',
                'language_id' => 'required',
                'password' => 'required|confirmed|min:8',
                'google_id' => 'nullable',
                'yahoo_id' => 'nullable',
                'weight' => 'nullable|numeric',
                // 'weight' => 'nullable|numeric|regex:/^[0-9]+$/',
                'weight_type' => 'nullable',
                'height_type' => 'nullable',
                'height_feet' => 'nullable|numeric',
                'height_inch' => 'nullable|numeric',
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
            $exist_user = User::where('user_type', "user")->where('email', $request->email)->orWhere('phone', $request->phone)->first();
            if (!empty($exist_user)) {
                if ($exist_user->is_verify == '1') {
                    $exist_email = User::where('user_type', "user")->where('email', $request->email)->first();
                    if (!empty($exist_email)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Email already Registered.']);
                    } else {
                        return response()->json(['statusCode' => 999, 'message' => 'Mobile already Registered.']);
                    }
                    // return response()->json(['statusCode' => 999, 'message' => 'User already Registered.']);
                }
            }
            $input = $request->only('first_name', 'last_name', 'email', 'phone', 'language_id', 'gender', 'city', 'state', 'weight', 'weight_type', 'height_type', 'height_feet', 'height_inch', 'refer_by', 'country_code', 'school_name', 'school_address','school_unique_id','zipcode');
            $input['name'] = @$request->first_name . ' ' . @$request->last_name;
            $input['gender'] = strtolower($request->gender);
            if ($request->dob) {

                $input['dob'] = date("Y-m-d", strtotime($request->dob));
            } else {
                $input['dob'] = date("Y-m-d");

            }
            if ($input['gender'] == "female") {
                $input['image'] = "uploads/images/dummy_female.png";
            } else {
                $input['image'] = "uploads/images/dummy_male.png";
            }
            $input['referral_code'] = "SPL" . rand(100000, 999999);
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
            $input['user_type'] = 'user';
            $input['device_token'] = $request->device_token;
            $input['height_inch'] = $request->height_inch ? $request->height_inch : '00';
            $input['password_text'] = $request->password;
            $input['password'] = Hash::make($request->password);
            if (!empty($exist_user)) {
                $user = $exist_user->update($input);
                $user = User::where('user_type', "user")->where('email', $request->email)->orWhere('phone', $request->phone)->first();
            } else {
                $user = User::create($input);
            }
            // $check = array('email'=> $request->email);
            // $user =  User::updateOrCreate($check, $input);
            if ($user) {
                $otp = "112233";
                // $otp = rand(100000,999999);
                $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone);
                $sendemail = ApiHelper::sendEmailOtp($otp, $request->email);

                $input1['otp'] = $otp;
                $user1 = User::where('id', $user->id)->update($input1);
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
            $data = Languages::where('status', '1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Data Available.', 'data' => $data]);
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
            $user_data = User::where('user_type', "user")->where('email', $request->email)->where('is_social', '1')->first();
            if (!empty($user_data)) {
                $user_data['login_status'] = '1';
                $user_data['access_token'] = $user_data->createToken('authToken')->accessToken;
                return response()->json(['statusCode' => 200, 'message' => 'Login Successfully.', 'data' => $user_data]);
            } else {
                $user_data['login_status'] = '0';
                $user_data['access_token'] = null;
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
            $userdata = User::where('id', auth()->user()->id)->first();
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
            $sliders = Sliders::where('status', '1')->orderBy('position', 'asc')->get();
            $mission = Settings::where('type', 'mission')->first();
            $vision = Settings::where('type', 'vision')->first();
            $category = Categories::where('status', '1')->get();
            $order_data = User_orders::where('user_id', $user_id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->count();
            if (!empty($order_data)) {
                if ($order_data >= 1) {
                    $userdata->is_purchase = '1';
                } else {
                    $userdata->is_purchase = '0';
                }
            } else {
                $userdata->is_purchase = '0';
            }
            if (!empty($userdata->freetrial_duration)) {
                $date_from = Carbon::now();
                $date_to = Carbon::parse($userdata->freetrial_duration);
                $interval = $date_from->diffInMinutes($date_to);
                $userdata->freetrial_left_time = $interval;
            } else {
                $userdata->freetrial_left_time = null;
            }
            if (!empty($userdata)) {
                return response()->json(['statusCode' => 200, 'message' => ' Home .', 'data' => array('userdata' => $userdata, 'sliders' => $sliders, 'mission' => $mission, 'vision' => $vision, 'category' => $category)]);
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
            $user = User::find(auth()->user()->id);
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

                // $package_data =  User_orders::with('packagedata','order_items.category')->where('user_id',$user->id)->where('payment_status',"complete")->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->orderBy('created_at','desc')->get();
                // if (!empty($package_data)) {
                //     $user->package_data = $package_data;
                //     foreach ($package_data as $key => $value) {
                //         $addonpackage = Servicepackages::where('parent_id',$value->packagedata->id)->first();
                //         if (!empty($addonpackage)) {
                //             if ($value->packagedata->addon == '1') {
                //                 if ($addonpackage->addon_price_type == "sport") {
                //                     $value->addon_price_sport = $addonpackage->price;
                //                     $value->addon_price_person = 0;
                //                 }else{
                //                     $value->addon_price_sport = 0;
                //                     $value->addon_price_person = $addonpackage->price;
                //                 }
                //             }
                //         }else{
                //             $value->addon_price_sport = 0;
                //             $value->addon_price_person = 0;
                //         }
                //     }
                // }else{
                //     $user->package_data = [];
                // }

                // $family_members = User::where("parent_id", $user->id)->orderBy("first_name", 'asc')->select('id', 'parent_id', 'first_name', 'last_name', 'email', 'phone', 'dob', 'gender', 'image')->get();
                $family_members = Addon_persons::where("cart_id", NULL)->where("status", '1')->where("user_id", $user->id)->orderBy("person_first_name", 'asc')->select('id', 'user_id', 'person_first_name', 'person_last_name', 'person_email', 'person_phone', 'dob', 'gender')->get();
                foreach ($family_members as $key => $value) {
                    $value->id = $value->id;
                    $value->parent_id = $value->user_id; 
                    $value->first_name = $value->person_first_name; 
                    $value->last_name = $value->person_last_name; 
                    $value->email = $value->person_email; 
                    $value->phone = $value->person_phone; 
                    $value->dob = $value->dob; 
                    $value->gender = $value->gender; 
                    $value->image = "uploads/images/dummy_male.png"; 
                }
                $getpackage_data = $this->getUserPackage();
                // $getpackage_data_IOS = $this->getUserPackageIOS();
                $user->order_data = $getpackage_data;
                // $user->order_data_IOS = $getpackage_data_IOS;
                $user->family_members = $family_members;
                if (!empty($getpackage_data[0]['package'])) {
                    $user->active_plan = $getpackage_data[0]['package'][0]['package_data']['title'];
                } elseif ($user->is_active_freetrial == '1') {
                    $user->active_plan = "Free Trial";
                } else {
                    $user->active_plan = "No Plan Active";
                }
                $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->count();
                if (!empty($order_data)) {
                    if ($order_data >= 1) {
                        $user->is_purchase = '1';
                    } else {
                        $user->is_purchase = '0';
                    }
                } else {
                    $user->is_purchase = '0';
                }

                return response()->json(['statusCode' => 200, 'message' => 'User Details.', 'data' => $user]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'User Not Found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function getUserPackage()
    {
        $user = auth()->user();
        $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->get();
        $result = array();
        if (!empty($order_data[0])) {
            foreach ($order_data as $key => $value) {
                $result[$key] = $value;
                $order_items = User_order_items::select('package_id')->where('order_primary_id', $value->id)->distinct()->get();
                $package = array();

                if (!empty($order_items[0])) {
                    foreach ($order_items as $key1 => $value1) {
                        $index = $value1->package_id;
                        $order_package_items = User_order_items::where('order_primary_id', $value->id)->where('package_id', $index)->orderBy("category_year_srno", "desc")->get();
                        $value1->expiry_date = date("d/m/Y",strtotime($order_package_items[0]['end_date']));
                        $package_detail = Servicepackages::where('id', $value1->package_id)->first();

                        @$addon_package_detail = Servicepackages::where('parent_id', $value1->package_id)->first();

                        if (!empty($addon_package_detail)) {
                            // $value1->addon_package_data =  $addon_package_detail ;
                            // $value1->addon_package_id =  $addon_package_detail->id;
                            // if ($value1->package_data->addon == '1') {
                            if ($addon_package_detail->addon_price_type == "sport") {
                                $value1->addon_sport_package_id = $addon_package_detail->id;
                                $value1->addon_person_package_id = null;
                                // $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
                                // $value1->addon_package_data->addon_price_person = 0;
                            } else {
                                $value1->addon_sport_package_id = null;
                                $value1->addon_person_package_id = $addon_package_detail->id;
                                // $value1->addon_package_data->addon_price_sport = 0;
                                // $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
                            }
                            // }
                        } else {
                            // $value1->addon_package_data =  NULL;
                            $value1->addon_sport_package_id = null;
                            $value1->addon_person_package_id = null;
                        }
                        $value1->package_data = @$package_detail;
                        // if (!empty($addon_package_detail)) {
                        //     $value1->addon_package_data =  $addon_package_detail ;
                        //     // $value1->addon_package_id =  $addon_package_detail->id;
                        //     if ($value1->package_data->addon == '1') {
                        //         if ($addon_package_detail->addon_price_type == "sport") {
                        //             $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
                        //             $value1->addon_package_data->addon_price_person = 0;
                        //         }else{
                        //             $value1->addon_package_data->addon_price_sport = 0;
                        //             $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
                        //         }
                        //     }
                        // }else{
                        //     $value1->addon_package_data =  NULL;
                        //     // $value1->addon_package_id =  NULL;
                        // }
                        $value1->package_data = $package_detail;
                        $package[$key1] = $value1;
                        // $value1->expiry_date =  $order_package_items[0]['end_date'];

                        $items = array();
                        foreach ($order_package_items as $key2 => $value2) {
                            $items[$key2] = $value2;
                        }
                        $package[$key1]['item'] = $items;

                        $addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $index)->get();
                        $package[$key1]['addon_person_list'] = $addon_personData;

                        $category_detail = array();
                        foreach ($package[$key1]['item'] as $key3 => $value3) {
                            $category_detail = Servicecategories::where('id', $value3->category_id)->first();
                            $value3->category_detail = $category_detail;
                        }
                    }
                } else {
                    if ($value->type == "addon_person" || $value->type == "addon_sport") {
                        $package_detail = Servicepackages::where('id', $value->package_id)->first();

                        $addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $value->package_id)->get();
                        // print_r(json_encode($addon_personData));exit;
                        $package[0]['package_id'] = $package_detail->id;
                        if ($value->type == "addon_person") {
                            if ($package_detail->duration_type == "month") {
                                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $addon_personData[0]['created_at'])->addMonths($package_detail->package_duration);
                            }else{
                                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $addon_personData[0]['created_at'])->addYear($package_detail->package_duration);
                            }
                            $package[0]['expiry_date'] = @$end_date;
                            $package[0]['item'] = [];
                            $package[0]['addon_person_list'] = [];

                        }
                        $package[0]['addon_sport_package_id'] = null;
                        $package[0]['addon_person_package_id'] = null;
                        $package[0]['package_data'] = $package_detail;
                    }
                }

                $result[$key]['package'] = $package;
            }
        }

        return $result;
    }
    
    public function getUserPackageIOS()
    {
        $user = auth()->user();
        $order_data = User_orders::with("packagedata")->where('user_id', $user->id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->get();
        foreach ($order_data as $key => $value) {
            $package_data = Servicepackages::where('id', $value->parent_package_id)->first();
            $value->title = @$package_data->title ? $package_data->title : '';
        }

        // $result = array();
        // if (!empty($order_data[0])) {
        //     foreach ($order_data as $key => $value) {
        //         $result[$key] = $value;
        //         $order_items = User_order_items::select('package_id')->where('order_primary_id', $value->id)->distinct()->get();
        //         $package = array();

        //         if (!empty($order_items[0])) {
        //             foreach ($order_items as $key1 => $value1) {
        //                 $index = $value1->package_id;
        //                 $order_package_items = User_order_items::where('order_primary_id', $value->id)->where('package_id', $index)->orderBy("category_year_srno", "desc")->get();
        //                 $value1->expiry_date = date("d/m/Y",strtotime($order_package_items[0]['end_date']));
        //                 $package_detail = Servicepackages::where('id', $value1->package_id)->first();

        //                 $addon_package_detail = Servicepackages::where('parent_id', $value1->package_id)->first();

        //                 if (!empty($addon_package_detail)) {
        //                     // $value1->addon_package_data =  $addon_package_detail ;
        //                     // $value1->addon_package_id =  $addon_package_detail->id;
        //                     // if ($value1->package_data->addon == '1') {
        //                     if ($addon_package_detail->addon_price_type == "sport") {
        //                         $value1->addon_sport_package_id = $addon_package_detail->id;
        //                         $value1->addon_person_package_id = null;
        //                         // $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
        //                         // $value1->addon_package_data->addon_price_person = 0;
        //                     } else {
        //                         $value1->addon_sport_package_id = null;
        //                         $value1->addon_person_package_id = $addon_package_detail->id;
        //                         // $value1->addon_package_data->addon_price_sport = 0;
        //                         // $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
        //                     }
        //                     // }
        //                 } else {
        //                     // $value1->addon_package_data =  NULL;
        //                     $value1->addon_sport_package_id = null;
        //                     $value1->addon_person_package_id = null;
        //                 }
        //                 $value1->package_data = $package_detail;
        //                 // if (!empty($addon_package_detail)) {
        //                 //     $value1->addon_package_data =  $addon_package_detail ;
        //                 //     // $value1->addon_package_id =  $addon_package_detail->id;
        //                 //     if ($value1->package_data->addon == '1') {
        //                 //         if ($addon_package_detail->addon_price_type == "sport") {
        //                 //             $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
        //                 //             $value1->addon_package_data->addon_price_person = 0;
        //                 //         }else{
        //                 //             $value1->addon_package_data->addon_price_sport = 0;
        //                 //             $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
        //                 //         }
        //                 //     }
        //                 // }else{
        //                 //     $value1->addon_package_data =  NULL;
        //                 //     // $value1->addon_package_id =  NULL;
        //                 // }
        //                 $value1->package_data = $package_detail;
        //                 $package[$key1] = $value1;
        //                 // $value1->expiry_date =  $order_package_items[0]['end_date'];

        //                 $items = array();
        //                 foreach ($order_package_items as $key2 => $value2) {
        //                     $items[$key2] = $value2;
        //                 }
        //                 $package[$key1]['item'] = $items;

        //                 $addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $index)->get();
        //                 $package[$key1]['addon_person_list'] = $addon_personData;

        //                 $category_detail = array();
        //                 foreach ($package[$key1]['item'] as $key3 => $value3) {
        //                     $category_detail = Servicecategories::where('id', $value3->category_id)->first();
        //                     $value3->category_detail = $category_detail;
        //                 }
        //             }
        //         } else {
        //             if ($value->type == "addon_person" || $value->type == "addon_sport") {
        //                 $package_detail = Servicepackages::where('id', $value->package_id)->first();

        //                 $addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $value->package_id)->get();
        //                 // print_r(json_encode($addon_personData));exit;
        //                 $package[0]['package_id'] = $package_detail->id;
        //                 if ($value->type == "addon_person") {
        //                     if ($package_detail->duration_type == "month") {
        //                         $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $addon_personData[0]['created_at'])->addMonths($package_detail->package_duration);
        //                     }else{
        //                         $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $addon_personData[0]['created_at'])->addYear($package_detail->package_duration);
        //                     }
        //                     $package[0]['expiry_date'] = @$end_date;
        //                     $package[0]['item'] = [];
        //                     $package[0]['addon_person_list'] = [];

        //                 }
        //                 $package[0]['addon_sport_package_id'] = null;
        //                 $package[0]['addon_person_package_id'] = null;
        //                 $package[0]['package_data'] = $package_detail;
        //             }
        //         }

        //         $result[$key]['package'] = $package;
        //     }
        // }

        return $order_data;
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
                'weight' => 'nullable|numeric',
                'weight_type' => 'nullable',
                'height_type' => 'nullable',
                'height_feet' => 'nullable|numeric',
                'height_inch' => 'nullable|numeric',
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
            $input = $request->only('first_name', 'last_name', 'gender', 'language_id', 'city', 'state', 'weight', 'weight_type', 'height_type', 'height_feet', 'height_inch', 'school_name', 'school_address','school_unique_id','zipcode');
            $input['dob'] = date("Y-m-d", strtotime($request->dob));
            if (!empty($request->gender)) {
                $input['gender'] = strtolower($request->gender);
            }
            if (!empty($request->first_name) || !empty($request->last_name)) {
                $input['name'] = @$request->first_name . ' ' . @$request->last_name;
            }
            if ($request->image) {
                $imageName = $request->image->store('/images');
                $input['image'] = 'uploads/' . $imageName;
            }
            $input['height_inch'] = $request->height_inch ? $request->height_inch : '00';

            $user = User::where('id', $request->user_id)->update($input);
            if ($user) {
                $user = User::find($request->user_id);
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
            $user = User::where('user_type', "user")->where('email', $request->email)->first();
            if (!empty($user)) {
                $otp = "112233";
                // $otp = rand(100000,999999);
                $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone);
                $sendemail = ApiHelper::sendEmailOtp($otp, $request->email);

                $input['otp'] = $otp;
                $user = User::where('user_type', "user")->where('email', $request->email)->update($input);
                if ($user) {
                    $user_data = User::where('user_type', "user")->where('email', $request->email)->first();
                    return response()->json(['statusCode' => 200, 'message' => 'OTP Sent Successfully.', 'data' => $user_data]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'OTP Not Send.']);
            } else {
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
            $input = $request->only('name', 'age', 'gender', 'language_id', 'weight', 'height');
            $user = User::where('user_type', "user")->where('email', $request->email)->where('otp', $request->otp)->first();
            if ($user) {
                $input['otp'] = null;
                $input['is_verify'] = '1';
                $user = User::where('user_type', "user")->where('email', $request->email)->update($input);
                $user_data = User::where('user_type', "user")->where('email', $request->email)->first();
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
                'password' => 'required|confirmed|min:8',
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
            $input['password_text'] = $request->password;
            $input['password'] = Hash::make($request->password);
            $user = User::where('user_type', "user")->where('email', $request->email)->update($input);
            if ($user) {
                $user_data = User::where('user_type', "user")->where('email', $request->email)->first();
                return response()->json(['statusCode' => 200, 'message' => 'Password Update Successfully.', 'data' => $user_data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Updation Failed.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function logout(Request $request)
    {
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
                'name' => 'required',
                'phone' => 'required',
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
            $input = $request->only('user_id', 'name', 'phone', 'subject', 'description');
            $input['status'] = 'pending';
            $data = User_queries::create($input);
            if ($data) {
                $email = "support@sportylife.in";
                $subject = $request->subject;
                $mail_res = \Mail::send('sendEnquiryMail',
                    ['name' => $request->name, 'phone' => $request->phone, 'subject' => $request->subject, 'description' => $request->description],
                    function ($message) use ($email, $subject) {
                        $message->to($email)
                            ->subject($subject);
                    }
                );

                $data = User_queries::with('userdata')->where('id', $data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => 'Query Submit Successfully.', 'data' => $data]);
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
            $data = Settings::whereIn('type', ['privacy_policy_content', 'splash', 'app_version', 'app_update_message', 'app_service'])->get();
            if ($data[0]) {
                $arr = [];
                foreach ($data as $key => $value) {
                    $arr[$value->type] = $value->value;
                }
                return response()->json(['statusCode' => 200, 'message' => 'Page Found.', 'data' => $arr]);
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
            $data = User::where('refer_by', auth()->user()->referral_code)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Invite History.', 'data' => $data]);
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
            $user_id = auth()->user()->id;
            $data = Faqcategories::with('faqdata')->where('status', '1')->get();
            if (!empty($data[0])) {

                foreach ($data as $key => $value) {
                    foreach ($value->faqdata as $key1 => $value1) {
                        $getData = User_faq_datas::where('user_id', $user_id)->where('faq_id', $value1->id)->first();
                        if (!empty($getData)) {
                            $value1->faq_user_response = $getData->response;
                        } else {
                            $value1->faq_user_response = null;
                        }

                    }
                }

                return response()->json(['statusCode' => 200, 'message' => ' FAQ List Available.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No FAQs.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function faqUpdateResponse(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required|numeric',
                'faq_id' => 'required',
                'response' => 'required',
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

            $getData = User_faq_datas::where('user_id', $request->user_id)->where('faq_id', $request->faq_id)->first();
            if (!empty($getData)) {
                $getData->response = $request->response;
                $getData->save();
                $data = User_faq_datas::where('user_id', $request->user_id)->where('faq_id', $request->faq_id)->first();
            } else {
                $input = $request->only('user_id', 'faq_id', 'response');
                $data = User_faq_datas::create($input);
            }
            if ($data) {
                return response()->json(['statusCode' => 200, 'message' => 'Submit Successfully.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Submission Failed.']);
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
            $data = Notifications::where('user_id', auth()->user()->id)->orderBy("created_at","DESC")->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if (empty($value->image)) {
                        $value->image = "uploads/images/notification_icon.png";
                    }
                    $value->created_at = date("d-m-Y H:i:s", strtotime($value->created_at));
                }
                return response()->json(['statusCode' => 200, 'message' => 'Notification List Available.', 'data' => $data]);
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
                'notification_id' => 'nullable|numeric',
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
            if ($request->type == "all") {
                $data = Notifications::where('user_id', auth()->user()->id)->get();
                if (!empty($data[0])) {
                    $data = Notifications::where('user_id', auth()->user()->id)->delete();
                    return response()->json(['statusCode' => 200, 'message' => 'Notification Remove Successfully.', 'data' => []]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Notification not found.']);
            }else{
                $data = Notifications::where('id', $request->notification_id)->where('user_id', auth()->user()->id)->first();
                if (!empty($data)) {
                    $data = Notifications::where('id', $request->notification_id)->where('user_id', auth()->user()->id)->delete();
                    return response()->json(['statusCode' => 200, 'message' => 'Notification Remove Successfully.', 'data' => $data]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Notification not found.']);
            }
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
            $data = Categories::where('status', '1')->get();
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
            $data = Servicecategories::where('status', '1')->get();
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
            $user = auth()->user();
            $currentdate = date("Y-m-d H:i:s");
            $freetrial_duration = Carbon::createFromFormat('Y-m-d H:i:s', $currentdate)->addDays(7);
            $user->update(['is_active_freetrial' => '1', 'freetrial_duration' => $freetrial_duration]);
            if (!empty($user)) {
                return response()->json(['statusCode' => 200, 'message' => 'Update Successfully.', 'data' => $user]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Updatation Failed.']);
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
            $input = $request->only('user_id', 'package_id', 'price');
            $data = User_carts::create($input);
            if ($data) {
                $categorydata = [];
                $categoryids = $request->category_data;
                if (!empty($categoryids[0])) {
                    $categoryids = $request->category_data;
                }else{
                    $categoryids = array("id"=>'1',"value"=>'1');
                }
                foreach ($categoryids as $key => $value) {
                    $input1['cart_id'] = $data->id;
                    $input1['package_id'] = $request->package_id;
                    $input1['category_id'] = $value['id'];
                    $input1['category_year_srno'] = $value['value'];
                    $data1 = User_cart_items::create($input1);
                    $category = Servicecategories::where('id', $value['id'])->first();
                    array_push($categorydata, $category);
                }
                $data = User_carts::with('packagedata')->where('id', $data->id)->first();
                $data->categorydata = $categorydata;
                $cart_count = User_carts::where('user_id', $request->user_id)->count();
                return response()->json(['statusCode' => 200, 'message' => 'Item added into cart successfully.', 'cart_count' => $cart_count, 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Item Not Added.']);
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
            $category = Servicecategories::where('status', '1')->get();
            $data = Servicepackages::where('package_type', 'android')->where('status', '1')->where('id', '!=', '4')->where('parent_id', null)->get();
            if (!empty($category[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Service Packages List.', 'data' => array('category_data' => $category, 'package_data' => $data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Service Packages Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    
    public function servicePackageListIOS(Request $request)
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
            $category = Servicecategories::where('status', '1')->get();
            $data = Servicepackages::where('package_type', 'ios')->where('status', '1')->where('id', '!=', '4')->where('parent_id', null)->get();
            if (!empty($category[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Service Packages List.', 'data' => array('category_data' => $category, 'package_data' => $data)]);
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
            $packagedata = Servicepackages::where('id', $request->id)->first();
            if (!empty($packagedata)) {
                $categorydata = Servicecategories::where('status', '1')->get();
                $currentuserpackage = "";
                $is_active_freetrial = auth()->user()->is_active_freetrial;
                // $categorydata = [];
                // $categoryids = $request->category_data;
                // foreach ($categoryids as $key => $value) {
                //     $category =  Servicecategories::where('id', $value['id'])->first();
                //     array_push($categorydata,$category);
                // }
                return response()->json(['statusCode' => 200, 'message' => 'Service Packages Details.', 'user_package' => $currentuserpackage, 'is_active_freetrial' => $is_active_freetrial, 'data' => array('packagedata' => $packagedata, 'category_data' => $categorydata)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Details Not Available.']);
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
            $data = Servicepackages::where('id', $request->package_id)->first();
            
            if (!empty($data)) {
                if ($request->type == "sport") {
                    if ($request->device_type != "ios") {
                        $categoryids = $request->category_data;
                        if (count($categoryids) > 1) {
                            $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                            if (empty($servicepackages_data)) {
                                return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
                            }
                        }
                    }
                }

                if ($request->type == "addon_sport") {
                    $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                    if (empty($servicepackages_data)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
                    }
                }

                if ($request->type == "addon_person") {
                    $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
                    if (empty($servicepackages_data)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Can not add more person at this time!']);
                    }
                }

                if ($click_type == "buynow") {
                    $pervious_cartdata = User_carts::where('click_type', "buynow")->where('user_id', $request->user_id)->get();
                    if (!empty($pervious_cartdata[0])) {
                        foreach ($pervious_cartdata as $key => $value) {
                            $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                        }
                        $deletecartdata = User_carts::where('click_type', "buynow")->where('user_id', $request->user_id)->delete();
                    }
                }

                if ($click_type == "cart") {
                    $pervious_cartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->get();
                    // $pervious_cartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->where('package_id', $request->package_id)->get();
                    if (!empty($pervious_cartdata[0])) {
                        foreach ($pervious_cartdata as $key => $value) {
                            $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                        }
                        $deletecartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->delete();
                        // $deletecartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->where('package_id', $request->package_id)->delete();
                    }
                }

                $input = $request->only('type', 'user_id');
                $input['click_type'] = $click_type;
                if ($request->type == "addon_person" || $request->type == "addon_sport") {
                    $input['price'] = $servicepackages_data->price;
                    $input['package_id'] = $servicepackages_data->id;
                    $input['parent_package_id'] = $request->package_id;
                } else {
                    $input['price'] = $request->price;
                    $input['package_id'] = $request->package_id;
                    $input['parent_package_id'] = $request->package_id;
                }
                $cartdata = User_carts::create($input);
                $categorydata = [];
                if ($request->type == "sport" || $request->type == "addon_sport") {
                    if ($request->device_type != "ios") {
                        $categoryids = $request->category_data;
                        if (!empty($categoryids[0])) {
                            $categoryids = $request->category_data;
                        }else{
                            $categoryids[] = array("id" => '1',"value" => '1' );
                        }
                        $i = 1;
                        foreach ($categoryids as $key => $value) {
                            $input1['cart_id'] = $cartdata->id;
                            $input1['package_id'] = $request->package_id;
                            $input1['category_id'] = $value['id'];
                            $input1['category_year_srno'] = $value['value'];
    
                            if ($i > 1) {
                                $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                                if (!empty($servicepackages_data)) {
                                    $input1['sport_price'] = $servicepackages_data->price;
                                } else {
                                    return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
                                }
                            } else {
                                $input1['sport_price'] = '0';
                            }
    
                            $data1 = User_cart_items::create($input1);
                            $category = Servicecategories::where('id', $value['id'])->first();
                            array_push($categorydata, $category);
                            $i++;
                        }
                    }
                }
                $data->categorydata = @$categorydata;

                $user_data = User::where('id', $request->user_id)->first();
                $settings = Settings::where('type', "gst")->first();
                $total_price = $request->price;
                $discount_amount = 0;
                if ($user_data->refer_by != null && $user_data->is_use_refer == 0) {
                    $referby_user = User::where('referral_code', $user_data->refer_by)->first();
                    if (!empty($referby_user)) {
                        $refer_discount = Settings::where('type', 'refer_discount')->first();
                        $discount_amount = round(($total_price * $refer_discount->value / 100), 2);
                    }
                }

                $total_price_after_discount = $total_price - $discount_amount;
                $gst_amount = ($total_price_after_discount * $settings->value) / 100;
                $final_amount = $total_price_after_discount + $gst_amount;

                $amountdetails = array('total_price' => round($total_price, 2), 'gst_percentage' => $settings->value, 'gst_amount' => round($gst_amount, 2), 'final_amount' => round($final_amount, 2), 'discount_amount' => $discount_amount, 'total_price_after_discount' => $total_price_after_discount, 'click_type' => $click_type);

                return response()->json(['statusCode' => 200, 'message' => 'Product Details.', 'data' => array('amountdetails' => $amountdetails, 'userdata' => $user_data, 'items' => $data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Product Details Not Found.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function userCartList(Request $request)
    {
        try {
            $rules = [
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
            $user_id = auth()->user()->id;
            $order_id = "SPL" . rand(100000, 999999) . time();
            $data = User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', $request->click_type)->get();
            if ($data->count() > 0) {   
                $cart_count = User_carts::where('user_id', $user_id)->where('click_type', $request->click_type)->count();
                $user_data = User::where('id', $user_id)->first();
                $settings = Settings::where('id', "1")->where('type', "gst")->first();
                $total_price = '0';
                $addonperson = [];
                foreach ($data as $key => $value) {
                    $total_price = $total_price + $value->price;
                    $items = User_cart_items::where('cart_id', $value->id)->orderBy('category_year_srno', 'asc')->get();
                    $categorydata = [];
                    foreach ($items as $key1 => $value1) {
                        $category = Servicecategories::where('id', $value1->category_id)->first();

                        $category->sport_price = $value1->sport_price;
                        $total_price = $total_price + $category->sport_price;

                        array_push($categorydata, $category);
                    }
                    $value->categorydata = $categorydata;

                    $existsaddon = Addon_persons::where('cart_id', $value->id)->where('user_id', $user_id)->orderBy("created_at", "asc")->get();
                    foreach ($existsaddon as $key2 => $value2) {
                        $total_price = $total_price + $value2->person_price;
                    }
                    @$update_addon = Addon_persons::where('cart_id', $value->id)->where('user_id', $user_id)->orderBy("created_at", "asc")->update(['order_id' => $order_id]);
                    $addonperson = $existsaddon;
                    $value->addonperson = $existsaddon;
                    $value->order_id = $order_id;
                }

                $discount_amount = 0;
                if ($user_data->refer_by != null && $user_data->is_use_refer == 0) {
                    $referby_user = User::where('referral_code', $user_data->refer_by)->first();
                    if (!empty($referby_user)) {
                        $refer_discount = Settings::where('type', 'refer_discount')->first();
                        $discount_amount = round(($total_price * $refer_discount->value / 100), 2);
                    }
                }
                $total_price_after_discount = $total_price - $discount_amount;
                $gst_amount = ($total_price_after_discount * $settings->value) / 100;
                $final_amount = $total_price_after_discount + $gst_amount;
                $update_cart = User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', $request->click_type)->orderBy('created_at', "desc")->update(['order_id' => $order_id]);

                $amountdetails = array('total_price' => round($total_price, 2), 'gst_percentage' => $settings->value, 'gst_amount' => round($gst_amount, 2), 'final_amount' => round($final_amount, 2), 'discount_amount' => $discount_amount, 'total_price_after_discount' => $total_price_after_discount, 'cart_count' => $cart_count, 'order_id' => $order_id);

                // return response()->json(['statusCode' => 200, 'message' => 'Items List Available.',  'total_price' => round($total_price,2),'discount_amount'=>$discount_amount,'total_price_after_discount'=>$total_price_after_discount,'gst_percentage' => $settings->value,'gst_amount' => round($gst_amount,2),'final_amount' => round($final_amount,2),'cart_count' => $cart_count, 'order_id' => $order_id, 'data' => array('userdata'=> $user_data,'items'=>$data),]);
                return response()->json(['statusCode' => 200, 'message' => 'Items List Available.', 'data' => array('amountdetails' => $amountdetails, 'userdata' => $user_data, 'items' => $data)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Items Not Found.']);
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
            $data = User_carts::where('id', $request->item_id)->where('click_type', $request->click_type)->where('user_id', $request->user_id)->first();
            if (!empty($data)) {
                $data = User_carts::where('id', $request->item_id)->where('click_type', $request->click_type)->where('user_id', $request->user_id)->delete();
                $data1 = User_cart_items::where('cart_id', $request->item_id)->delete();
                $cart_count = User_carts::where('user_id', $request->user_id)->where('click_type', $request->click_type)->count();
                return response()->json(['statusCode' => 200, 'message' => 'Item removed from cart successfully.', 'cart_count' => $cart_count, 'data' => $data]);
            } else {
                return response()->json(['statusCode' => 999, 'message' => 'Item Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    public function addSport(Request $request)
    {
        try {
            $rules = [
                'cart_id' => 'required',
                'package_id' => 'required',
                'category_data' => 'required',
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

            $user = Auth::user();
            $cartdata = User_carts::where('id', $request->cart_id)->where('user_id', $user->id)->first();
            $categoryids = $request->category_data;
            if (count($categoryids) > 1) {
                $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                if (empty($servicepackages_data)) {
                    return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
                }
            }
            if (!empty($cartdata)) {
                $cartitemdata = User_cart_items::where('cart_id', $request->cart_id)->where('package_id', $request->package_id)->get();
                $itemdata = User_cart_items::where('cart_id', $request->cart_id)->where('package_id', $request->package_id)->delete();
                $i = 1;
                foreach ($categoryids as $key => $value) {
                    $key1 = $key + 1;
                    $input1['cart_id'] = $request->cart_id;
                    $input1['package_id'] = $request->package_id;
                    $input1['category_id'] = $value['id'];
                    $input1['category_year_srno'] = $value['value'];
                    if ($i > 1) {
                        $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                        if (!empty($servicepackages_data)) {
                            $input1['sport_price'] = $servicepackages_data->price;
                        } else {
                            return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
                        }
                    } else {
                        $input1['sport_price'] = '0';
                    }
                    $data1 = User_cart_items::create($input1);
                    $i++;
                }
                return response()->json(['statusCode' => 200, 'message' => 'Sport Added Successfully.', 'data' => $data1]);
            } else {
                return response()->json(['statusCode' => 999, 'message' => 'Addition Failed.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function searchUser(Request $request)
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
            $keyword = $request->keyword;
            $user_id = auth()->user()->id;
            if ($keyword) {
                $user_data = User::where('user_type', "user")->where('email', 'LIKE',  $keyword)->orWhere('phone', 'LIKE', $keyword)->orWhere('name', 'LIKE', $keyword)->where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'parent_id', 'role_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'dob', 'gender', 'image')->get();
                // $user_data = User::where('user_type', "user")->where('email', 'LIKE', '%' . $keyword . '%')->orWhere('phone', 'LIKE', '%' . $keyword . '%')->where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'parent_id', 'role_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'dob', 'gender', 'image')->get();
                foreach ($user_data as $key => $value) {
                    $date = Carbon::parse($value->dob);
                    $now = Carbon::now();
                    $age = $date->diff($now)->format('%y years');
                    if ($age > 18) {
                        $value->addon_type = "adult";

                    } else {
                        $value->addon_type = "kid";

                    }
                }
            } else {
                $user_data = User::where('user_type', "user")->where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'parent_id', 'role_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'dob', 'gender', 'image')->get();
                foreach ($user_data as $key => $value) {
                    $date = Carbon::parse($value->dob);
                    $now = Carbon::now();
                    $age = $date->diff($now)->format('%y years');
                    if ($age > 18) {
                        $value->addon_type = "adult";

                    } else {
                        $value->addon_type = "kid";

                    }
                }
            }
            if (!empty($user_data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => $user_data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Available.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function addonPerson(Request $request)
    {
        try {
            $rules = [
                'member_type' => 'nullable',
                'type' => 'required',
                'cart_id' => 'required',
                'order_id' => 'required',
                'addon_type' => 'required',
                'user_id' => 'required|numeric',
                'package_id' => 'required|numeric',
                'person_first_name' => 'nullable',
                'person_last_name' => 'nullable',
                'person_email' => 'nullable',
                'person_phone' => 'nullable|numeric',
                'dob' => 'nullable',
                'gender' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'weight' => 'nullable|numeric|regex:/^[0-9]+$/',
                'weight_type' => 'nullable',
                'height_type' => 'nullable',
                'height_feet' => 'nullable|numeric|regex:/^[0-9]+$/',
                'height_inch' => 'nullable|numeric|regex:/^[0-9]+$/',
                'language_id' => 'nullable',
                'relation' => 'nullable',
                'device_type' => 'nullable',
                'password' => 'nullable|min:8',
                
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

            if ($request->member_type == "existing") {
                $existing_userdata = User::where("id", $request->existing_userid)->first();
                $input1 = $request->only('order_id', 'addon_type', 'user_id', 'parent_package_id', 'package_id', 'relation', 'cart_id', 'member_type', 'existing_userid');

                $email = $existing_userdata->email;
                $phone = $existing_userdata->phone;
                $is_exist_in_addon = Addon_persons::where('person_email', $email)->orWhere('person_phone', $phone)->where('status', '1')->where('cart_id', '=', null)->first();
                if (!empty($is_exist_in_addon)) {
                    $is_exist_addon_email = Addon_persons::where('person_email', $email)->where('status', '1')->where('cart_id', '=', null)->first();
                    if (!empty($is_exist_addon_email)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Addon Email already Registered.']);
                    } else {
                        return response()->json(['statusCode' => 999, 'message' => 'Addon Mobile already Registered.']);
                    }
                }

                $input1['person_first_name'] = $existing_userdata->first_name;
                $input1['person_last_name'] = $existing_userdata->last_name;
                $input1['person_email'] = $existing_userdata->email;
                $input1['person_phone'] = $existing_userdata->phone;
                $input1['person_phone'] = $existing_userdata->phone;
                $input1['password'] = $existing_userdata->password;
                $input1['gender'] = $existing_userdata->gender;
                $input1['city'] = $existing_userdata->city;
                $input1['state'] = $existing_userdata->state;
                $input1['weight'] = $existing_userdata->weight;
                $input1['weight_type'] = $existing_userdata->weight_type;
                $input1['height_type'] = $existing_userdata->height_type;
                $input1['height_feet'] = $existing_userdata->height_feet;
                $input1['height_inch'] = $existing_userdata->height_inch;
                $input1['language_id'] = $existing_userdata->language_id;
                $input1['dob'] = date("Y-m-d", strtotime($existing_userdata->dob));
            } else {
                $email = $request->person_email;
                $phone = $request->person_phone;

                $input1 = $request->only('order_id', 'addon_type', 'user_id', 'parent_package_id', 'package_id', 'person_first_name', 'person_last_name', 'person_email', 'person_phone', 'gender', 'city', 'state', 'weight', 'weight_type', 'height_type', 'height_feet', 'height_inch', 'language_id', 'relation', 'cart_id', 'member_type');
                $input1['dob'] = date("Y-m-d", strtotime($request->dob));
                $input1['password_text'] = $request->password;
                $input1['password'] = Hash::make($request->password);
                $is_exist_in_addon = Addon_persons::where('person_email', $email)->orWhere('person_phone', $phone)->where('status', '1')->where('cart_id', null)->first();
                if (!empty($is_exist_in_addon)) {
                    $is_exist_addon_email = Addon_persons::where('person_email', $email)->where('status', '1')->where('cart_id', null)->first();
                    if (!empty($is_exist_addon_email)) {
                        return response()->json(['statusCode' => 999, 'message' => 'Addon Email already Registered.']);
                    } else {
                        return response()->json(['statusCode' => 999, 'message' => 'Addon Mobile already Registered.']);
                    }
                }

                $is_exist_in_user = User::where('user_type', "user")->where('email', $email)->orWhere('phone', $phone)->first();
                if (!empty($is_exist_in_user)) {
                    $is_exist_email = User::where('user_type', "user")->where('email', $email)->first();
                    if (!empty($is_exist_email)) {
                        return response()->json(['statusCode' => 999, 'message' => 'User Email already Registered.']);
                    } else {
                        return response()->json(['statusCode' => 999, 'message' => 'User Mobile already Registered.']);
                    }
                }
            }

            // $input1 = $request->only('order_id','addon_type','user_id','parent_package_id','package_id','person_first_name','person_last_name', 'person_email', 'person_phone', 'dob', 'gender','city','state','weight','weight_type','height_type','height_feet','height_inch','language_id','relation','cart_id');

            $existsaddon = Addon_persons::where('user_id', $request->user_id)->where('package_id', $request->package_id)
                ->where(function ($query) use ($request) {
                    $query->where('cart_id', '=', null)
                        ->where('status', '1');
                })->orWhere(function ($query) use ($request) {
                $query->where('cart_id', $request->cart_id)
                    ->where('status', '0');
            })->get();

            if (!empty($existsaddon[0])) {
                $packagedata = Servicepackages::where('id', $request->package_id)->first();
                $package_adultcount = $packagedata->addon_adult_count;
                $exists_adultcount = $existsaddon->where('addon_type', "adult")->count();
                $package_kidcount = $packagedata->addon_kid_count;
                $exists_kidcount = $existsaddon->where('addon_type', "kid")->count();
                if ($request->addon_type == "adult") {
                    if ($exists_adultcount >= $package_adultcount) {
                        if ($request->type == "sport") {
                            $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
                            if (empty($servicepackages_data)) {
                                return response()->json(['statusCode' => 999, 'message' => 'Can not add more person at this time!']);
                            }
                            $input1['person_price'] = $servicepackages_data->price;
                        } else {
                            $input1['person_price'] = $packagedata->price;
                        }
                    } else {
                        $input1['person_price'] = 0;
                    }
                }
                if ($request->addon_type == "kid") {
                    if ($exists_kidcount >= $package_kidcount) {
                        if ($request->type == "sport") {
                            $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
                            if (empty($servicepackages_data)) {
                                return response()->json(['statusCode' => 999, 'message' => 'Can not add more person at this time!']);
                            }
                            $input1['person_price'] = $servicepackages_data->price;
                        } else {
                            $input1['person_price'] = $packagedata->price;
                        }
                    } else {
                        $input1['person_price'] = 0;
                    }
                }
            } else {
                $input1['person_price'] = 0;
            }
            if ($request->device_type == "ios") {
                $input1['status'] = '1';
                $input1['cart_id'] = null;
                
            }else{
                $input1['status'] = '0';
            }
            $data = Addon_persons::create($input1);
            if ($input1) {
                return response()->json(['statusCode' => 200, 'message' => 'Added Successfully.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Added Successfully!']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    
    

    public function getCartEmpty(Request $request)
    {
        if (!empty($request->cart_id)) {
            $Addon_persons_data = Addon_persons::where("cart_id",$request->cart_id)->update(['cart_id'=>null]);
            return response()->json(['statusCode' => 200, 'message' => 'Successfully Updated.', 'data' => $Addon_persons_data]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'cart id can not be empty!']);

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
            $data = Addon_persons::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
            $cart_id = $data->cart_id;
            if (!empty($data)) {
                $data->delete();

                $data1 = Addon_persons::where('cart_id', $cart_id)->where('user_id', auth()->user()->id)->get();
                $exists_adultcount = $data1->where('addon_type', "adult")->count();
                $exists_kidcount = $data1->where('addon_type', "kid")->count();
                $adult_count = 0;
                $kid_count = 0;
                foreach ($data1 as $key => $value) {

                    $packagedata = Servicepackages::where('id', $value->package_id)->first();
                    $package_adultcount = $packagedata->addon_adult_count;
                    $package_kidcount = $packagedata->addon_kid_count;

                    if ($value->addon_type == "adult") {
                        if ($adult_count < $package_adultcount) {
                            $input1['person_price'] = 0;
                        } else if ($exists_adultcount >= $package_adultcount) {
                            $servicepackages_data = Servicepackages::where('parent_id', $value->package_id)->where('addon_price_type', "person")->first();
                            $input1['person_price'] = $servicepackages_data->price;
                        }
                        $adult_count++;
                    }
                    if ($value->addon_type == "kid") {
                        if ($kid_count < $package_kidcount) {
                            $input1['person_price'] = 0;
                        } else if ($exists_kidcount >= $package_kidcount) {
                            $servicepackages_data = Servicepackages::where('parent_id', $value->package_id)->where('addon_price_type', "person")->first();
                            $input1['person_price'] = $servicepackages_data->price;
                        }
                        $kid_count++;
                    }

                    $value->update($input1);
                }

                return response()->json(['statusCode' => 200, 'message' => 'Person removed successfully.', 'data' => $data]);
            } else {
                return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            }
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
                'package_id' => 'nullable|numeric',
                'total_price' => 'required',
                'gst_percentage' => 'required',
                'gst_amount' => 'required',
                'final_amount' => 'required',
                'package_data' => 'nullable',
                'discount_amount' => 'nullable',
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
            $packagedata = Servicepackages::where('id', $request->package_data[0])->first();
            $input = $request->only('user_id', 'first_name', 'last_name', 'email', 'parent_package_id', 'phone', 'total_price', 'gst_percentage', 'gst_amount', 'final_amount', 'discount_amount', 'click_type');
            $input['order_id'] = $request->order_id;
            $input['status'] = "1";
            $input['name'] = @$request->first_name . ' ' . @$request->last_name;
            $input['type'] = $request->type;
            if ($request->type == "addon_sport" || $request->type == "addon_person") {
                $input['package_id'] = $request->package_data[0];
            } else {
                // $input['package_id'] = null;
                $input['package_id'] = @$request->package_data[0] ? $request->package_data[0] : null;
            }
            $input['payment_status'] = "pending";
            $input['start_date'] = date('Y-m-d H:i:s');
            // $input['end_date'] = date('Y-m-d H:i:s', strtotime('+'.@$packagedata->package_duration.' years'));
            $data = User_orders::create($input);
            if ($data) {
                // if ($request->type == "sport" || $request->type == "addon_sport") {
                //     if (!empty($request->category_data[0])) {
                //         $categoryids = $request->category_data;
                //         foreach ($categoryids as $key => $value) {
                //             $input1['order_primary_id'] = $data->id;
                //             $input1['order_id'] = $data->order_id;
                //             $input1['package_id'] = $request->package_id;
                //             $input1['category_id'] = $value['id'];
                //             $input1['category_year_srno'] = $value['value'];
                //             $key1 = $key + 1;
                //             $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                //             $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                //             if ($value['value'] == 1) {
                //                 $input1['status'] = '1';
                //             }else {
                //                 $input1['status'] = '0';
                //             }
                //             $data1 =  User_order_items::create($input1);
                //         }
                //     }
                // }

                $store = $request->package_data;
                if (!empty($store[0])) {
                    foreach ($store as $key3 => $value3) {
                        if ($request->type == "sport" || $request->type == "addon_sport") {
                            $cartdata = User_carts::with('packagedata')->where('user_id', $request->user_id)->where('package_id', $value3)->get();
                            foreach ($cartdata as $key2 => $value2) {
                                $categoryids = User_cart_items::where('cart_id', $value2->id)->orderBy('category_year_srno', 'asc')->get();
                                if (!empty($categoryids[0])) {
                                    foreach ($categoryids as $key => $value) {
                                        $input1['user_id'] = $request->user_id;
                                        $input1['order_primary_id'] = $data->id;
                                        $input1['order_id'] = $data->order_id;
                                        $input1['package_id'] = $value2->package_id;
                                        $input1['parent_package_id'] = $value2->parent_package_id;
                                        $input1['category_id'] = $value['category_id'];
                                        $input1['category_year_srno'] = $value['category_year_srno'];
                                        $input1['sport_price'] = $value['sport_price'];
                                        $key1 = $key + 1;
                                        if (@$packagedata->duration_type == "month") {
                                            $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($key);
                                            $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($packagedata->package_duration);
                                            
                                        }else{
                                            $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                                            $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                                        }
                                        
                                        $user = User::where('id',$request->user_id)->first();
                                        if ($user->is_active_freetrial == 1 && $user->is_complete_freetrial == 0 && $user->freetrial_duration != NULL) {
                                            $remaindate = Carbon::parse($user->freetrial_duration);
                                            $now = Carbon::now();
    
                                            $diff_data = $remaindate->diffInDays($now);
    
                                            $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addDays($diff_data);
                                        }
                                        
                                        if ($value['value'] == 1) {
                                            $input1['status'] = '1';
                                        } else {
                                            $input1['status'] = '0';
                                        }
                                        $data1 = User_order_items::create($input1);
                                        $data->end_date = $input1['end_date'];
                                    }
                                }
                            }
                        }
                    }
                }
                
                $payment_link = route("razorpay-payment", array('orderid' => $data->order_id));
                return response()->json(['statusCode' => 200, 'message' => 'Payment Link.', 'order_id' => $data->order_id, 'data' => $payment_link]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Link.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    
    public function orderPlaceIOS(Request $request)
    {
        try {
            $rules = [
                'package_id' => 'nullable|numeric',
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
            // $order_id = "SPL" . rand(100000, 999999) . time();
            $user = auth()->user();
            $packagedata = Servicepackages::where('id', $request->package_id)->first();
            $gst = Settings::where('type', 'gst')->first();

            $input = $request->only('user_id', 'first_name', 'last_name', 'email', 'parent_package_id', 'phone', 'total_price', 'gst_percentage', 'gst_amount', 'final_amount', 'discount_amount', 'click_type');
            $input['user_id'] = $user->id;
            $input['order_id'] = $request->order_id;
            $input['click_type'] = "cart";
            $input['total_price'] = $packagedata->price;
            $input['parent_package_id'] = $request->package_id;
            $input['final_amount'] = $packagedata->price;
            $input['gst_percentage'] = $gst->value;
            $input['status'] = "1";
            $input['name'] = @$user->first_name . ' ' . @$user->last_name;
            $input['type'] = "sport";
            if ($request->type == "addon_sport" || $request->type == "addon_person") {
                $input['package_id'] = $request->package_data[0];
            } else {
                $input['package_id'] = null;
            }
            $input['payment_status'] = "pending";
            $input['start_date'] = date('Y-m-d H:i:s');
            // $input['end_date'] = date('Y-m-d H:i:s', strtotime('+'.@$packagedata->package_duration.' years'));
            $data = User_orders::create($input);
            if ($data) {
                $input1['user_id'] = $user->id;
                $input1['order_primary_id'] = $data->id;
                $input1['order_id'] = $data->order_id;
                $input1['package_id'] = $request->package_id;
                $input1['parent_package_id'] = $request->package_id;
                $input1['category_id'] = '1';
                $input1['category_year_srno'] = '1';
                $input1['sport_price'] = '0';
                if (@$packagedata->duration_type == "month") {
                    $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at);
                    $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($packagedata->package_duration);

                } else {
                    $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at);
                    $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($packagedata->package_duration);
                }

                $user = User::where('id', $user->id)->first();
                if ($user->is_active_freetrial == 1 && $user->is_complete_freetrial == 0 && $user->freetrial_duration != null) {
                    $remaindate = Carbon::parse($user->freetrial_duration);
                    $now = Carbon::now();
                    $diff_data = $remaindate->diffInDays($now);
                    $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addDays($diff_data);
                }

                $input1['status'] = '0';
                $data1 = User_order_items::create($input1);
                // $data->end_date = $input1['end_date'];



                // @$store = [$request->package_id];
                // @$store = $request->package_data;
                // if (!empty($store[0])) {
                //     foreach ($store as $key3 => $value3) {
                //         if ($request->type == "sport" || $request->type == "addon_sport") {
                //             $cartdata = User_carts::with('packagedata')->where('user_id', $user->id)->where('package_id', $value3)->get();
                //             foreach ($cartdata as $key2 => $value2) {
                //                 $categoryids = User_cart_items::where('cart_id', $value2->id)->orderBy('category_year_srno', 'asc')->get();
                //                 foreach ($categoryids as $key => $value) {
                //                     $input1['user_id'] = $user->id;
                //                     $input1['order_primary_id'] = $data->id;
                //                     $input1['order_id'] = $data->order_id;
                //                     $input1['package_id'] = $value2->package_id;
                //                     $input1['parent_package_id'] = $value2->parent_package_id;
                //                     $input1['category_id'] = $value['category_id'];
                //                     $input1['category_year_srno'] = $value['category_year_srno'];
                //                     $input1['sport_price'] = $value['sport_price'];
                //                     $key1 = $key + 1;
                //                     if (@$packagedata->duration_type == "month") {
                //                         $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($key);
                //                         $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($packagedata->package_duration);
                                        
                //                     }else{
                //                         $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                //                         $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                //                     }

                //                     if ($value['value'] == 1) {
                //                         $input1['status'] = '1';
                //                     } else {
                //                         $input1['status'] = '0';
                //                     }
                //                     $data1 = User_order_items::create($input1);
                //                     $data->end_date = $input1['end_date'];
                //                 }
                //             }
                //         }
                //     }
                // }
                
                $payment_link = route("razorpay-payment", array('orderid' => $data->order_id));
                return response()->json(['statusCode' => 200, 'message' => 'Payment Link.', 'order_id' => $request->order_id,'ios_package_id' => $packagedata->ios_package_id, 'data' => $payment_link]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Link.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    //razorpay payment start
    public function razorpayPaymentPage(Request $request)
    {
        $orderdata = User_orders::where('order_id', $request->orderid)->first();
        $user = User::where('id', $orderdata->user_id)->first();
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

        $api = new Api(config('payments.razorpay_key'), config('payments.razorpay_secret'));
        $order = $api->order->create(array(
            'receipt' => $orderdata->orderid,
            'amount' => $order_amount * 100,
            'currency' => 'INR',
        ));
        $pay_orderid = $order['id'];
        $orderdata = User_orders::where('order_id', $request->orderid)->update(array('razorpay_orderid' => $pay_orderid));
        return view('razorpayView', compact('user', 'order', 'orderdata'));
    }

    public function razorpayPaymentcallback(Request $request)
    {
        $orderdata = User_orders::where('razorpay_orderid', $request->razorpay_order_id)->update(array('razorpay_id' => $request->razorpay_payment_id, 'payment_status' => "complete"));
        if (!empty($orderdata)) {
            $orderdetail = User_orders::where('razorpay_orderid', $request->razorpay_order_id)->first();
            @$addon_person_data = Addon_persons::where('user_id', $orderdetail->user_id)->where('order_id', $orderdetail->order_id)->update(array('cart_id' => null, 'status' => '1'));

            $user = User::where('id', $orderdetail->user_id)->first();
            if (!empty($user)) {
                $user->is_use_refer = '1';
                if ($user->is_complete_freetrial != '1') {
                    // $user->is_active_freetrial = '0';
                    $user->is_complete_freetrial = '1';
                    $user->freetrial_duration = date("Y-m-d H:i:s");
                }
                $user->save();
            }

            $pervious_cartdata = User_carts::where('user_id', $orderdetail->user_id)->where('click_type', $orderdetail->click_type)->get();
            if (!empty($pervious_cartdata[0])) {
                foreach ($pervious_cartdata as $key => $value) {
                    $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                }
                $deletecartdata = User_carts::where('user_id', $orderdetail->user_id)->where('click_type', $orderdetail->click_type)->delete();
            }
            return redirect(route("razorpay-payment-data", array('status' => '1')));
        } else {
            return redirect(route("razorpay-payment-data", array('status' => '0')));
        }
    }

    public function razorpayPaymentcallbackIOS(Request $request)
    {
        $orderdata = User_orders::where('order_id', $request->order_id)->update(array('ios_package_id' => $request->ios_package_id, 'ios_inapp_id' => $request->ios_inapp_id, 'ios_purchase_date' => $request->ios_purchase_date, 'payment_status' => "complete"));

        if (!empty($orderdata)) {
            
            $orderdetail = User_orders::where('order_id', $request->order_id)->first();
            $package_data = Servicepackages::where('id', $orderdetail->parent_package_id)->first();
            if (!empty($package_data)) {
                if (@$package_data->duration_type == "month") {
                    $end_date = Carbon::parse($package_data->start_date)->addMonths($package_data->package_duration);
                }else{
                    $end_date = Carbon::parse($package_data->start_date)->addYear($package_data->package_duration);
                }
                $orderdata_enddate_update = User_orders::where('order_id', $request->order_id)->update(['end_date' => $end_date]);
            }


            @$addon_person_data = Addon_persons::where('user_id', $orderdetail->user_id)->where('order_id', $orderdetail->order_id)->update(array('cart_id' => null, 'status' => '1'));

            $user = User::where('id', $orderdetail->user_id)->first();
            if (!empty($user)) {
                $user->is_use_refer = '1';
                if ($user->is_complete_freetrial != '1') {
                    $user->is_complete_freetrial = '1';
                    $user->freetrial_duration = date("Y-m-d H:i:s");
                }
                $user->save();
            }

            $pervious_cartdata = User_carts::where('user_id', $orderdetail->user_id)->get();
            if (!empty($pervious_cartdata[0])) {
                foreach ($pervious_cartdata as $key => $value) {
                    $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                }
                $deletecartdata = User_carts::where('user_id', $orderdetail->user_id)->delete();
            }

            return response()->json(['statusCode' => 200, 'message' => 'Payment Success.']);
        } else {
            $orderdata = User_orders::where('order_id', $request->order_id)->update(array('payment_status' => "failed"));
            return response()->json(['statusCode' => 999, 'message' => 'Payment Failed.']);
        }
    }
    public function razorpayPaymenturl(Request $request)
    {

        if ($request->status == '1') {
            // echo "success";
            $status = $request->status;
            return view('payment-response', compact('status'));
        } else {
            $orderdata = User_orders::where('razorpay_orderid', $request->orderid)->update(array('razorpay_id' => $request->payid, 'payment_status' => "failed"));
            // echo "failed";
            $status = '0';
            return view('payment-response', compact('status'));
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
            $data = Nutrition_categories::where('status', '1')->get();
            $nutrition_quotes = Nutrition_quotes::where('status', '1')->get();
            $todaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d'))->get();
            $yesterdaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime("-1 day")))->get();
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
                if ($value->meal_id != null) {
                    $mealdetail = Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                    if (!empty($mealdetail)) {
                        $t_calorie = $t_calorie+@$mealdetail->calorie;
                        $t_protein = $t_protein+@$mealdetail->protein;
                        $t_carbs = $t_carbs+@$mealdetail->carbs;
                        $t_fats = $t_fats+@$mealdetail->fats;
                    }
                }
            }
            $uni_cat = array_unique($frq_id);
            $usermealdata = Nutrition_diet_datas::where('user_id', $user_id)->first();
            if (!empty($usermealdata->diet)) {
                foreach ($usermealdata->diet as $key1 => $value1) {
                    if (in_array($value1['frequency_id'], $uni_cat)) {
                        $mealdetail = Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                        $t_calorie = $t_calorie + (@$mealdetail->calorie * $value1['quantity']);
                        $t_protein = $t_protein + (@$mealdetail->protein * $value1['quantity']);
                        $t_carbs = $t_carbs + (@$mealdetail->carbs * $value1['quantity']);
                        $t_fats = $t_fats + (@$mealdetail->fats * $value1['quantity']);
                    }
                }
            }
            $y_frq_id = [];
            foreach ($yesterdaymealsdata as $key => $value) {
                $y_frq_id[] = $value->category_id;
                if ($value->meal_id != null) {
                    $mealdetail = Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                    if (!empty($mealdetail)) {
                        $y_calorie = $y_calorie+@$mealdetail->calorie;
                        $y_protein = $y_protein+@$mealdetail->protein;
                        $y_carbs = $y_carbs+@$mealdetail->carbs;
                        $y_fats = $y_fats+@$mealdetail->fats;
                    }
                }
            }
            $y_uni_cat = array_unique($y_frq_id);
            if (!empty($usermealdata->diet)) {
                foreach ($usermealdata->diet as $key1 => $value1) {
                    if (in_array($value1['frequency_id'], $y_uni_cat)) {
                        $mealdetail = Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                        $y_calorie = $y_calorie + (@$mealdetail->calorie * $value1['quantity']);
                        $y_protein = $y_protein + (@$mealdetail->protein * $value1['quantity']);
                        $y_carbs = $y_carbs + (@$mealdetail->carbs * $value1['quantity']);
                        $y_fats = $y_fats + (@$mealdetail->fats * $value1['quantity']);
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
            $yesterday_waterlevel_data = User_waterlevels::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime("-1 day")))->first();
            if (!empty($yesterday_waterlevel_data)) {
                $y_waterlevel = $yesterday_waterlevel_data->water_level;
            }
            $nutrition_details = array('today' => array('calorie' => round($t_calorie), 'protein' => round($t_protein), 'carbs' => round($t_carbs), 'fats' => round($t_fats), 'height_feet' => $height_feet, 'height_inch' => $height_inch, 'weight' => $weight), 'yesterday' => array('calorie' => round($y_calorie), 'protein' => round($y_protein), 'carbs' => round($y_carbs), 'fats' => round($y_fats), 'height_feet' => $height_feet, 'height_inch' => $height_inch, 'weight' => $weight));
            if (!empty($data[0])) {

                return response()->json(['statusCode' => 200, 'message' => 'Nutrition Category List.', 'today_waterlevel' => $t_waterlevel, 'yesterday_waterlevel' => $y_waterlevel, 'data' => array('nutrition_details' => $nutrition_details, 'category_data' => $data, 'nutrition_quotes' => $nutrition_quotes)]);
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
            $keyword = $request->keyword;
            // $limit  = $request->limit ? $request->limit : '1';
            // $offset  = $request->offset ? $request->offset : '0';
            $data = Nutrition_recipe_categories::with('nutrition_recipedata')
                ->whereHas('nutrition_recipedata', function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', '%' . $keyword . '%');
                    // $query->skip($offset)->take($limit);
                })->where('status', '1')->orderBy('position', 'asc')->get();
            // $data =  Nutrition_recipe_categories::with('nutrition_recipedata')->where('status','1')->get()
            //         ->map(function($data) {
            //             $data->setRelation('nutrition_recipedata', $data->nutrition_recipedata->take(1));
            //             return $data;
            //         });
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Nutrition Recipes List Available.', 'data' => $data]);
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
            $data = Nutrition_recipes::where('category_id', $request->category_id)->get();
            if (!empty($data[0])) {
                $category_data = Nutrition_recipe_categories::where('id', $request->category_id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Nutrition Recipes List Available.', 'data' => array('category_data' => $category_data, 'recipelist' => $data)]);
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
                'type' => 'nullable',
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
            $data = Nutrition_recipes::where('id', $request->recipe_id)->first();
            if (!empty($data)) {
                $viewcount = $data->view_count + 1;
                $updateviewcount = Nutrition_recipes::where('id', $request->recipe_id)->update(['view_count' => $viewcount]);
                if ($request->type == "share") {
                    $count = $data->share_count + 1;
                    $updatesharecount = Nutrition_recipes::where('id', $request->recipe_id)->update(['share_count' => $count]);
                }
                $data = Nutrition_recipes::where('id', $request->recipe_id)->first();
                $likedata = User_diaries::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();
                if (!empty($likedata)) {
                    $data->is_like = 1;
                } else {
                    $data->is_like = 0;
                }
                $favdata = Recipe_likes::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();
                if (!empty($favdata)) {
                    $data->is_favourite = 1;
                } else {
                    $data->is_favourite = 0;
                }
                $arr = [];
                foreach ($data->ingredients as $key => $value) {
                    $ingredientsdata = Ingredients::where('id', $value['name'])->first();
                    if (!empty($ingredientsdata)) {
                        $arr[$key]['name'] = $ingredientsdata->title;
                        $arr[$key]['quantity'] = $value['quantity'];
                    } else {
                        $arr[$key]['name'] = $value['name'];
                        $arr[$key]['quantity'] = $value['quantity'];
                    }
                }
                unset($data->ingredients);
                $data->ingredients = $arr;
                return response()->json(['statusCode' => 200, 'message' => ' Recipe Details Available.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Available.']);
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
            $data = Nutrition_recipes::where('id', $request->recipe_id)->first();
            if (!empty($data)) {
                if (@$request->type == "favourite") {
                    $favourite_data = Recipe_likes::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();
                    if (empty($favourite_data)) {
                        $input = $request->only('recipe_id');
                        $input['user_id'] = auth()->user()->id;
                        $data1 = Recipe_likes::create($input);
                        $likecount = $data->like_count + 1;
                        $updatelikecount = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        if (!empty($data1)) {
                            return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Favourite Successfully.', 'data' => $data1]);
                        }
                        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                    } else {
                        $favourite_data->delete();
                        $likecount = $data->like_count - 1;
                        $data1 = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        return response()->json(['statusCode' => 200, 'message' => ' Recipe Removed From Favourite.', 'data' => $favourite_data]);
                    }
                } else {
                    $likedata = User_diaries::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();
                    if (empty($likedata)) {
                        $input = $request->only('recipe_id');
                        $input['user_id'] = auth()->user()->id;
                        $input['status'] = '1';
                        $data1 = User_diaries::create($input);
                        $likecount = $data->like_count + 1;
                        $updatelikecount = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        if (!empty($data1)) {
                            return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Diary Successfully.', 'data' => $data1]);
                        }
                        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                    } else {
                        $likedata->delete();
                        $likecount = $data->like_count - 1;
                        $data1 = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                        return response()->json(['statusCode' => 200, 'message' => ' Recipe Removed From Diary.', 'data' => $likedata]);
                    }
                }
            } else {
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
            $input = $request->only('user_id', 'recipe_id', 'message');
            $input['user_id'] = auth()->user()->id;
            $input['status'] = '1';
            $data = Recipe_comments::create($input);
            if (!empty($data)) {
                $data = Recipe_comments::with('userdata', 'recipedata.recipe_categorydata')->where('id', $data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.', 'data' => $data]);
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
            $data = Nutrition_recipes::where('id', $request->recipe_id)->first();
            if (!empty($data)) {
                $count = $data->share_count + 1;
                $data1 = Nutrition_recipes::where('id', $request->recipe_id)->update(['share_count' => $count]);
                if (!empty($data1)) {
                    return response()->json(['statusCode' => 200, 'message' => ' Recipe Shared.', 'data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
            } else {
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
            $data = Recipe_comments::with('userdata', 'recipedata.recipe_categorydata')->where('recipe_id', $request->recipe_id)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Comments List.', 'data' => $data]);
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
            $data = Nutrition_blogs::where('status', '1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Blogs Available.', 'data' => $data]);
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
            $data = Nutrition_blogs::where('id', $request->blog_id)->first();
            if (!empty($data)) {
                $view_count = $data->view_count + 1;
                $data->update(['view_count' => $view_count]);
                $likedata = Nutrition_blog_likes::where('blog_id', $request->blog_id)->where('user_id', auth()->user()->id)->first();
                if (!empty($likedata)) {
                    $data->is_like = 1;
                } else {
                    $data->is_like = 0;
                }
                $commentlist = Nutrition_blog_comments::with('userdata')->where('blog_id', $request->blog_id)->orderBy('created_at', 'desc')->get();
                $data->view_count = (string) $data->view_count;
                return response()->json(['statusCode' => 200, 'message' => ' Blog Details Available.', 'data' => array('blog_data' => $data, 'commentlist' => $commentlist)]);
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
            $data = Nutrition_blogs::where('id', $request->blog_id)->first();
            if (!empty($data)) {
                $likedata = Nutrition_blog_likes::where('blog_id', $request->blog_id)->where('user_id', auth()->user()->id)->first();
                if (empty($likedata)) {
                    $input = $request->only('blog_id');
                    $input['user_id'] = auth()->user()->id;
                    $data1 = Nutrition_blog_likes::create($input);
                    if (!empty($data1)) {
                        $likecount = $data->like_count + 1;
                        $data->update(['like_count' => $likecount]);
                        return response()->json(['statusCode' => 200, 'message' => ' Blog Liked.', 'data' => $data1]);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                } else {
                    $likedata->delete();
                    $likecount = $data->like_count - 1;
                    $data->update(['like_count' => $likecount]);
                    return response()->json(['statusCode' => 200, 'message' => ' Blog Removed From Liked.', 'data' => $likedata]);
                }
            } else {
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
            $data = Nutrition_blogs::where('id', $request->blog_id)->first();
            if (!empty($data)) {
                $count = $data->share_count + 1;
                $data1 = Nutrition_blogs::where('id', $request->blog_id)->update(['share_count' => $count]);
                if (!empty($data1)) {
                    return response()->json(['statusCode' => 200, 'message' => ' Nutrition Blog Shared.', 'data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
            } else {
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
            $input = $request->only('user_id', 'blog_id', 'message');
            $input['user_id'] = auth()->user()->id;
            $input['status'] = '1';
            $data = Nutrition_blog_comments::create($input);
            if (!empty($data)) {
                // $data =  Nutrition_blog_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.', 'data' => $data]);
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
            $data = Nutrition_blog_comments::with('userdata', 'blogdata')->where('blog_id', $request->blog_id)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Blog Comments List.', 'data' => $data]);
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
            $data = Nutrition_diet_datas::where('user_id', '=', auth()->user()->id)->get();
            $frqudata = Nutrition_diet_frequencies::all();
            $mealdata = Meal::all();
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
                    $customarr1[$key4]['frequency_id'] = $value4[0]['frequency_id'];
                    $customarr1[$key4]['frequency_name'] = $frqudata_arr[$value4[0]['frequency_id']];
                    $customarr2 = [];
                    foreach ($value4 as $key2 => $value2) {
                        $customarr2[$key2]['meal'] = $value2['meal'];
                        $customarr2[$key2]['quantity'] = $value2['quantity'];
                        $customarr2[$key2]['meal_name'] = @$mealdata_arr[$value2['meal']] ?? 'N/A';
                    }
                    $customarr1[$key4]['meal'] = $customarr2;
                }
                $customarr1 = array_values($customarr1);
            }
            if (!empty($data[0])) {
                $data1 = [
                    'title' => auth()->user()->name ?? 'Sportylife',
                    'date' => date('m/d/Y'),
                    'customarr1' => $customarr1,
                ];
                $my_pdf_name = 'uploads/dietchart' . auth()->user()->id . '.pdf';
                $my_pdf_path = 'public/' . $my_pdf_name;
                $pdf = PDF::loadView('dietPDF', $data1)->save($my_pdf_path);
                $userdata = Auth::user();
                $userdata->dietchart_pdf = $my_pdf_name;
                $userdata->save();
                $note = array('bowl' => '100g', 'cup' => '100ml', 'glass' => '200ml', 'tbsp' => '15g', 'tsp' => '5g');
                $pdfurl = asset(auth()->user()->dietchart_pdf);
                return response()->json(['statusCode' => 200, 'message' => ' Diet Chart Available.', 'data' => array('pdf' => $pdfurl, 'note' => $note, 'diet' => $customarr1)]);
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
            $data = Nutrition_diet_frequencies::where('status', '1')->get();
            if (!empty($data[0])) {
                $addonmealcount = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('meal_id', '!=', null)->count();
                foreach ($data as $key => $value) {
                    $is_mealcompletedata = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('category_id', $value->id)->where('meal_id', null)->first();
                    if (!empty($is_mealcompletedata)) {
                        $value->is_complete = "1";
                    } else {
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
            $nutrition_diet_datas = Nutrition_diet_datas::where('user_id', $user_id)->first();
            if (empty($nutrition_diet_datas)) {
                return response()->json(['statusCode' => 999, 'message' => 'Your diet chart is not created yet.']);
            }
            if ($request->type == "addon") {
                // $data =  User_completed_meals::where('user_id', $user_id)->where('date',$currentdate)->where('meal_id','!=',NULL)->delete();
                $meal_data = $request->meal_data;
                foreach ($meal_data as $key => $value) {
                    $input['user_id'] = $user_id;
                    $input['date'] = $currentdate;
                    $input['category_id'] = $value['category_id'];
                    if (!empty($value['meal_id'])) {
                        foreach ($value['meal_id'] as $key1 => $value1) {
                            // $input['meal_id'] = $value1;
                            // $data1 =  User_completed_meals::create($input);
                            $data = User_completed_meals::where('user_id', $user_id)->where('date', $currentdate)->where('category_id', '=', $value['category_id'])->where('meal_id', '=', $value1)->first();
                            if (!empty($data)) {
                                $input['meal_id'] = $value1;
                                $data1 = $data->update($input);
                            } else {
                                $input['meal_id'] = $value1;
                                $data1 = User_completed_meals::create($input);
                            }
                        }
                    } else {
                        $data1 = User_completed_meals::create($input);
                    }
                }
            } else {
                $data = User_completed_meals::where('user_id', $user_id)->where('date', $currentdate)->where('meal_id', null)->delete();
                $meal_data = $request->meal_data;
                foreach ($meal_data as $key => $value) {
                    $input['user_id'] = $user_id;
                    $input['date'] = $currentdate;
                    $input['category_id'] = $value['category_id'];
                    $input['meal_id'] = null;
                    // if (!empty($value['meal_id'])) {
                    //     foreach ($value['meal_id'] as $key1 => $value1) {
                    //         $input['meal_id'] = $value1;
                    //         $data1 =  User_completed_meals::create($input);
                    //     }
                    // }else{
                    //     $data1 =  User_completed_meals::create($input);
                    // }
                    $data1 = User_completed_meals::create($input);
                }
            }
            // $check = array('user_id'=> $user_id, 'date' => $currentdate );
            // $data =  User_completed_meals::updateOrCreate($check, $input);
            if (!empty($data1)) {
                $data = User_completed_meals::with('categorydata', 'mealdata')->where('date', $currentdate)->where('user_id', $user_id)->get();
                return response()->json(['statusCode' => 200, 'message' => ' Data Update Successfully.', 'data' => $data]);
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
            $data = User_completed_meals::with('categorydata', 'mealdata')->where('user_id', $user_id)->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'History Found.', 'data' => $data]);
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
            $data = User_completed_meals::with('categorydata', 'mealdata')->where('id', $request->id)->where('user_id', $user_id)->first();
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
            $data = Meal::where('frequency_id', $request->frequency_id)->where('status', '1')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => $data]);
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
            $data = User_diaries::with('recipedata', 'userdata')->where('user_id', $user_id)->get();
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
            $data = auth()->user();
            if (!empty($data)) {
                $date = Carbon::parse($data->dob);
                $now = Carbon::now();
                $age = $date->diff($now)->format('%y');

                if ($data->height_type == "Inch" || $data->height_type == "Feet") {
                    $height_cm = (($data->height_feet * 12) + $data->height_inch) * 2.54;
                } else {
                    $height_cm = $data->height_feet + ($data->height_inch / 10);
                }
                if ($data->gender == "female") {
                    $data->ibw = number_format(($height_cm - 105), 2); // ibw = height(cm) - 105
                } else {
                    $data->ibw = number_format(($height_cm - 100), 2); // ibw = height(cm) - 100
                }

                if ($age < 18) {
                    $data->ibw = 0; // ibw = height(cm) - 100
                }
                $height_mtr = $height_cm / 100;
                if ($data->weight_type == "Lbs") {
                    $kgweight = $data->weight / 2.205;
                } else {
                    $kgweight = $data->weight;
                }
                if ($height_mtr > 0) {
                    $data->bmi = number_format(($kgweight / ($height_mtr * $height_mtr)), 2); // BMI = Weight(kg) /height (m)2
                } else {
                    $data->bmi = 0; // BMI = Weight(kg) /height (m)2
                }
                $estimator = $data->bmi;
                if ($estimator < 18.5) {
                    $data->frc_category = 'Underweight';
                    $data->frc_color = 'blue'; //dark blue
                    $data->bmi_range = 'Below 18.5'; //dark blue
                } elseif ($estimator >= 18.5 && $estimator <= 24.99) {
                    $data->frc_category = 'Normal weight';
                    $data->frc_color = 'green'; //green
                    $data->bmi_range = '18.5 - 24.9'; //green
                } elseif ($estimator >= 25 && $estimator <= 29.99) {
                    $data->frc_category = 'Overweight';
                    $data->frc_color = 'yellow'; //yellow
                    $data->bmi_range = '25.0 - 29.9'; //yellow
                } elseif ($estimator >= 30 && $estimator <= 34.99) {
                    $data->frc_category = 'Obesity Class I';
                    $data->frc_color = 'orange'; //orange
                    $data->bmi_range = '30.0 - 34.9'; //orange
                } elseif ($estimator >= 35 && $estimator <= 39.99) {
                    $data->frc_category = 'Obesity Class II';
                    $data->frc_color = 'pink'; //pink
                    $data->bmi_range = '35.0 - 39.9'; //pink
                } elseif ($estimator >= 40) {
                    $data->frc_category = 'Obesity Class III';
                    $data->frc_color = 'red'; //red
                    $data->bmi_range = 'Above 40'; //red
                }else{
                    $data->frc_category = '';
                    $data->frc_color = ''; //red
                    $data->bmi_range = ''; //red
                }
                if ($data->ibw == 0) {
                    $data->ibw = "NA";
                }

                return response()->json(['statusCode' => 200, 'message' => ' FRC Data.', 'data' => $data]);
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
            $check = array('user_id' => $user_id, 'date' => $currentdate);
            $input['water_level'] = $request->water_level;
            $data = User_waterlevels::updateOrCreate($check, $input);
            if (!empty($data)) {
                $data1 = User_waterlevels::with('userdata')->where('id', $data->id)->first();
                if (auth()->user()->status == "1") {
                    $data1->is_block = '0';
                } else {
                    $data1->is_block = '1';
                }
                $app_version = Settings::where('type', "app_version")->first();
                $app_update_message = Settings::where('type', "app_update_message")->first();
                $force_logout = Settings::where('type', "force_logout")->first();
                $data1->app_version = $app_version->value;
                $data1->app_update_message = $app_update_message->value;
                $data1->force_logout = $force_logout->value;
                return response()->json(['statusCode' => 200, 'message' => 'Data Update Successfully.', 'data' => $data1]);
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
            $data = Workoutcategories::with('workoutvideodata')->where('status', '1')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if ($value->id == '6') {
                        unset($value->workoutvideodata);
                        // $workoutvideodata = [];
                        $recorded_video = Live_videos::where('status', '1')->whereDate('end_date_time', '<=', $currentdate_time)->select('id', 'category_id', 'title', 'thumbnail', 'video', 'status', 'start_date_time', 'created_at', 'updated_at')->get();
                        foreach ($recorded_video as $key1 => $value1) {
                            $livetime = Carbon::parse($value1->start_date_time)->addMinutes(30);
                            if ($livetime <= $currentdate_time) {
                                $value->workoutvideodata[] = $value1;
                            } else {
                                $value->workoutvideodata = $recorded_video;
                            }
                        }
                        // $value->workoutvideodata = $workoutvideodata;
                    }
                }
                // $data = array_merge($data->toArray(), $recorded_video->toArray());
                return response()->json(['statusCode' => 200, 'message' => 'Workout Video List Available.', 'data' => $data]);
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
                $day_arr = [$nextday, $second_nextday, $third_nextday];
                $day_name = [$nextday_name, $second_nextday_name, $third_nextday_name];
            } 
            else {
                $day_arr = [$today, $nextday, $second_nextday];
                $day_name = [$today_name, $nextday_name, $second_nextday_name];
            }
            
            // $day_arr = ['Monday','Wednesday','Friday'];
            $day_name = ['Monday','Wednesday','Friday'];
            // $day_name = [$today_name,$nextday_name,$second_nextday_name];
            // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $data = [];
            foreach ($day_arr as $key1 => $value1) {
                $item_data = Live_videos::where('status', '1')->where('end_date_time', '>=', $currentdate_time)->whereDate('start_date_time', $value1)->get();
                if (!empty($item_data[0])) {
                    foreach ($item_data as $key => $value) {
                        if ($value->start_date_time <= $currentdate_time) {
                            $value->is_play = "1";
                        } else {
                            $value->is_play = "0";
                        }
                        $date = Carbon::parse($value->start_date_time);
                        $now = Carbon::now();
                        $value->difference = $date->diffInSeconds($now);
                        $value->dayname = $date->format('l');
                        $value->start_date_time = date("H:i a", strtotime($value->start_date_time));
                        $value->end_date_time = date("H:i a", strtotime($value->end_date_time));
                    }
                }
                // $data[0][strval($value1)] = $item_data;
                $data[0][strval($value1->format("l"))] = $item_data;
            }
            // print_r($data);exit;
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => array("day_name" => $day_name, "video_data" => $data)]);
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
                $day_arr = [$nextday, $second_nextday, $third_nextday];
                $day_name = [$nextday_name, $second_nextday_name, $third_nextday_name];
            } else {
                $day_arr = [$today, $nextday, $second_nextday];
                $day_name = [$today_name, $nextday_name, $second_nextday_name];
            }
            // $day_arr = [$today,$nextday,$second_nextday];
            // $day_name = [$today_name,$nextday_name,$second_nextday_name];
            // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $data = [];
            foreach ($day_arr as $key1 => $value1) {
                $item_data = Live_videos::where('status', '1')->where('end_date_time', '>=', $currentdate_time)->whereDate('start_date_time', $value1)->get();
                if (!empty($item_data[0])) {
                    foreach ($item_data as $key => $value) {
                        if ($value->start_date_time <= $currentdate_time) {
                            $value->is_play = "1";
                        } else {
                            $value->is_play = "0";
                        }
                        $date = Carbon::parse($value->start_date_time);
                        $now = Carbon::now();
                        $value->difference = $date->diffInSeconds($now);
                        $value->dayname = $date->format('l');
                        $value->start_date_time = date("H:i:s", strtotime($value->start_date_time));
                        $value->end_date_time = date("H:i:s", strtotime($value->end_date_time));
                    }
                }
                $data[0][strval($value1->format("l"))] = $item_data;
            }
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => array("day_name" => $day_name, "video_data" => $data)]);
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
            $data = Live_videos::where('id', $request->id)->where('status', '1')->where('end_date_time', '>=', $currentdate_time)->first();
            if (!empty($data)) {
                if ($data->start_date_time <= $currentdate_time) {
                    $data->is_play = "1";
                } else {
                    $data->is_play = "0";
                }
                $user = auth()->user();
                $date = Carbon::parse($data->start_date_time);
                $now = Carbon::now();
                $data->difference = $date->diffInSeconds($now);
                $data->dayname = $date->format('l');
                $data->start_date = date("l, M d, Y", strtotime($data->start_date_time));
                $data->start_date_time = date("H:i a", strtotime($data->start_date_time));
                $data->end_date_time = date("H:i a", strtotime($data->end_date_time));
                // $data->active_plan = "No Active Plan";

                $package_data = User_orders::with('order_items.category')->where('user_id', $user->id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
                if (!empty($package_data[0])) {
                    $package_data_items = User_order_items::select('package_id')->where('order_primary_id', $package_data[0]['id'])->distinct()->get();
                    // print_r($package_data_items->toArray());exit;
                    $pack = Servicepackages::where('id', $package_data_items[0]['package_id'])->get();
                    foreach ($pack as $key1 => $value1) {
                        @$packagedata = ['title'=>$pack[0]['title']];
                        $value1->packagedata = @$packagedata;  
                    }
                    $data->active_plan = $pack[0]['title'];
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
                } else {
                    $data->active_plan = "No Active Plan";
                    $data->package_data = [];
                }
                // $data->package_data = [];

                $getpackage_data = $this->getUserPackage();
                if (!empty($getpackage_data[0]['package'])) {
                    $data->active_plan = $getpackage_data[0]['package'][0]['package_data']['title'];
                } elseif ($user->is_active_freetrial == '1') {
                    $data->active_plan = "Free Trial";
                } else {
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
            $data = Live_videos::where('id', $request->video_id)->first();
            if (!empty($data)) {
                $data->view_count = $data->view_count + 1;
                $data->save();
                $input = $request->only('video_id', 'user_id');
                $check = array('user_id' => $request->user_id, 'video_id' => $request->video_id);
                $data1 = Live_video_users::updateOrCreate($check, $input);
                return response()->json(['statusCode' => 200, 'message' => ' Added successfully.', 'data' => $data1]);
            } else {
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
            $keyword = $request->keyword;
            $user_id = auth()->user()->id;
            if (!empty($keyword)) {
                $check = array('user_id' => $user_id, 'title' => $keyword);
                $input['user_id'] = $user_id;
                $input['title'] = $keyword;
                $data = User_search_keywords::updateOrCreate($check, $input);
            }
            $recipe_data = Nutrition_recipes::where('title', 'LIKE', '%' . $keyword . '%')->where('status', '1')->select('id', 'title', 'type', 'uploads', 'thumbnail')->get();
            $blog_data = Nutrition_blogs::where('title', 'LIKE', '%' . $keyword . '%')->where('status', '1')->select('id', 'title', 'image')->get();
            foreach ($recipe_data as $key => $value) {
                $value->search_type = "recipe";
                if ($value->type == "video") {
                    $value->image = $value->thumbnail;
                } else {
                    $value->image = $value->uploads;
                }
            }
            foreach ($blog_data as $key1 => $value1) {
                $value1->search_type = "blog";
            }
            $recent_search = User_search_keywords::where('user_id', $user_id)->get();
            $favourite_data = Recipe_likes::with('recipedata')->where('user_id', $user_id)->get();
            if (!empty($recipe_data[0]) || !empty($blog_data[0])) {
                $data = array_merge($recipe_data->toArray(), $blog_data->toArray());
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => array('search_data' => $data, 'recent_search' => $recent_search, 'favourite_data' => $favourite_data)]);
            }
            $data = [];
            return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => array('search_data' => $data, 'recent_search' => $recent_search, 'favourite_data' => $favourite_data)]);
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
            $data = User_search_keywords::where('user_id', auth()->user()->id)->get();
            if (!empty($data[0])) {
                $data = User_search_keywords::where('user_id', auth()->user()->id)->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Cleared Successfully.', 'data' => $data]);
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
                'password' => 'required|confirmed|min:8',
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
                if ($request->current_password != $request->password) {
                    $input['password_text'] = $request->password;
                    $input['password'] = Hash::make($request->password);
                    $user = auth()->user()->update($input);
                    if ($user) {
                        $user_data = User::where('user_type', "user")->where('email', $request->email)->first();
                        return response()->json(['statusCode' => 200, 'message' => 'Password Update Successfully.', 'data' => $user_data]);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Updation Failed.']);
                } else {
                    return response()->json(['statusCode' => 999, 'message' => 'The new password does not same as old password.']);
                }
            } else {
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
            $data = Sports_curriculums::where('status', '1')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    if ($value->type == "sports") {
                        $category = Servicecategories::where('id', $value->category)->first();
                        $value->category_title = $category->title;
                    } else {
                        if ($value->category == "sporty_kid_7") {
                            $value->category_title = "Sports Kid (4 to 7)";
                        } else {
                            $value->category_title = "Sports Kid (7 to 9)";
                        }
                    }
                }
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => $data]);
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
            $keyword = $request->keyword;
            $state_data = States::where('name', 'LIKE', '%' . $keyword . '%')->select('id', 'name')->orderBy('name', "asc")->get();
            $city_data = Cities::where('name', 'LIKE', '%' . $keyword . '%')->select('id', 'name')->orderBy('name', "asc")->get();
            $phonecode_data = Phonecodes::select('id', 'phone_code', 'country_name')->orderBy('country_name', "asc")->get();
            if (!empty($state_data[0]) || !empty($city_data[0])) {
                return response()->json(['statusCode' => 200, 'message' => 'Data Available.', 'data' => array('state_data' => $state_data, 'city_data' => $city_data, 'country_code' => $phonecode_data)]);
            }
            return response()->json(['statusCode' => 200, 'message' => 'No Data Available.', 'data' => array('state_data' => $state_data, 'city_data' => $city_data, 'country_code' => $phonecode_data)]);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function newsFeed(Request $request)
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
            $data = News_feeds::where('status', '1')->orderBy('created_at', 'desc')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Data Available.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Blog.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function likeNewsFeed(Request $request)
    {
        try {
            $rules = [
                'news_feed_id' => 'required|numeric',
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
            $data = News_feeds::where('id', $request->news_feed_id)->first();
            if (!empty($data)) {
                $likedata = News_feed_likes::where('news_feed_id', $request->news_feed_id)->where('user_id', auth()->user()->id)->first();
                if (empty($likedata)) {
                    $input = $request->only('news_feed_id');
                    $input['user_id'] = auth()->user()->id;
                    $data1 = News_feed_likes::create($input);
                    if (!empty($data1)) {
                        $likecount = $data->like_count + 1;
                        $data->update(['like_count' => $likecount]);
                        return response()->json(['statusCode' => 200, 'message' => 'Liked.', 'data' => $data1]);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                } else {
                    $likedata->delete();
                    $likecount = $data->like_count - 1;
                    $data->update(['like_count' => $likecount]);
                    return response()->json(['statusCode' => 200, 'message' => ' Removed.', 'data' => $likedata]);
                }
            } else {
                return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function addNewsFeedComment(Request $request)
    {
        try {
            $rules = [
                'news_feed_id' => 'required|numeric',
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
            $input = $request->only('user_id', 'news_feed_id', 'message');
            $input['user_id'] = auth()->user()->id;
            $input['status'] = '1';
            $data = News_feed_comments::create($input);
            if (!empty($data)) {
                $data = News_feed_comments::with('userdata', 'newsfeeddata')->where('id', $data->id)->first();
                return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function newsFeedCommentList(Request $request)
    {
        try {
            $rules = [
                'news_feed_id' => 'required|numeric',
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
            $data = News_feed_comments::with('userdata', 'newsfeeddata')->where('news_feed_id', $request->news_feed_id)->orderBy('created_at', 'desc')->get();
            if (!empty($data[0])) {
                return response()->json(['statusCode' => 200, 'message' => ' Comments List.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Comments.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }

    public function newsFeedDetails(Request $request)
    {
        try {
            $rules = [
                'news_feed_id' => 'required|numeric',
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
            $data = News_feeds::where('id', $request->news_feed_id)->first();
            if (!empty($data)) {
                $view_count = $data->view_count + 1;
                $data->update(['view_count' => $view_count]);
                $likedata = News_feed_likes::where('news_feed_id', $request->news_feed_id)->where('user_id', auth()->user()->id)->first();
                if (!empty($likedata)) {
                    $data->is_like = 1;
                } else {
                    $data->is_like = 0;
                }
                $commentlist = News_feed_comments::with('userdata')->where('news_feed_id', $request->news_feed_id)->orderBy('created_at', 'desc')->get();
                $data->view_count = (string) $data->view_count;
                return response()->json(['statusCode' => 200, 'message' => ' Details Available.', 'data' => array('news_feed_data' => $data, 'commentlist' => $commentlist)]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'No Details.']);
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }


    public function commentEdit(Request $request)
    {
        try {
            $rules = [
                'comment_id' => 'required|numeric',
                'message' => 'required',
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
            $user_id = auth()->user()->id;
            if ($request->type == "newsfeed"){
                $data = News_feed_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
                if (!empty($data)) {
                    $data = News_feed_comments::where('id', $request->comment_id)->where('user_id', $user_id)->update(['message'=>$request->message]);
                    return response()->json(['statusCode' => 200, 'message' => 'Update Successfully.', 'data' => $data]);
                }else{
                    return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);        
                }
            }elseif ($request->type == "blog"){
                $data = Nutrition_blog_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
                if (!empty($data)) {
                    $data = Nutrition_blog_comments::where('id', $request->comment_id)->where('user_id', $user_id)->update(['message'=>$request->message]);
                    return response()->json(['statusCode' => 200, 'message' => 'Update Successfully.', 'data' => $data]);
                } else {
                    return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
                }
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Invalid Type.']);
            }
        } catch (Exception $e) {
            return response()->json(['statusCode' => 999, 'message' => $e->getMessage()]);
        }
    }
    
    public function commentDelete(Request $request)
    {
        try {
            $rules = [
                'comment_id' => 'required|numeric',
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
            $user_id = auth()->user()->id;
            if ($request->type == "newsfeed"){
                $data = News_feed_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
                if (!empty($data)) {
                    $data->delete();
                    return response()->json(['statusCode' => 200, 'message' => 'Remove Successfully.', 'data' => $data]);
                }else{
                    return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);        
                }
            }elseif ($request->type == "blog"){
                $data = Nutrition_blog_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
                if (!empty($data)) {
                    $data->delete();
                    return response()->json(['statusCode' => 200, 'message' => 'Remove Successfully.', 'data' => $data]);
                } else {
                    return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
                }
            }else{
                return response()->json(['statusCode' => 999, 'message' => 'Invalid Type.']);
            }
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
