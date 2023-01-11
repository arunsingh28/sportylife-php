<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Live_videos;
use App\Models\Live_video_users;
use App\Models\Workoutcategories;
use FFMpeg;
use Carbon\Carbon;
use App\Jobs\compressVideo;

class LivevideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Live_videos::with('workoutcategorydata')->get();
        foreach ($data as $key => $value) {
            $data1 = Live_video_users::where('video_id', $value->id)->count();
            $value->total_joiners = @$data1 ?? '0';
        }

        return view('admin.live-video.index',compact('data'));
    }
    public function add() 
    {
        $workoutcate = Workoutcategories::where('status','1')->get();
        return view('admin.live-video.add',compact('workoutcate'));
    }
    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'user_type' => 'required',
            'description' => 'required',
            'start_date_time' => 'required',
            'status' => 'required',
            'video' => 'required|mimes:mp4',
        ]);

        $existdata =  Live_videos::whereDate('start_date_time', date("Y-m-d",strtotime($request->start_date_time)))->where('user_type',$request->user_type)->get();
        if (!empty($existdata[0])) {
            return redirect()->back()->withError("Already Added!");    
        }
        // foreach ($existdata as $key => $value) {
        //     $date = Carbon::parse($value->start_date_time);
        //     $dayname = $date->format('l');
        //     if (($dayname=="Monday" && ($request->user_type == $value->user_type)) || ($dayname=="Wednesday" && ($request->user_type == $value->user_type)) || ($dayname=="Friday" && ($request->user_type == $value->user_type)) ) {
        //         // if ($request->user_type == $value->user_type) {
        //             return redirect()->back()->withError("Already Added!");
        //         // }
        //     }
        // }
        $input = $request->only('title', 'category_id', 'user_type', 'description', 'start_date_time', 'status','is_allow_free_trial');
        $input['is_allow_free_trial'] = $request->is_allow_free_trial ? '1' : '0';
        if ($request->video) {
            $videoName = $request->video->store('/videos');
            $media = FFMpeg::open($videoName);
            $durationInSeconds = $media->getDurationInSeconds();
            $input['video'] ='uploads/'.$videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid().time().'.png';
            $thumbnail = 'uploads/images/'.$imageTo;

            FFMpeg::fromDisk('videos')
            ->open($videoFrom[1])
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('thumbnail')
            ->save($imageTo);

            $new = 'compressed'.$videoFrom[1];
            // FFMpeg::fromDisk('videos')
            // ->open($videoFrom[1])
            // ->export()
            // ->inFormat(new \FFMpeg\Format\Video\X264)
            // ->resize(480, 360)
            // ->save($new);
            // if(file_exists($input['video'])) {
            //     unlink($input['video']);
            // }
            $response = compressVideo::dispatchSync($videoFrom[1]);

            $input['video'] = "uploads/videos/".$new;
            $input['thumbnail'] = $thumbnail;
            $input['length'] = $durationInSeconds;
            // $input['end_date_time'] = date("Y-m-d H:i:s", strtotime("+".$durationInSeconds." seconds",$request->start_date_time));
            $input['end_date_time'] = Carbon::parse($request->start_date_time)->addSeconds($durationInSeconds)->format('Y-m-d H:i:s');
        }
        $insert = Live_videos::create($input);
        if($insert) {
            return redirect()->route('live-videos')->withSuccess("Added Successfully.");
        }else{
            return redirect()->route('live-videos')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $data = Live_videos::where('id',$id)->first();
        $workoutcate = Workoutcategories::all();
        if($data) {
            return view('admin.live-video.edit',compact('data','workoutcate'));
        }else{
            return redirect()->route('live-videos')->withError("Not Data Available.");
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'user_type' => 'required',
            'description' => 'required',
            'start_date_time' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'category_id', 'user_type', 'description', 'start_date_time', 'status','is_allow_free_trial');
        // $existdata =  Live_videos::where('end_date_time','>=',$currentdate_time)->get();
        
        $input['is_allow_free_trial'] = $request->is_allow_free_trial ? '1' : '0';
        $input['end_date_time'] = Carbon::parse($request->start_date_time)->addSeconds($request->length)->format('Y-m-d H:i:s');
        if ($request->video) {
            $videoName = $request->video->store('/videos');
            $media = FFMpeg::open($videoName);
            $durationInSeconds = $media->getDurationInSeconds();
            $input['video'] ='uploads/'.$videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid().time().'.png';
            $thumbnail = 'uploads/images/'.$imageTo;
            
            FFMpeg::fromDisk('videos')
            ->open($videoFrom[1])
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('thumbnail')
            ->save($imageTo);

            $new = 'compressed'.$videoFrom[1];
            // FFMpeg::fromDisk('videos')
            // ->open($videoFrom[1])
            // ->export()
            // ->inFormat(new \FFMpeg\Format\Video\X264)
            // ->resize(480, 360)
            // ->save($new);
            
            // if(file_exists($input['video'])) {
            //     unlink($input['video']);
            // }
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['video'] = "uploads/videos/".$new;
            $input['thumbnail'] = $thumbnail;
            $input['length'] = $durationInSeconds;
            $input['end_date_time'] = Carbon::parse($request->start_date_time)->addSeconds($durationInSeconds)->format('Y-m-d H:i:s');
        }
        $insert = Live_videos::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('live-videos')->withSuccess("Data Updated Successfully.");
        }else{
            return redirect()->route('live-videos')->withError("Updatation Failed!");
        }
    }
    public function delete($id)
    {
        $data = Live_videos::find($id);
        if($data->delete()) {
            return redirect()->route('live-videos')->withSuccess(" Deleted Successfully.");
        }else{
            return redirect()->route('live-videos')->withError("Error! Please Try Again.");
        }
    }
    public function changeLiveVideoStatus(Request $request)
    {
        $data = Live_videos::find($request->id);
        $data->status = $request->status;
        $data->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
    
}
