<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Header_footers;
use Illuminate\Http\Request;

class HeaderFooterController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Header_footers::all();
        return view('admin.header-footer.index', compact('data'));
    }

    public function edit($id)
    {
        $data = Header_footers::where('id', $id)->first();
        if ($data) {
            return view('admin.header-footer.edit', compact('data'));
        } else {
            return redirect()->route('header-footer')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'mimes:jpg,png,PNG,jpeg',
        ]);
        $input = $request->only('title','value');
        // $input['title_slug'] = Str::slug($request->title, '-');
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['value'] = 'uploads/' . $imageName;
        }
        $insert = Header_footers::where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('header-footer')->withSuccess("Update Successfully.");
        } else {
            return redirect()->route('header-footer')->withError("Updation Failed.");
        }
    }

    public function changeheaderFooterStatus(Request $request)
    {
        $data = Header_footers::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success' => 'Status change successfully.']);
    }
}
