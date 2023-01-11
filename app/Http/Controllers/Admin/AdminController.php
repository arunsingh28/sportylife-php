<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicepackages;
use App\Models\User;
use App\Models\User_orders;
use Carbon\Carbon;
use DB;
use App\Helpers\ApiHelper;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function dashboard()
    {
        $user = auth()->user(); 
        $message = '';
        if($user->role_id == '1' && $user->is_verify == '0'){
            $otp = rand(100000, 999999);
            $input1['otp'] = $otp;
            $user1 = User::where('email', $user->email)->update($input1);
            // $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone);
            $sendemail = ApiHelper::sendEmailOtp($otp, $user->email);
            $message = "OTP sent to your email and mobile. Please verify OTP.";
        }

        $package_count = Servicepackages::where('status', "1")->get()->count();
        $total_orders = User_orders::where('payment_status', "complete")->get();
        $total_earn = $total_orders->sum('final_amount');
        $total_order_count = $total_orders->count();
        $total_user_count = User::where('status', "1")->get()->count();

        //weekdata
        $week = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $weekdata = User_orders::select(
            DB::raw("SUM(final_amount) as total_final_amount"),
            DB::raw("DAYNAME(created_at) as day_name")
        )
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('payment_status', "complete")
            ->whereYear('created_at', date('Y'))
            ->groupBy('day_name')
            ->get();
        //weekdata
        //monthdata
        // $month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        // $monthdata = User_orders::select(
        //                     DB::raw("SUM(final_amount) as total_final_amount"),
        //                     DB::raw("MONTHNAME(created_at) as month_name")
        //                 )
        //                 ->whereYear('created_at', date('Y'))
        //                 ->where('payment_status',"complete")
        //                 ->groupBy('month_name')
        //                 ->get();

        $months = User_orders::select('id', 'final_amount', 'created_at')
            ->where('payment_status', "complete")
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $monthcount = [];
        $montharr = [];
        foreach ($months as $key => $value) {
            $total = 0;
            foreach ($value as $key1 => $value1) {
                $total = $total+@$value1['final_amount'];
            }
            $monthcount[(int) $key] = $total;
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($monthcount[$i])) {
                $montharr[$i] = $monthcount[$i];
            } else {
                $montharr[$i] = 0;
            }
        }
        //monthdata
        //yeardata
        $yeardata = User_orders::select(
            DB::raw("SUM(final_amount) as total_final_amount"),
            DB::raw("YEAR(created_at) as year")
        )
            ->where('payment_status', "complete")
            ->groupBy('year')
            ->get();
        //yeardata
        //quarterdata
        $quarterdata = User_orders::select(
            DB::raw("SUM(final_amount) as total_final_amount"),
            DB::raw("QUARTER(created_at) as quarter"),
        )
            ->where('payment_status', "complete")
            ->groupBy('quarter')
            ->get();
        //quarterdata
        //last6monthdata
        $dateS = Carbon::now()->endOfMonth()->subMonth(6);
        $dateE = Carbon::now()->startOfMonth()->subMonth(12);
        $dateC = Carbon::now()->startOfMonth();
        $prevsix = User_orders::select('id', 'final_amount', 'created_at')
            ->whereBetween("created_at", [$dateS, $dateC])
            ->where('payment_status', "complete")
            ->get();
        $total_prev = 0;
        foreach ($prevsix as $key => $value) {
            $total_prev = $total_prev + $value->final_amount;
        }
        //last6monthdata
        // $first_qur_date = Carbon::now()->subQuarters(1);
        // $second_qur_date = Carbon::now()->subQuarters(2);
        // $third_qur_date = Carbon::now()->subQuarters(3);
        // $fourth_qur_date = Carbon::now()->subQuarters(4);
        // $current_date = Carbon::now();
        //Quarterdata
        $start = Carbon::now()->startOfQuarter();
        $end = Carbon::now()->endOfQuarter();

        $start1 = Carbon::now()->startOfQuarter()->addQuarter(1);
        $end1 = Carbon::now()->startOfQuarter()->addQuarter(1)->endOfQuarter();

        $start2 = Carbon::now()->startOfQuarter()->addQuarter(1)->startOfQuarter()->addQuarter(1);
        $end2 = Carbon::now()->startOfQuarter()->addQuarter(1)->startOfQuarter()->addQuarter(1)->endOfQuarter();

        $start3 = Carbon::now()->startOfQuarter()->addQuarter(1)->startOfQuarter()->addQuarter(1)->startOfQuarter()->addQuarter(1);
        $end3 = Carbon::now()->startOfQuarter()->addQuarter(1)->startOfQuarter()->addQuarter(1)->startOfQuarter()->addQuarter(1)->endOfQuarter();
        // print_r($start->format("d-M-Y").'--');
        // print_r($end->format("d-M-Y").'|');
        // print_r($start1->format("d-M-Y").'|');
        // print_r($end1->format("d-M-Y").'|');
        // print_r($start2->format("d-M-Y").'|');
        // print_r($end2->format("d-M-Y").'|');
        // print_r($start3->format("d-M-Y").'|');
        // print_r($end3->format("d-M-Y").'|');

        // exit;
        $first_qur = User_orders::select('id', 'final_amount', 'created_at')
            ->whereBetween("created_at", [$start, $end])
            ->where('payment_status', "complete")
            ->get();
        // print_r($first_qur->toArray());
        $second_qur = User_orders::select('id', 'final_amount', 'created_at')
            ->whereBetween("created_at", [$start1, $end1])
            ->where('payment_status', "complete")
            ->get();
        // print_r($second_qur->toArray());
        $third_qur = User_orders::select('id', 'final_amount', 'created_at')
            ->whereBetween("created_at", [$start2, $end2])
            ->where('payment_status', "complete")
            ->get();
        // print_r($third_qur->toArray());
        $forth_qur = User_orders::select('id', 'final_amount', 'created_at')
            ->whereBetween("created_at", [$start3, $end3])
            ->where('payment_status', "complete")
            ->get();
        // print_r($forth_qur->toArray());

        // exit;
        // print_r($next2->format("d-M-Y"));exit;
        // 10-Jan-2022|10-Oct-2021|10-Jul-2021|10-Apr-2021|10-Jan-2021
        // 01-Jan-2022|31-Mar-2022|01-Jul-2022|01-Oct-2022|01-Jan-2023
        // $first_qur = User_orders::select('id','final_amount', 'created_at')
        //             ->whereBetween("created_at",[$current_date,$first_qur_date])
        //             ->where('payment_status',"complete")
        //             ->get();
        // $second_qur = User_orders::select('id','final_amount', 'created_at')
        //             ->whereBetween("created_at",[$second_qur_date,$first_qur_date])
        //             ->where('payment_status',"complete")
        //             ->get();
        // $third_qur = User_orders::select('id','final_amount', 'created_at')
        //             ->whereBetween("created_at",[$third_qur_date,$second_qur_date])
        //             ->where('payment_status',"complete")
        //             ->get();
        // $forth_qur = User_orders::select('id','final_amount', 'created_at')
        //             ->whereBetween("created_at",[$fourth_qur_date,$third_qur_date])
        //             ->where('payment_status',"complete")
        //             ->get();

        $total_first_qur = 0;
        foreach ($first_qur as $key => $value) {
            $total_first_qur = $total_first_qur + $value->final_amount;
        }
        $total_second_qur = 0;
        foreach ($second_qur as $key => $value) {
            $total_second_qur = $total_second_qur + $value->final_amount;
        }
        $total_third_qur = 0;
        foreach ($third_qur as $key => $value) {
            $total_third_qur = $total_third_qur + $value->final_amount;
        }
        $total_forth_qur = 0;
        foreach ($forth_qur as $key => $value) {
            $total_forth_qur = $total_forth_qur + $value->final_amount;
        }

        return view('admin.dashboard', compact('total_earn', 'package_count', 'total_user_count', 'total_order_count', 'yeardata', 'weekdata', 'quarterdata', 'montharr', 'total_prev', 'total_first_qur', 'total_second_qur', 'total_third_qur', 'total_forth_qur','message'));
    }

}
