<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon_persons;
use App\Models\Languages;
use App\Models\Meal;
use App\Models\Nutrition_diet_datas;
use App\Models\Servicecategories;
use App\Models\Servicepackages;
use App\Models\User;
use App\Models\User_completed_meals;
use App\Models\User_orders;
use App\Models\User_order_items;


use App\Models\Live_video_users;
use App\Models\News_feed_comments;
use App\Models\News_feed_likes;
use App\Models\Notifications;
use App\Models\Nutrition_blog_comments;
use App\Models\Nutrition_blog_likes;
use App\Models\Recipe_comments;
use App\Models\Recipe_likes;
use App\Models\User_carts;
use App\Models\User_cart_items;
use App\Models\User_diaries;
use App\Models\User_faq_datas;
use App\Models\User_newsletters;
use App\Models\User_queries;
use App\Models\User_search_keywords;
use App\Models\User_waterlevels;



use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    //
    public function loginPage()
    {
        return view('admin.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        Auth::logout();
        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = ['subadmin', 'admin'];
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt($credentials)) {
            $role_arr = ['1', '3', '4', '5'];
            if (Auth::user()->user_type != 'user') {
                // if (in_array(Auth::user()->role_id, $role_arr)) {
                // return redirect('/admin/dashboard')->withSuccess('Welcom to Sporty Life.');
                $user_data = User::with('roleData')->whereIn('user_type', ["admin","subadmin"])->where('email', $request->email)->first();
                if ($user_data->role_id == '1') {
                    // Auth::logout();
                    // $otp = rand(100000, 999999);
                    // $input1['otp'] = $otp;
                    // $user1 = User::where('email', $request->email)->update($input1);
                    // $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user_data->phone);
                    // $sendemail = ApiHelper::sendEmailOtp($otp, $request->email);
                    // return view('admin.verify-otp', compact('email', 'password'));
                    return redirect()->route('users')->withSuccess('Welcome to Sporty Life.');
                } elseif ($user_data->role_id == '4' || $user_data->role_id == '5') {
                    return redirect()->route('roles')->withSuccess('Welcome to Sporty Life.');
                }elseif (@$user_data->roleData->type == 'new') {
                    return redirect()->route('news-feed')->withSuccess('Welcome to Sporty Life.');
                }else{
                    return redirect()->route('users')->withSuccess('Welcome to Sporty Life.');
                }
                // return redirect()->route('admin.verify-otp')->withSuccess('Please Verify OTP.');
            } else {
                Auth::logout();
                return redirect('/admin/login')->withError('You Are Not Allowed!');
            }
        }
        return redirect()->back()->withError('Invalid username or password.');
        // return view('admin.login');
    }

    public function verifyOTPPage()
    {
        return view('admin.verify-otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);
        $user = User::where('id', $request->id)->where('otp', $request->otp)->first();
        if (!empty($user)) {
            // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user->otp = null;
            $user->is_verify = '1';
            $user->save();
            return redirect('/admin/dashboard');
            // }
        } else {
            // Auth::logout();
            return redirect()->back()->withError('Invalid OTP.');
        }
    }
    public function logout()
    {
        $user = Auth::user();
        if ($user->role_id == '1') {
            $input1['is_verify'] = '0';
            $user1 = User::where('id', $user->id)->update($input1);
        }

        Session::flush();
        Auth::logout();
        return redirect('/admin/login');
    }

    public function index()
    {
        $role_arr = ['1', '3', '4', '5'];
        $auth_user_id = auth()->user()->id;
        
        $users = User::with('languagedata', 'roledata')->where('role_id', '2')->orderBy("created_at", "desc")->get();

        foreach ($users as $key => $value) {
            $order_data = User_orders::where('user_id', $value->id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->get();
            if (!empty($order_data[0])) {
                $value->paid_status = 'Paid';
            } else {
                $value->paid_status = 'Unpaid';
            }
        }
        // $users = User::with('languagedata','roledata')->whereNotIn('role_id', $role_arr)->orderBy("created_at", "desc")->get();
        $language = Languages::where('status', '1')->get();
        $this->downloadExportCRM($users);
        $downloadExportLMS = $this->downloadExportLMS($users);

        $auth_user = User::with('roledata')->where('id', $auth_user_id)->first();
        $admin_data = User::where('role_id', '1')->where('user_type', 'admin')->where('id', '1')->first();

        return view('admin.users', compact('users', 'language', 'auth_user','admin_data'));
    }

    public function downloadExportLMS($users)
    {
        $file_name = "userlist_" . date("d_m_Y_H:i") . "_lms.csv";
        $file = fopen("public/uploads/" . $file_name, "w");
        @$check_update = User::where('id', '1')->where('user_type', 'admin')->first();
        if (!empty($check_update)) {
            // if ($check_update->userlist_lms_url) {
            //     unlink("public/uploads/".$check_update->userlist_lms_url);
            // }
            $user_update = User::where('id', '1')->where('user_type', 'admin')->update(['userlist_lms_url' => $file_name]);
        }
        fputcsv($file, array("firstname", "lastname", "email", "password", "account creation date", "Package", "Sports", " Total Members", "Members"));
        // fputcsv($file, array("Sr.No", "username", "firstname", "lastname", "email", "password", "account creation date", "Package", "Sports", " Total Members", "Members"));
        if (!empty($users[0])) {
            foreach ($users as $key => $value) {

                $family_members = Addon_persons::where("cart_id", null)->where("status", '1')->where("user_id", $value->id)->orderBy("person_first_name", 'asc')->select('id', 'user_id', 'person_first_name', 'person_last_name', 'person_email', 'person_phone', 'dob', 'gender')->get();
                $family_members_name = '';
                if (!empty($family_members[0])) {

                    foreach ($family_members as $key1 => $value1) {
                        if ($key1 == 0) {
                            $family_members_name = ($value1->person_first_name . ' ' . $value1->person_last_name);
                        } else {
                            $family_members_name = $family_members_name . ',' . ($value1->person_first_name . ' ' . $value1->person_last_name);
                        }

                    }
                }

                // print_r("----".$value->id."----");
                // $getUserPackageData = [];
                $getUserPackageData = $this->getUserPackage($value->id);
                $package_name = '';
                $item_name = '';
                if (!empty($getUserPackageData[0])) {
                    foreach ($getUserPackageData as $key2 => $value2) {
                        if (!empty($value2->package[0])) {
                            foreach ($value2->package as $key3 => $value3) {
                                if (@$key3 == 0) {
                                    $package_name .= @$value3->package_data->title;
                                } else {
                                    $package_name .= @$package_name . ',' . @$value3->package_data->title;
                                }
                                if (!empty($value3->package_data)) {
                                    if ($value3->package_data->is_sports_show == '1') {
                                        if (!empty($value3->item[0])) {
                                            foreach ($value3->item as $key4 => $value4) {
                                                if (@$key4 == 0) {
                                                    @$item_name .= @$value4->category_detail->title;
                                                } else {
                                                    @$item_name .= $item_name . ',' . @$value4->category_detail->title;
                                                }
                                            }

                                        }
                                    }

                                }
                            }
                        }

                    }
                }

                $create_data = date("d-m-Y", strtotime($value->created_at));
                $line = array(@$value->first_name, @$value->last_name, @$value->email, @$value->password_text, @$create_data, @$package_name, @$item_name, @$family_members->count(), @$family_members_name);
                fputcsv($file, $line);
            }

        }

        // exit;

        fclose($file);
    }

    public function downloadExportCRM($users)
    {
        $file_name = "userlist_" . date("d_m_Y_H:i") . "_crm.csv";
        $file = fopen("public/uploads/" . $file_name, "w");
        @$check_update = User::where('id', '1')->where('user_type', 'admin')->first();
        if (!empty($check_update)) {
            // if ($check_update->userlist_crm_url) {
            //     unlink("public/uploads/".$check_update->userlist_crm_url);
            // }
            $user_update = User::where('id', '1')->where('user_type', 'admin')->update(['userlist_crm_url' => $file_name]);
        }
        fputcsv($file, array("Sr No", "first name", "last name", "emailid", "Mobile no.", "DOB", "Gender", "Height", "Weight", "State", "City", "Unique Number", "Pincode", "Referral Code", "Language", "Date of creation"));

        foreach ($users as $key => $value) {
            $create_data = date("d-m-Y", strtotime($value->created_at));
            $height = $value->height_feet . '.' . $value->height_inch;
            $line = array(($key + 1), @$value->first_name, @$value->last_name, @$value->email, @$value->phone, @$value->dob, @$value->gender, @$height, @$value->weight, @$value->state, @$value->city, @$value->school_unique_id, @$value->zipcode, @$value->refer_by, @$value->languagedata->language_title, @$create_data);
            fputcsv($file, $line);
        }
        // exit;

        fclose($file);
    }

    public function getUserPackage($user_id)
    {
        $order_data = User_orders::where('user_id', $user_id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->get();
        $result = array();
        if (!empty(@$order_data[0])) {
            foreach ($order_data as $key => $value) {
                $result[$key] = $value;
                $order_items = User_order_items::select('package_id')->where('order_primary_id', $value->id)->distinct()->get();

                $package = array();

                if (!empty(@$order_items[0])) {
                    foreach ($order_items as $key1 => $value1) {
                        $index = $value1->package_id;
                        $order_package_items = User_order_items::where('order_primary_id', $value->id)->where('package_id', $index)->orderBy("category_year_srno", "desc")->get();
                        $value1->expiry_date = date("d/m/Y", strtotime($order_package_items[0]['end_date']));
                        $package_detail = Servicepackages::where('id', $value1->package_id)->first();

                        $addon_package_detail = Servicepackages::where('parent_id', $value1->package_id)->first();

                        if (!empty(@$addon_package_detail)) {
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
                        $value1->package_data = $package_detail;
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
                        if (!empty(@$order_package_items[0])) {
                            foreach ($order_package_items as $key2 => $value2) {
                                $items[$key2] = $value2;
                            }
                        }
                        $package[$key1]['item'] = $items;

                        @$addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $index)->get();
                        if (!empty(@$addon_personData[0])) {
                            $package[$key1]['addon_person_list'] = @$addon_personData;
                        }

                        $category_detail = array();
                        if (!empty(@$package[$key1]['item'][0])) {
                            foreach ($package[$key1]['item'] as $key3 => $value3) {
                                $category_detail = Servicecategories::where('id', $value3->category_id)->first();
                                $value3->category_detail = $category_detail;
                            }

                        }
                    }
                } else {
                    if ($value->type == "addon_person" || $value->type == "addon_sport") {
                        $package_detail = Servicepackages::where('id', $value->package_id)->first();

                        $addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $value->package_id)->get();
                        
                        $package[0]['package_id'] = @$package_detail->id;
                        if (@$value->type == "addon_person") {
                            if (@$package_detail->duration_type == "month") {
                                if (@$addon_personData[0]['created_at']) {
                                    $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $addon_personData[0]['created_at'])->addMonths(@$package_detail->package_duration);
                                }
                            } else {
                                if (@$addon_personData[0]['created_at']) {
                                    $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $addon_personData[0]['created_at'])->addYear(@$package_detail->package_duration);
                                }
                            }
                            $package[0]['expiry_date'] = @$end_date;
                            $package[0]['item'] = [];
                            $package[0]['addon_person_list'] = [];

                        }
                        $package[0]['addon_sport_package_id'] = null;
                        $package[0]['addon_person_package_id'] = null;
                        $package[0]['package_data'] = @$package_detail;
                    }
                }

                $result[$key]['package'] = @$package;

                // print("----".$user_id."----");
            }
        }

        return $result;
    }

    public function searchPage()
    {
        $role_arr = ['1', '3', '4', '5'];

        $users = User::where('role_id', '2')->get();
        $language = Languages::where('status', '1')->get();
        $auth_user_id = auth()->user()->id;
        $auth_user = User::with('roledata')->where('id', $auth_user_id)->first();
        $admin_data = User::where('role_id', '1')->where('user_type', 'admin')->where('id', '1')->first();


        return view('admin.users', compact('users', 'language', 'auth_user','admin_data'));

    }
    public function search(Request $request)
    {
        $language_id = $request->language_id;
        $user_pay_type = $request->user_pay_type;

        $role_arr = ['1', '3', '4', '5'];
        $auth_user_id = auth()->user()->id;
        $auth_user = User::with('roledata')->where('id', $auth_user_id)->first();
        $language = Languages::where('status', '1')->get();

        $users = User::where('role_id', '2');
        if (!empty($language_id)) {
            $users = $users->where('language_id', $language_id);
        }
        if (!empty($user_pay_type) && $user_pay_type == "Paid") {
            $users = $users->where('paid_type', 'paid');
        }
        if (!empty($user_pay_type) && $user_pay_type == "Unpaid") {
            $users = $users->where('paid_type', null);

        }

        $users = $users->get();
        foreach ($users as $key => $value) {
            $order_data = User_orders::where('user_id', $value->id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->get();
            if (!empty($order_data[0])) {
                $value->paid_status = 'Paid';
            } else {
                $value->paid_status = 'Unpaid';
            }
        }

        return view('admin.users', compact('users', 'language', 'language_id', 'auth_user', 'user_pay_type'));

    }
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return view('admin.userUpdate', compact('user'));
        } else {
            return redirect()->route('users')->withError("Not User Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
        // dd($request->all());
        $input = $request->only('name', 'status', 'dob', 'gender', 'city', 'state', 'weight', 'height_feet', 'height_inch');
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/' . $imageName;
        }
        $insert = User::where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('users')->withSuccess("User Update Successfully.");
        } else {
            return redirect()->route('users')->withError("Updation Failed.");
        }
    }

    public function changeUserStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function view($id)
    {
        $user = User::with('languagedata')->where('id', $id)->first();
        if ($user) {
            if ($user->refer_by != null) {
                $referby = User::where('referral_code', $user->refer_by)->first();
                if ($referby) {
                    $referbyuser = '<br><button class="btn btn-sm btn-default">' . @$referby->name . '</button>';
                } else {
                    $referbyuser = '<br><button class="btn btn-sm btn-default">N/A</button>';
                }
            } else {
                $referby = User::where('referral_code', $user->refer_by)->first();
                $referbyuser = "<h4>N/A</h4>";
            }
            return view('admin.userView', compact('user', 'referbyuser'));
        } else {
            return redirect()->route('users')->withError("Not User Available.");
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->forceDelete()) {

            @$addon_persons = Addon_persons::where('user_id',$id)->forceDelete();
            @$live_video_users = Live_video_users::where('user_id',$id)->forceDelete();
            @$news_feed_comments = News_feed_comments::where('user_id',$id)->forceDelete();
            @$news_feed_likes = News_feed_likes::where('user_id',$id)->forceDelete();
            @$notifications = Notifications::where('user_id',$id)->forceDelete();
            @$nutrition_blog_comments = Nutrition_blog_comments::where('user_id',$id)->forceDelete();
            @$nutrition_blog_likes = Nutrition_blog_likes::where('user_id',$id)->forceDelete();
            @$nutrition_diet_datas = Nutrition_diet_datas::where('user_id',$id)->forceDelete();
            @$recipe_comments = Recipe_comments::where('user_id',$id)->forceDelete();
            @$recipe_likes = Recipe_likes::where('user_id',$id)->forceDelete();
            @$user_carts = User_carts::where('user_id',$id)->get();
            if (!empty($user_carts[0])) {
                foreach ($user_carts as $key => $value) {
                    if (@$value->forceDelete()) {
                        @$user_cart_items = User_cart_items::where('cart_id',$value->id)->forceDelete();
                    }
                }
            }
            @$user_completed_meals = User_completed_meals::where('user_id', $id)->forceDelete();
            @$user_diaries = User_diaries::where('user_id', $id)->forceDelete();
            @$user_faq_datas = User_faq_datas::where('user_id', $id)->forceDelete();
            @$user_newsletters = User_newsletters::where('user_id', $id)->forceDelete();
            @$user_orders = User_orders::where('user_id', $id)->forceDelete();
            @$user_order_items = User_order_items::where('user_id', $id)->forceDelete();
            @$user_queries = User_queries::where('user_id', $id)->forceDelete();
            @$user_search_keywords = User_search_keywords::where('user_id', $id)->forceDelete();
            @$user_waterlevels = User_waterlevels::where('user_id', $id)->forceDelete();

            return redirect()->route('users')->withSuccess("User Deleted Successfully.");
        } else {
            return redirect()->route('users')->withError("Error! Please Try Again.");
        }
    }
    public function changePasswordPage()
    {
        $user = auth()->user();
        return view('admin.change-password.index', compact('user'));

    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'email|unique:users,email,' . $request->id,
            'phone' => 'numeric|unique:users,phone,' . $request->id,
            'password' => 'confirmed|min:8',
        ]);
        // dd($request->all());
        $input = $request->only('email', 'phone');
        if (!empty($request->password)) {
            $input['password_text'] = $request->password;
            $input['password'] = Hash::make($request->password);
        }
        $insert = User::where('role_id', '1')->where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('admin.change-password')->withSuccess("Update Successfully.");
        } else {
            return redirect()->route('admin.change-password')->withError("Updation Failed.");
        }
    }

    public function userProgressChart($id)
    {
        $user_id = $id;
        $user = User::with('languagedata')->where('id', $id)->first();
        // $todaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d'))->get();
        // $t_calorie = 0;
        // $frq_id = [];
        // foreach ($todaymealsdata as $key => $value) {
        //     $frq_id[] = $value->category_id;
        //     if ($value->meal_id != null) {
        //         $mealdetail = Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
        //         if (!empty($mealdetail)) {
        //             $t_calorie = $t_calorie+@$mealdetail->calorie;
        //         }
        //     }
        // }

        // $uni_cat = array_unique($frq_id);
        // $usermealdata = Nutrition_diet_datas::where('user_id', $user_id)->first();
        // if (!empty($usermealdata->diet)) {
        //     foreach ($usermealdata->diet as $key1 => $value1) {
        //         if (in_array($value1['frequency_id'], $uni_cat)) {
        //             $mealdetail = Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
        //             $t_calorie = $t_calorie + (@$mealdetail->calorie * $value1['quantity']);
        //         }
        //     }
        // }

        $months = User_completed_meals::where('user_id', $user_id)
            ->whereYear('date', date('Y'))
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->date)->format('m'); // grouping by months
            });

        $monthcount = [];
        $montharr = [];
        foreach ($months as $key => $value2) {
            $frq_id = [];
            $t_calorie = 0;
            foreach ($value2 as $key1 => $value) {
                // print_r(json_encode($value));exit;
                $frq_id[] = $value->category_id;
                if ($value->meal_id != null) {
                    $mealdetail = Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                    if (!empty($mealdetail)) {
                        $t_calorie = $t_calorie+@$mealdetail->calorie;
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
                    }
                }
            }
            // foreach ($value as $key1 => $value1) {
            //     $total = $total+@$value1['final_amount'];
            // }
            $monthcount[(int) $key] = $t_calorie;

        }

        for ($i = 1; $i <= 12; $i++) {
            if (!empty($monthcount[$i])) {
                $montharr[$i] = $monthcount[$i];
            } else {
                $montharr[$i] = 0;
            }
        }

        // print_r($months);exit;
        return view('admin.user-progress-chart.index', compact('user', 'montharr'));
    }

}
