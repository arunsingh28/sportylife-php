<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sliders;
use Auth;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }
    public function index()
    {
        $sliders = Sliders::all();
        return view('admin.sliders',compact('sliders'));
    }
    public function add()
    {
       
        return view('admin.sliderAdd');
    }
    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'position' => 'required',
            'status' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg'
        ]);
        $input = $request->only('title', 'position', 'status','description','redirect_to');
        $imageName = $request->image->store('/images');
        $input['image'] = 'uploads/'. $imageName;
        $insert = Sliders::create($input);
        if($insert) {
            return redirect()->route('sliders')->withSuccess("Slider Added Successfully.");
        }else{
            return redirect()->route('sliders')->withError("Not Added Successfully.");
        }
    }

    public function edit($id)
    {
        $slider = Sliders::where('id',$id)->first();
        if($slider) {
            return view('admin.sliderUpdate',compact('slider'));
        }else{
            return redirect()->route('sliders')->withError("Not Slider Available.");
        }
    }
    
    public function view($id)
    {
        $slider = Sliders::where('id',$id)->first();
        if($slider) {
            return view('admin.sliderView',compact('slider'));
        }else{
            return redirect()->route('sliders')->withError("Not Slider Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'position' => 'required',
            'status' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg'
        ]);
        // dd($request->all());
        $input = $request->only('title', 'position', 'status','description','redirect_to');
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/'. $imageName;
        }
        $insert = Sliders::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('sliders')->withSuccess("Slider Update Successfully.");
        }else{
            return redirect()->route('sliders')->withError("Updation Failed.");
        }
    }

    public function delete($id)
    {
        $slider = Sliders::find($id);
        if($slider->delete()) {
            return redirect()->route('sliders')->withSuccess("Slider Deleted Successfully.");
        }else{
            return redirect()->route('sliders')->withError("Error! Please Try Again.");
        }
    }

    public function changeSliderStatus(Request $request)
    {
        $slider = Sliders::find($request->id);
        $slider->status = $request->status;
        $slider->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
