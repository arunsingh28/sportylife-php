<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Str;

class HomeCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Categories::all();
        return view('admin.home-category.index', compact('data'));
    }

    public function edit($id)
    {
        $data = Categories::where('id', $id)->first();
        if ($data) {
            return view('admin.home-category.edit', compact('data'));
        } else {
            return redirect()->route('home-category')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
        $input = $request->only('title');
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/'. $imageName;
        }
        $insert = Categories::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('home-category')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('home-category')->withError("Updation Failed.");
        }
    }
    
    public function changeStatus(Request $request)
    {
        $data = Categories::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
