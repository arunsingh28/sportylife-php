<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Ingredients;
use App\Models\Nutrition_diet_frequencies;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Ingredients::all();
        return view('admin.ingredients.index', compact('data'));
    }

    public function add()
    {
        $catedata = Meal::select('id', 'title')->limit(3)->get();
        $frqdata = Nutrition_diet_frequencies::all();
        return view('admin.ingredients.create', compact('catedata','frqdata'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only( 'title', 'status');
        $id = $request->only('id');
        $insert = Ingredients::updateOrCreate($id, $input);
        if ($insert) {
            $message = $request->id ? 'Updated Successfully.' : 'Added Successfully.';
            return redirect()->route('ingredients')->withSuccess($message);
        } else {
            $message = $request->id ? 'Updating Failed.' : 'Adding Failed.';
            return redirect()->route('ingredients')->withError($message);
        }
    }

    public function edit($id)
    {
        $data = Ingredients::where('id', $id)->first();
        $catedata = Meal::select('id', 'title')->limit(3)->get();
        $frqdata = Nutrition_diet_frequencies::all();
        if ($data) {
            return view('admin.ingredients.edit', compact('data', 'catedata', 'frqdata'));
        } else {
            return redirect()->route('ingredients')->withError("Not Data Available.");
        }
    }

    public function delete($id)
    {
        $data = Ingredients::find($id);
        if ($data->delete()) {
            return redirect()->route('ingredients')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('ingredients')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Ingredients::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
