<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Roles;
use App\Models\Nutrition_diet_datas;
use App\Models\Nutrition_diet_frequencies;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use Hash;

class RoleBaseUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = User::with('roledata')->whereNotIn('role_id',['1','2'])->get();
        return view('admin.role-base-user.index', compact('data'));
    }
    public function add()
    {
        $roles = Roles::whereNotIn('id',['1','2'])->get();
        return view('admin.role-base-user.create', compact('roles'));
    }
    
    public function post(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'first_name' => 'required',
            'email' => 'required|email',
            // 'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'phone' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/',
            // 'phone' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone',
        ]);
        $exists_user = User::where('email',$request->email)->where('user_type',"subadmin")->first();
        if (!empty($exists_user)) {
            return redirect()->back()->withError("Email Already Exists!");
        }
        $input = $request->only('role_id', 'first_name', 'last_name', 'email', 'phone', 'status');
        $input['name'] = @$request->first_name . ' ' . @$request->last_name;
        $input['country_code'] = '+91';
        $input['user_type'] = 'subadmin';
        $input['password'] = Hash::make($request->password);

        $insert = User::create($input);
        if ($insert) {
            return redirect()->route('role-base-user')->withSuccess("Added Successfully.");
        } else {
            return redirect()->back()->withError("Failed.");
        }
    }
    public function edit($id)
    {
        $roles = Roles::whereNotIn('id', ['1', '2'])->get();
        $data = User::where('id', $id)->first();
        if ($data) {
            
            return view('admin.role-base-user.edit', compact('data', 'roles'));
        } else {
            return redirect()->route('role-base-user')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'role_id' => 'required',
            'password' => 'confirmed',
        ]);
        $input = $request->only('role_id', 'first_name', 'last_name', 'email', 'phone', 'status');
        if (!empty($request->first_name) || !empty($request->last_name)) {
            $input['name'] = @$request->first_name . ' ' . @$request->last_name;
        }
        if ($request->password) {
            $input['password'] = Hash::make($request->password);
        }
        $insert = User::where('id', $request->id)->update($input);
        if ($insert) {
            return redirect()->route('role-base-user')->withSuccess("Update Successfully.");
        } else {
            return redirect()->route('role-base-user')->withError("Failed.");
        }
    }
    public function delete($id)
    {
        $data = User::find($id);
        if ($data->delete()) {
            return redirect()->route('role-base-user')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('role-base-user')->withError("Failed.");
        }
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

}
