<?php

namespace App\Helpers;

use App\Models\Live_videos;
use App\Models\Notifications;
use App\Models\User;
use App\Models\User_orders;
use Carbon\Carbon;

class ApiHelper
{
    public static function sendNotification($fcm_token, $notification, $extraNotificationData)
    {
        try {
            $accessToken = env('FCM_API_KEY');
            // $accessToken = "eOsbwxZIGk5rrb-Z-obm9q:APA91bEFYXveLQ--uTWLdHSuNNGeYJCCuNbERRPLKV6wsF6h7kB2eE6JK4QU3qjVMBKTbGsXbemHWGm2zpgzT1UWp-YDejuafSGXpTNR9UDeYBSA_iCGijdOw_WNtaRIwvc34iq_bfiY";
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $fcm_token, //single token
                'notification' => $notification,
                'data' => $extraNotificationData,
            ];
            $headers = [
                'Authorization: key=' . $accessToken,
                'Content-Type: application/json',
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);

            return response()->json(['status' => true, 'msg' => 'Notification sent successfully.', 'data' => $result]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public static function sendNotificationBulk($fcm_token, $notification, $extraNotificationData)
    {
        try {
            $accessToken = env('FCM_API_KEY');
            // $accessToken = "eOsbwxZIGk5rrb-Z-obm9q:APA91bEFYXveLQ--uTWLdHSuNNGeYJCCuNbERRPLKV6wsF6h7kB2eE6JK4QU3qjVMBKTbGsXbemHWGm2zpgzT1UWp-YDejuafSGXpTNR9UDeYBSA_iCGijdOw_WNtaRIwvc34iq_bfiY";
            $fcmNotification = [
                'registration_ids' => $fcm_token, //multple token array
                // 'to' => $fcm_token, //single token
                'notification' => $notification,
                'data' => $extraNotificationData,
            ];
            $headers = [
                'Authorization: key=' . $accessToken,
                'Content-Type: application/json',
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);

            return response()->json(['status' => true, 'msg' => 'Notification sent successfully.', 'data' => $result]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

    public static function sendMobileOtp($otp, $phone)
    {
        $ch = curl_init();
        $url = "http://smsjust.com/sms/user/urlsms.php";
        $dataArray = ['username' => 'missionsports', 'pass' => 'user@123', 'senderid' => 'MSAAPP', 'message' => "Dear customer, Your OTP number is " . $otp . " Don't share it with anyone - Mission Sports", 'dest_mobileno' => "'.$phone.'", 'msgtype' => 'TXT', 'response' => 'Y', 'dltentityid' => '1201159168063308595', 'dlttempid' => '1607100000000186990', 'tmid' => '1602100000000004471'];
        $data = http_build_query($dataArray);
        $getUrl = $url . "?" . $data;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
        $response = curl_exec($ch);
        // if(curl_error($ch)){
        //     echo 'Request Error:' . curl_error($ch);
        // }else{
        //     echo $response;
        // }
        curl_close($ch);

    }

    public static function sendEmailOtp($otp, $email)
    {
        \Mail::raw("Dear customer, Your OTP number is " . $otp . " Don't share it with anyone - Mission Sports", function ($message) use ($email) {
            $message->to($email)
                ->subject("OTP");
        });
    }
    
    public static function sendEmailMessage($message_data, $email,$subject = 'New Mail')
    {

        \Mail::raw($message_data, function ($message) use ($email, $subject) {
            $message->to($email)
                ->subject($subject);
        });
    }

    public static function getUserFrc($user_id)
    {
        $user = User::where('id', $user_id)->first();
        $date = Carbon::parse($user->dob);
        $now = Carbon::now();
        $user->age = $date->diff($now)->format('%y');

        if ($user->height_type == "Inch" || $user->height_type == "Feet") {
            $height_cm = (($user->height_feet * 12) + $user->height_inch) * 2.54;
        } else {
            $height_cm = $user->height_feet + ($user->height_inch / 10);
        }

        if ($user->gender == "female") {
            $user->ibw = number_format(($height_cm - 105), 2); // ibw = height(cm) - 105
        } else {
            $user->ibw = number_format(($height_cm - 100), 2); // ibw = height(cm) - 100
        }

        if ($user->age < 18) {
            $user->ibw = 0; // ibw = height(cm) - 100
        }

        $height_mtr = $height_cm / 100;
        if ($user->weight_type == "Lbs") {
            $kgweight = $user->weight / 2.205;
        } else {
            $kgweight = $user->weight;
        }
        if ($height_mtr > 0) {
            $user->bmi = number_format(($kgweight / ($height_mtr * $height_mtr)), 2); // BMI = Weight(kg) /height (m)2
        } else {
            $user->bmi = 0; // BMI = Weight(kg) /height (m)2
        }

        $estimator = $user->bmi;
        if ($estimator < 18.5) {
            $user->frc_category = 'Underweight';
            $user->frc_color = 'blue'; //dark blue
            $user->bmi_range = 'Below 18.5'; //dark blue
        } elseif ($estimator >= 18.5 && $estimator <= 24.99) {
            $user->frc_category = 'Normal weight';
            $user->frc_color = 'green'; //green
            $user->bmi_range = '18.5 - 24.9'; //green
        } elseif ($estimator >= 25 && $estimator <= 29.99) {
            $user->frc_category = 'Overweight';
            $user->frc_color = 'yellow'; //yellow
            $user->bmi_range = '25.0 - 29.9'; //yellow
        } elseif ($estimator >= 30 && $estimator <= 34.99) {
            $user->frc_category = 'Obesity Class I';
            $user->frc_color = 'orange'; //orange
            $user->bmi_range = '30.0 - 34.9'; //orange
        } elseif ($estimator >= 35 && $estimator <= 39.99) {
            $user->frc_category = 'Obesity Class II';
            $user->frc_color = 'pink'; //pink
            $user->bmi_range = '35.0 - 39.9'; //pink
        } elseif ($estimator >= 40) {
            $user->frc_category = 'Obesity Class III';
            $user->frc_color = 'red'; //red
            $user->bmi_range = 'Above 40'; //red
        }

        if ($user) {
            return $user;
        } else {
            return false;
        }
    }

    public static function sendLiveSessionNotification()
    {
        $currentdate_time = date("Y-m-d H:i:00");
        $add_tenmin_time = date("Y-m-d H:i:00", strtotime("+10 minutes"));
        $add_thirtymin_time = date("Y-m-d H:i:00", strtotime("+30 minutes"));
        $add_sixtymin_time = date("Y-m-d H:i:00", strtotime("+60 minutes"));
        $add_fivemin_time = date("Y-m-d H:i:00", strtotime("+5 minutes"));

        // $currentdate_time = Carbon::now();
        // $add_tenmin_time = Carbon::now()->addMinutes(10);
        // $add_thirtymin_time = Carbon::now()->addMinutes(30);
        // $add_sixtymin_time = Carbon::now()->addMinutes(60);
        $currentdate = date("Y-m-d");
        $today_name = Carbon::now()->format("l");

        if ($today_name == "Monday" || $today_name == "Wednesday" || $today_name == "Friday") {
            
            $users = User::where('id', '!=', '1')->where('is_complete_freetrial', '1')->where('user_type', 'user')->get();
            // $data =  Live_videos::where('status','1')->where('start_date_time','=',$add_tenmin_time)->get();
            $data = Live_videos::where(function ($query) use ($add_fivemin_time, $add_thirtymin_time) {
                $query->where('start_date_time','=', $add_thirtymin_time)
                ->orWhere('start_date_time','=', $add_fivemin_time);
            })->where('status', '1')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    $user_token = [];
                    $title = "Session Reminder!!!";
                    $body = "Your Live session " . $value->title . " will start soon.";
                    
                    foreach ($users as $user) {
                        $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->count();
                        if ($order_data >= 1) {
                            $input['type_id'] = null;
                            $input['title'] = $title;
                            $input['status'] = '0';
                            $input['user_id'] = $user->id;
                            $insert = Notifications::create($input);
                            // $extraNotificationData = array('click_action' => "live_session", 'image' => $value->thumbnail);
                            if (!empty($user->device_token)) {
                                $user_token[] = $user->device_token;
                            }
                        }
                    }
                    $notification = array('body' => $body, 'title' => $value->title);
                    $extraNotificationData = array('click_action' => "live_session");
                    $sendNotification = ApiHelper::sendNotificationBulk($user_token, $notification, $extraNotificationData);
                    \Log::info("livesession notification:" . $sendNotification);
                    return response()->json(['statusCode' => 200, 'message' => 'Send Successfully.']);
                }
            }
        }
        return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
    }

    public static function checkFreetrialExpiry()
    {
        $data = User::where(function ($query) {
            $query->where('freetrial_duration', '!=', null)
                ->where('freetrial_duration', '<', date("Y-m-d H:i:s"));
        })->where('is_active_freetrial', '1')->where('is_complete_freetrial', '0')->where('status', '1')->get();
        if (!empty($data[0])) {
            foreach ($data as $key => $value) {
                if ($value->freetrial_duration < date("Y-m-d H:i:s")) {
                    // $value->is_active_freetrial = '0';
                    $value->is_complete_freetrial = '1';
                    $value->freetrial_duration = date("Y-m-d H:i:s");
                    $value->save();

                    $message_data_freetrial = "Dear ".$value->name.", Your Free trial expired!";
                    @$sendemail = ApiHelper::sendEmailMessage($message_data_freetrial, $value->email,"Free Trial");
                }
            }
            return response()->json(['statusCode' => 200, 'message' => 'Updated Successfully.']);
        }
        return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);
    }
    
    public static function checkUserPackageExpiry()
    {
        $order_data = User_orders::with('order_items')
                                    ->where('payment_status', "complete")
                                    ->where('package_status', '!=',"expired")
                                    ->whereHas('order_items', function($query) {
                                        $query->whereDate('end_date', '<', date('Y-m-d'));
                                        $query->orderBy('end_date','desc');
                                    })->get();
        foreach ($order_data as $key => $value) {
            @$user_data = User::where('id',$value->user_id)->first();
            @$package_data = Servicepackages::where('id', $value->package_id)->first();
            $value->package_status = "expired";
            $value->save();
            if ($value->save()) {
                $message_data = "Dear " . @$user_data->name . ", Your Plan: " . @$package_data->title . " was expired.";
                @$sendemail = ApiHelper::sendEmailMessage($message_data_freetrial, $user_data->email, "Package");
                
            }
        }

    }

    public static function sendWaterIntakeNotification()
    {
        $current_time = date("H:i:00");
        $datetime_6AM = date("H:i:s", strtotime("06:00:00"));
        $datetime_8PM = date("H:i:s", strtotime("20:00:00"));
        if ($current_time >= $datetime_6AM && $current_time <= $datetime_8PM) {
            $users = User::where('role_id', '!=', '1')->where('user_type', 'user')->get();
            $title = "Water Intake reminder!!!";
            $body = "Have you had your SIP of water?";
            $user_token = [];

            foreach ($users as $user) {
                $input1['type_id'] = null;
                $input1['title'] = $title;
                $input1['status'] = '0';
                $input1['user_id'] = $user->id;
                $insert = Notifications::create($input1);
                // $notification = array('body' => $body, 'title' => $title);
                // $extraNotificationData = array('click_action' => "nutrition");
                if (!empty($user->device_token)) {
                    $user_token[] = $user->device_token;
                    // $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
                    // \Log::info("sendWaterIntakeNotification notification send." .date("Y-m-d H:i:s"). $user->id . '-----' . $abc);
                }
            }
            $notification = array('body' => $body, 'title' => $title);
            $extraNotificationData = array('click_action' => "nutrition");
            $sendNotification = ApiHelper::sendNotificationBulk($user_token, $notification, $extraNotificationData);
            \Log::info("sendWaterIntakeNotification.:" . $sendNotification);
            // \Log::info("sendWaterIntakeNotification notification send -> " . date("Y-m-d H:i:s"));
            echo "Send Successfully";

        }

    }

    public static function sendTimelyLiveSessionNotificationForAdult()
    {
        $add_time = date("Y-m-d H:i:00");
        $add_time_one = date("Y-m-d 00:00:00", strtotime("+1 day"));
        $today_name = Carbon::now()->format("l");

        if ($today_name == "Monday" || $today_name == "Wednesday" || $today_name == "Friday") {
            $data = Live_videos::where(function ($query) use ($add_time, $add_time_one) {
                $query->where('start_date_time','>', $add_time)
                    ->where('start_date_time','<', $add_time_one);
            })->where('status', '1')->where('user_type', 'adult')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    // $add_thirtymin_time = Carbon::now()->addMinute(30)->format('Y-m-d H:i:00');
                    // if ($add_thirtymin_time == $value->start_date_time) {
                        $users = User::where('id', '!=', '1')->where('user_type', 'user')->get();
                        $user_token = [];
                        foreach ($users as $user) {
    
                            $date = Carbon::parse($user->dob);
                            $now = Carbon::now();
                            $age = $date->diff($now)->format('%y');
                            if ($age > 18) {
                                $title = "Session Reminder!!!";
                                $body = "Your Live session : " . $value->title . " will start soon.";
                                $input['type_id'] = null;
                                $input['title'] = $title;
                                $input['status'] = '0';
                                $input['user_id'] = $user->id;
                                $insert = Notifications::create($input);
                                $notification = array('body' => $body, 'title' => $value->title);
                                $extraNotificationData = array('click_action' => "live_session",);
                                if (!empty($user->device_token)) {
                                    // $user_token[] = $user->device_token;
                                    $sendNotification = ApiHelper::sendNotificationBulk($user->device_token, $notification, $extraNotificationData);
                                    \Log::info("sendTimelyLiveSessionNotificationForAdult. userid:".$user->id.", age:".$age);
                                }
                            }
    
                        }
                        // $sendNotification = ApiHelper::sendNotificationBulk($user_token, $notification, $extraNotificationData);
                        // \Log::info("sendTimelyLiveSessionNotificationForAdult. userid:".$sendNotification);

                    // }

                }
                return response()->json(['statusCode' => 200, 'message' => 'Send Successfully.']);
            }
        }
        return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);

    }
    
    
    
    
    
    public static function sendTimelyLiveSessionNotificationForKid()
    {
        $add_time = date("Y-m-d H:i:00");
        $add_time_one = date("Y-m-d 00:00:00", strtotime("+1 day"));
        $today_name = Carbon::now()->format("l");
        
        if ($today_name == "Monday" || $today_name == "Wednesday" || $today_name == "Friday") {
            $data = Live_videos::where(function ($query) use ($add_time, $add_time_one) {
                $query->where('start_date_time','>', $add_time)
                    ->where('start_date_time','<', $add_time_one);
            })->where('status', '1')->where('user_type','!=','adult')->get();
            if (!empty($data[0])) {
                foreach ($data as $key => $value) {
                    // $add_sixtymin_time = Carbon::now()->addMinute(30)->format('Y-m-d H:i:00');
                    // if ($add_sixtymin_time == $value->start_date_time) {
                        $users = User::where('id', '!=', '1')->where('user_type', 'user')->get();
                        foreach ($users as $user) {


                            $date = Carbon::parse($user->dob);
                            $now = Carbon::now();
                            $age = $date->diff($now)->format('%y');
                            if ($age <= 18) {

                                $title = "Session Reminder!!!";
                                $body = "Your Live session : " . $value->title . " will start soon.";
                                $input['type_id'] = null;
                                $input['title'] = $title;
                                $input['status'] = '0';
                                $input['user_id'] = $user->id;
                                $insert = Notifications::create($input);
                                $notification = array('body' => $body, 'title' => $value->title);
                                $extraNotificationData = array('click_action' => "live_session", );
                                if (!empty($user->device_token)) {
                                    $abc = ApiHelper::sendNotification($user->device_token, $notification, $extraNotificationData);
                                    \Log::info("sendTimelyLiveSessionNotificationForKid notification send. userid:".$user->id.", age:".$age);
                                }
                            }
                        }
                    // }
                }
                return response()->json(['statusCode' => 200, 'message' => 'Send Successfully.']);
            }
        }
        return response()->json(['statusCode' => 999, 'message' => 'No Data Available.']);

    }

}
