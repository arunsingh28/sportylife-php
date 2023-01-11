<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutrition_recipe_categories;
use Illuminate\Http\Request;

class NutriRecipeCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Nutrition_recipe_categories::orderBy("position","asc")->get();
        return view('admin.nutri-recipe-categories.index', compact('data'));
    }

    public function add()
    {
        $catedata = Nutrition_recipe_categories::select('id', 'title')->limit(3)->get();
        return view('admin.nutri-recipe-categories.create', compact('catedata'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'status' => 'required',
            'position' => 'required|numeric|regex:/^[0-9]+$/',
        ]);
        $input = $request->only('title', 'status','position');
        $input['slug'] = str_replace(' ','-',strtolower($request->title));
        if($request->hasFile('image')) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/' . $imageName;
        }
        $id = $request->only('id');
        $insert = Nutrition_recipe_categories::updateOrCreate($id, $input);
        if ($insert) {
            $message = $request->id ? 'Updated Successfully.' : 'Added Successfully.';
            return redirect()->route('nutri-recipe-categories')->withSuccess($message);
        } else {
            $message = $request->id ? 'Updating Failed.' : 'Adding Failed.';
            return redirect()->route('nutri-recipe-categories')->withError($message);
        }
    }

    public function edit($id)
    {
        $data = Nutrition_recipe_categories::where('id', $id)->first();
        $catedata = Nutrition_recipe_categories::select('id', 'title')->limit(3)->get();
        if ($data) {
            return view('admin.nutri-recipe-categories.edit', compact('data', 'catedata'));
        } else {
            return redirect()->route('nutri-recipe-categories')->withError("Not Data Available.");
        }
    }

    public function delete($id)
    {
        $data = Nutrition_recipe_categories::find($id);
        if ($data->delete()) {
            return redirect()->route('nutri-recipe-categories')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('nutri-recipe-categories')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Nutrition_recipe_categories::find($request->id);
        $data->status = $request->status;
        $data->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
}
