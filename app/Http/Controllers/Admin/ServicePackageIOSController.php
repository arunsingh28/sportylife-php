<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicepackages;
use App\Models\Settings;
use Illuminate\Http\Request;

class ServicePackageIOSController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Servicepackages::where('package_type','ios')->get();
        return view('admin.service-packages-ios.index', compact('data'));
    }

    public function show($id)
    {
        $data = Servicepackages::where('id', $id)->first();
        $catedata = Servicepackages::select('id', 'title')->limit(3)->get();
        if ($data) {
            return view('admin.service-packages-ios.show', compact('data', 'catedata'));
        } else {
            return redirect()->route('service-packages-ios')->withError("Not Data Available.");
        }
    }

    public function edit($id)
    {
        $data = Servicepackages::where('id', $id)->first();
        $catedata = Servicepackages::select('id', 'title')->where('package_type','android')->where('addon','1')->get();
        if ($data) {
            return view('admin.service-packages-ios.edit', compact('data', 'catedata'));
        } else {
            return redirect()->route('service-packages-ios')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $input['title'] = $request->title;
        $input['description'] = array_values($request->description);
        $id = $request->only('id');
        // $insert = Servicepackages::update($id, $input);
        $insert = Servicepackages::where('id',$id)->update($input);
        if ($insert) {
            $message = 'Updated Successfully.';
            return redirect()->route('service-packages-ios')->withSuccess($message);
        } else {
            $message = 'Updating Failed.';
            return redirect()->route('service-packages-ios')->withError($message);
        }
    }
    


   
}
