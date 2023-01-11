<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;
use App\Models\Settings;
use App\Models\About_us_pages;
use FFMpeg;
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }
    public function index()
    {
        $settings = Settings::whereNotIn('type',['gst','privacy_policy','terms_conditions'])->get();
        $gst = Settings::where('type','gst')->first();
        return view('admin.settings',compact('settings','gst'));
    }

    public function edit($id)
    {
        $setting = Settings::where('id',$id)->first();
        if($setting) {
            return view('admin.settingUpdate',compact('setting'));
        }else{
            return redirect()->route('settings')->withError("Not Setting Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            // 'value' => 'required|mimes:jpg,png,jpeg',
        ]);
        $input = $request->only('value');
        if ($request->value && $request->type == "splash") {
            $videoName = $request->value->store('/videos');
            $input['value'] ='uploads/'.$videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid().time().'.png';
            $thumbnail = 'uploads/images/'.$imageTo;
            FFMpeg::fromDisk('videos')
            ->open($videoFrom[1])
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('thumbnail')
            ->save($imageTo);
            $input['thumbnail'] = $thumbnail;
        }
        if ($request->value && $request->type == "profile_comming_soon_image") {
            $pdfName = $request->value->store('/');
            $input['value'] = 'uploads/'. $pdfName;
        }
        $insert = Settings::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('settings')->withSuccess(ucfirst($request->title)." Update Successfully.");
        }else{
            return redirect()->route('settings')->withError("Updation Failed.");
        }
    }
    
    public function inviteHistory()
    {
        $users =  User::with('referbyuserdata')->where('refer_by','!=',NULL)->get();
        // dd($users);exit;
        return view('admin.inviteHistory',compact('users'));
    }

    public function aboutusPage()
    {
        $content1 = About_us_pages::where('type','content')->where('id','1')->first();
        $content2 = About_us_pages::where('type','content')->where('id','2')->first();
        $members = About_us_pages::where('type','member')->get();
        return view('admin.about-us.edit',compact('content1','content2','members'));
    }

    public function aboutusPageUpdate(Request $request)
    {
        $request->validate([
            // 'id' => 'required',
        ]);
        // print_r($request->all());exit;
        if(!empty($request->content[1])){
            $input_content1['type'] = 'content'; 
            $input_content1['title'] = $request->content[1]['title']; 
            $input_content1['description'] = $request->content[1]['description']; 
            $input_content1['status'] = $request->content[1]['status']; 
            if (!empty($request->content[1]['des_image'])) {
                $imageName = $request->content[1]['des_image']->store('/');
                $input_content1['des_image'] = 'uploads/'. $imageName;
            }
            $update_input_content1 = About_us_pages::updateOrCreate(['id'=>1],$input_content1);
        }
        
        if(!empty($request->content[2])){
            $input_content2['type'] = 'content'; 
            $input_content2['title'] = $request->content[2]['title']; 
            $input_content2['description'] = $request->content[2]['description']; 
            $input_content2['status'] = $request->content[2]['status']; 
            if (!empty($request->content[2]['des_image'])) {
                $imageName = $request->content[2]['des_image']->store('/');
                $input_content2['des_image'] = 'uploads/'. $imageName;
            }
            $update_input_content2 = About_us_pages::updateOrCreate(['id'=>2],$input_content2);
        }
        
        if(!empty($request->member[0])){
            foreach ($request->member as $key => $value) {
                $input_member['type'] = 'member'; 
                $member_id = @$request->member[$key]['member_id']; 
                $input_member['member_name'] = $request->member[$key]['member_name']; 
                $input_member['member_role'] = $request->member[$key]['member_role']; 
                $input_member['facebook_link'] = $request->member[$key]['facebook_link']; 
                $input_member['instagram_link'] = $request->member[$key]['instagram_link']; 
                $input_member['youtube_link'] = $request->member[$key]['youtube_link']; 
                $input_member['status'] = $request->member[$key]['status'] ?? 1; 
                if (!empty($request->member[$key]['member_image'])) {
                    $imageName = $request->member[$key]['member_image']->store('/');
                    $input_member['member_image'] = 'uploads/'. $imageName;
                }
                $update_input_member = About_us_pages::updateOrCreate(['id'=>$member_id],$input_member);
            }

        }
        
        if(!empty($update_input_content1) || !empty($update_input_content2) || !empty($update_input_member) ) {
            return redirect()->back()->withSuccess("Update Successfully.");
        }else{
            return redirect()->back()->withError("Updation Failed.");
        }
    }

    public function removeMemberAboutus(Request $request){
        $data = About_us_pages::where('id', $request->member_id)->first();
        if (!empty($data)) {
            $data = About_us_pages::where('id', $request->member_id)->delete();
            $members = About_us_pages::where('type', 'member')->count();

            return response()->json(['statusCode' => 200, 'message' => 'Notification Remove Successfully.', 'count' => $members, 'data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Notification not found.']);

    }

    
}
