<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Sliders;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }
    public function index()
    {
        $data = Roles::whereNotIn('id',['1','2'])->get();
        return view('admin.roles.index', compact('data'));
    }
    public function add()
    {
        return view('admin.roles.add');
    }
    public function post(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
        ]);
        $input = $request->only('role_name');
        $input['type'] = "new";
        $insert = Roles::create($input);
        if ($insert) {
            return redirect()->route('roles')->withSuccess("Added Successfully.");
        } else {
            return redirect()->route('roles')->withError("Failed.");
        }
    }

    public function edit($id)
    {
        $data = Roles::where('id', $id)->first();
        if ($data) {
            return view('admin.roles.edit', compact('data'));
        } else {
            return redirect()->route('roles')->withError("No Data Available.");
        }
    }

   
    public function update(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
        ]);
        // dd($request->all());
        $input = $request->only('role_name');
        $insert = Roles::where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('roles')->withSuccess("Update Successfully.");
        } else {
            return redirect()->route('roles')->withError("Updation Failed.");
        }
    }

    public function delete($id)
    {
        $data = Roles::find($id);
        if ($data->delete()) {
            return redirect()->route('roles')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('roles')->withError("Error! Please Try Again.");
        }
    }
}
