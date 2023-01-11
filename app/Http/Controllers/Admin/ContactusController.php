<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_queries;

class ContactusController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

     public function index()
    {
        $contactus = User_queries::with('userdata')->orderBy('id',"desc")->get();
        return view('admin.contactus',compact('contactus'));
    }
    
    public function reply($id)
    {
        $reply = User_queries::with('userdata')->where('id',$id)->first();
        if($reply) {
            return view('admin.contactusUpdate',compact('reply'));
        }else{
            return redirect()->route('contact-us')->withError("Data Not Available.");
        }
    }

    public function view($id)
    {
        $reply = User_queries::with('userdata')->where('id',$id)->first();
        if($reply) {
            return view('admin.contactusView',compact('reply'));
        }else{
            return redirect()->route('contact-us')->withError("Data Not Available.");
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'admin_reply' => 'required',
        ]);
        $input = $request->only('admin_reply');
        $input['status'] = "replied";
        $insert = User_queries::where('id',$request->id)->update($input);
        if($insert) {
            $data = User_queries::with('userdata')->where('id',$request->id)->first();
            if (!empty($data->userdata->email)) {
                $email = $data->userdata->email;
                $reply = $request->admin_reply;
                $subject = $data->subject;
                $mail_res = \Mail::raw($reply , function ($message) use($email , $subject) {
                    $message->to($email)
                    ->subject($subject);
                });
            }
            return redirect()->route('contact-us')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('contact-us')->withError("Updation Failed.");
        }
    }

    public function delete($id)
    {
        $contactus = User_queries::find($id);
        if($contactus->delete()) {
            return redirect()->route('contact-us')->withSuccess(" Deleted Successfully.");
        }else{
            return redirect()->route('contact-us')->withError("Error! Please Try Again.");
        }
    }
    
}
