<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutrition_diet_frequencies;
use Illuminate\Http\Request;

class NutriDietFrequencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Nutrition_diet_frequencies::all();
        return view('admin.nutri-diet-frequency.index', compact('data'));
    }

    public function add()
    {
        $catedata = Nutrition_diet_frequencies::select('id', 'title')->limit(3)->get();
        return view('admin.nutri-diet-frequency.create', compact('catedata'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $input['slug'] = str_replace(' ','-',strtolower($request->title));
        $id = $request->only('id');
        $insert = Nutrition_diet_frequencies::updateOrCreate($id, $input);
        if ($insert) {
            $message = $request->id ? 'Updated Successfully.' : 'Added Successfully.';
            return redirect()->route('nutri-diet-frequency')->withSuccess($message);
        } else {
            $message = $request->id ? 'Updating Failed.' : 'Adding Failed.';
            return redirect()->route('nutri-diet-frequency')->withError($message);
        }
    }

    public function edit($id)
    {
        $data = Nutrition_diet_frequencies::where('id', $id)->first();
        $catedata = Nutrition_diet_frequencies::select('id', 'title')->limit(3)->get();
        if ($data) {
            return view('admin.nutri-diet-frequency.edit', compact('data', 'catedata'));
        } else {
            return redirect()->route('nutri-diet-frequency')->withError("Not Data Available.");
        }
    }

    public function delete($id)
    {
        $data = Nutrition_diet_frequencies::find($id);
        if ($data->delete()) {
            return redirect()->route('nutri-diet-frequency')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('nutri-diet-frequency')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Nutrition_diet_frequencies::find($request->id);
        $data->status = $request->status;
        $data->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
}
