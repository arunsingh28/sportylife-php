<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_diet_datas;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use App\Mail\sendFrcDetail;
use Mail;
use FFMpeg;
use App\Helpers\ApiHelper;



class FRCController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
         $data = User::where('role_id','!=','1')->orderBy("created_at","desc")->get();
        return view('admin.frc.index',compact('data'));
    }
    
    public function testHtml()
    {
        $user = ApiHelper::getUserFrc('11');
        return view('frcemailview',compact('user'));
    }
    
    public function view($user_id)
    {
        $user = ApiHelper::getUserFrc($user_id);
        return view('admin.frc.view',compact('user'));
    }
    
    public function share($user_id)
    { 
        $user = ApiHelper::getUserFrc($user_id);
        if (!empty($user)) {
            Mail::to($user->email)->send(new sendFrcDetail($user));
            return redirect()->route('users-frc')->withSuccess("FRC Details Shared Successfully");
        }else{
            return redirect()->route('users-frc')->withError("Error! Please Try Again.");
        }
    }

    public function attachmentupload(Request $request)
    { 
        $pdfName = $request->file->store('/');
        $input['frc_pdf'] = 'uploads/'. $pdfName;
        
        $insert = User::where('id',$request->id)->update($input);
        if($insert) {
            return response()->json(['statusCode' => 200, 'message' => 'Upload Successfully.','data' => $insert]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Upload Failed.']);
        }

    }
    public function removeattachment(Request $request)
    { 
        $input['frc_pdf'] = NULL;
        
        $insert = User::where('id',$request->id)->update($input);
        if($insert) {
            return response()->json(['statusCode' => 200, 'message' => 'Remove Successfully.','data' => $insert]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => ' Failed.']);
        }

    }

    
}
