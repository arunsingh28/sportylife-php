<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicecategories;
use App\Models\Sports_curriculums;
use FFMpeg;

class SportsCurriculumController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Sports_curriculums::with('sportdata')->get();
        foreach ($data as $key => $value) {
            if ($value->type == "sports") {
                $category =  Servicecategories::where('id', $value->category)->first();
                $value->category_title = $category->title;
            }else{
                if ($value->category == "sporty_kid_7") {
                    $value->category_title = "Sports Kid (4 to 7)";
                }else{
                    $value->category_title = "Sports Kid (7 to 9)";
                }
            }
        }
        return view('admin.sports-curriculums.index',compact('data'));
    }
    public function add() 
    {
        $sportcategory = Servicecategories::where('status','1')->get();
        return view('admin.sports-curriculums.add',compact('sportcategory'));
    }
    public function post(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'title' => 'required',
            'status' => 'required',
            'video' => 'required|mimes:mp4',
        ]);
        $input = $request->only('type','title', 'status');
        if ($request->type == "sports") {
            $input['category'] =$request->sport_category;
        }else{
            $input['category'] =$request->sporty_category;
        }
        if ($request->video) {
            $videoName = $request->video->store('/videos');
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
            $input['thumbnail'] = $thumbnail;
        }
        $insert = Sports_curriculums::create($input);
        if($insert) {
            return redirect()->route('sports-curriculum')->withSuccess("Added Successfully.");
        }else{
            return redirect()->route('sports-curriculum')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $data = Sports_curriculums::where('id',$id)->first();
        $sportcategory = Servicecategories::all();
        if($data) {
            return view('admin.sports-curriculums.update',compact('data','sportcategory'));
        }else{
            return redirect()->route('sports-curriculum')->withError("Not workout video Available.");
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
           'type' => 'required',
            'title' => 'required',
            'status' => 'required',
            'video' => 'mimes:mp4',
        ]);
        $input = $request->only('title', 'status');
        if ($request->type == "sports") {
            $input['category'] =$request->sport_category;
        }else{
            $input['category'] =$request->sporty_category;
        }
        if ($request->video) {
            $videoName = $request->video->store('/videos');
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
            $input['thumbnail'] = $thumbnail;
        }

        $insert = Sports_curriculums::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('sports-curriculum')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('sports-curriculum')->withError("Updation Failed.");
        }
    }
    public function delete($id)
    {
        $data = Sports_curriculums::find($id);
        if($data->delete()) {
            return redirect()->route('sports-curriculum')->withSuccess(" Deleted Successfully.");
        }else{
            return redirect()->route('sports-curriculum')->withError("Error! Please Try Again.");
        }
    }
    public function changeSportsurriculumStatus(Request $request)
    {
        $data = Sports_curriculums::find($request->id);
        $data->status = $request->status;
        $data->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
