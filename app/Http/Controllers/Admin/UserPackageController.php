<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicepackages;
use App\Models\User;
use App\Models\User_orders;
use App\Models\User_order_items;
use Illuminate\Http\Request;

class UserPackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function show($id) {
        $user = User::where('id',$id)->first();
        if($user) {
            return view('admin.user-packages.index',compact('user'));
        }else{
            return redirect()->route('users')->withError("Not User Available.");
        }
    }
    
    public function view($id) {
        $user = User::where('id',$id)->first();
        $family_user = User::where("parent_id",$id)->orderBy("first_name",'asc')->get(); 
        if($user) {
            return view('admin.user-packages.members',compact('user','family_user'));
        }else{
            return redirect()->route('users')->withError("Not User Available.");
        }
    }
    
    public function deleteUserPackage($id, $user_id) {
        
        $User_orders = User_orders::where("id",$id)->first(); 
        if($User_orders) {
            if ($User_orders->delete()) {
                @$User_order_items = User_order_items::where("order_primary_id",$id)->delete(); 
                $order_data = User_orders::where('user_id', $user_id)->where('payment_status', "complete")->count();
                if ($order_data <= 1) {
                    @$user_data = User::where('id',$user_id)->update(['paid_type'=>NULL]);
                    
                }
                return redirect()->back()->withSuccess("Remove Successfully.");
            }
            return redirect()->back()->withError("Remove Failed.");
        }else{
            return redirect()->back()->withError("Data Not Available.");
        }
    }
}
