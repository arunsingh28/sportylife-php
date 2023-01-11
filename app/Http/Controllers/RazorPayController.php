<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_orders;
use App\Models\User;
use App\Models\User_carts;
use App\Models\User_cart_items;
use App\Models\Addon_persons;
use App\Models\Servicepackages;
use App\Models\User_order_items;
use Razorpay\Api\Api;
use Mail;
use Carbon\Carbon;

class RazorPayController extends Controller
{
    //razorpay payment start
    public function paymentPage(Request $request)
    {
        $orderdata    = User_orders::where('order_id', $request->orderid)->first();
    
            $user         = User::where('id', $orderdata->user_id??0)->first();
            $order_amount = $orderdata->final_amount ??null;

            $api = new Api(config('payments.razorpay_test_key'), config('payments.razorpay_test_secret'));

            $order = $api->order->create([
                'receipt'   => $orderdata->orderid,
                'amount'    => $order_amount * 100,
                'currency'  => 'INR',
            ]);

            $pay_orderid = $order['id'];
            $orderdata   = User_orders::where('order_id', $request->orderid)->update(array('razorpay_orderid' => $pay_orderid));

            return view('razorPay.paymentView', compact('user', 'order', 'orderdata'));
        
    }

    public function paymentUrl(Request $request)
    {
        if ($request->status == '1') {
            $status = $request->status;
            return view('payment-response', compact('status'));
        } else {
            $orderdata = User_orders::where('razorpay_orderid', $request->orderid)->update(array('razorpay_id' => $request->payid, 'payment_status' => "failed"));
            $status    = '0';
            return view('payment-response', compact('status'));
        }
    }

    public function razorpayPaymentcallback(Request $request)
    {
        $orderdata = User_orders::where('razorpay_orderid', $request->razorpay_order_id)->update([
            'razorpay_id'    => $request->razorpay_payment_id,
            'payment_status' => "complete"
        ]);

        if (!empty($orderdata)) {

            $orderdetail        = User_orders::where('razorpay_orderid', $request->razorpay_order_id)->first();
            @$addon_person_data = Addon_persons::where('user_id', $orderdetail->user_id)->where('order_id', $orderdetail->order_id)->update(array('cart_id' => null, 'status' => '1'));
            @$package_data      = Servicepackages::where('id', $orderdetail->parent_package_id)->first();

            $user = User::where('id', $orderdetail->user_id)->first();

            $purchase_games = '';

            $order_package_items = User_order_items::with('category')->where('order_primary_id', $orderdetail->id)->get();

            if ($order_package_items->count()) {

                foreach ($order_package_items as $key1 => $value1) {
                    $checkAlreadyPurchased = User_orders::where('user_id', $orderdetail->user_id)->where('payment_status', 'complete')->first();

                    if (empty($checkAlreadyPurchased)) {
                        $value1->status = '1';
                        $value1->save();
                    } else {
                        $checkAlready_package_items = User_order_items::with('category')->whereDate('end_date', '>=', date("Y-m-d"))->where('order_primary_id', $checkAlreadyPurchased->id)->update(['status' => '1']);
                    }


                    if (@$key1 == 0) {
                        @$purchase_games .= @$value1->title;
                    } else {
                        @$purchase_games .= $purchase_games . ',' . @$value1->title;
                    }
                }
            }

            $message_data = "Dear " . @$user->name . ", Your Plan: " . @$package_data->title . " was purchased successfully.";
            $email        = $user->email;
            $subject      = "Plan Purchased";

            $messageArray = [
                'message_data'     => $message_data,
                'name'             => $user->name,
                'subject'          => @$request->subject,
                'package_title'    => @$package_data->title,
                'package_duration' => @$package_data->package_duration,
                'duration_type'    => @$package_data->duration_type,
                'purchase_games'   => @$purchase_games
            ];

            $mail_res = Mail::send(
                'sendPlanPurchase',
                $messageArray,
                function ($message) use ($email, $subject) {
                    $message->to($email)
                        ->subject($subject);
                }
            );

            if (!empty($user)) {
                $user->is_use_refer = '1';
                $user->paid_type    = 'paid';

                if ($user->is_complete_freetrial != '1') {
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
            return redirect(route("razorpay-payment-url", array('status' => '1')));
        } else {
            return redirect(route("razorpay-payment-url", array('status' => '0')));
        }
    }
}
