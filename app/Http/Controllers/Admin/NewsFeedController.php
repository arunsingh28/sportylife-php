<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\compressVideo;
use App\Models\News_feeds;
use FFMpeg;
use Illuminate\Http\Request;
use Str;

class NewsFeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = News_feeds::orderBy("created_at", "desc")->get();
        return view('admin.news-feed.index', compact('data'));
    }
    public function add()
    {
        return view('admin.news-feed.add');
    }
    
    public function post(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'type', 'status','description');
        $input['slug'] = Str::slug($request->title, '-');
        if ($request->type == "image") {
            $imageName = $request->uploadimage->store('/images');
            $input['uploads'] = 'uploads/' . $imageName;
        }
        if ($request->type == "video") {
            $videoName = $request->uploadvideo->store('/videos');
            $input['uploads'] = 'uploads/' . $videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid() . time() . '.png';
            $thumbnail = 'uploads/images/' . $imageTo;
            FFMpeg::fromDisk('videos')
                ->open($videoFrom[1])
                ->getFrameFromSeconds(1)
                ->export()
                ->toDisk('thumbnail')
                ->save($imageTo);

            $new = 'compressed' . $videoFrom[1];
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['uploads'] = "uploads/videos/" . $new;
            $input['thumbnail'] = $thumbnail;
        }
        $insert = News_feeds::create($input);
        if ($insert) {
            return redirect()->route('news-feed')->withSuccess("Added Successfully.");
        } else {
            return redirect()->route('news-feed')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $data = News_feeds::where('id', $id)->first();
        if ($data) {
            return view('admin.news-feed.edit', compact('data'));
        } else {
            return redirect()->route('news-feed')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'type', 'status', 'description');
        $input['slug'] = Str::slug($request->title, '-');
        if ($request->uploadimage && $request->type == "image") {
            $imageName = $request->uploadimage->store('/images');
            $input['uploads'] = 'uploads/' . $imageName;
            $input['thumbnail'] = null;
        }
        if ($request->uploadvideo && $request->type == "video") {
            $videoName = $request->uploadvideo->store('/videos');
            $input['uploads'] = 'uploads/' . $videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid() . time() . '.png';
            $thumbnail = 'uploads/images/' . $imageTo;
            FFMpeg::fromDisk('videos')
                ->open($videoFrom[1])
                ->getFrameFromSeconds(1)
                ->export()
                ->toDisk('thumbnail')
                ->save($imageTo);

            $new = 'compressed' . $videoFrom[1];
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['uploads'] = "uploads/videos/" . $new;

            $input['thumbnail'] = $thumbnail;
        }

        $insert = News_feeds::where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('news-feed')->withSuccess("Update Successfully.");
        } else {
            return redirect()->route('news-feed')->withError("Updation Failed.");
        }
    }
    public function delete($id)
    {
        $data = News_feeds::find($id);
        if ($data->delete()) {
            return redirect()->route('news-feed')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('news-feed')->withError("Error! Please Try Again.");
        }
    }
    public function changeStatus(Request $request)
    {
        $data = News_feeds::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    
}
