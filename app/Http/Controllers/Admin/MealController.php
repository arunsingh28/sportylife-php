<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_recipe_categories;
use App\Models\Nutrition_recipes;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Meal::with('frequencydata')->orderBy("created_at","desc")->get();
        return view('admin.meals.index', compact('data'));
    }

    public function getrecipeDetails(Request $request)
    {
        $data = Nutrition_recipes::with('recipe_categorydata')->where('id', $request->id)->where('status','1')->first();
        if (!empty($data)) {
            return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => $data]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        }
    } 

    public function add()
    {
        $catedata = Meal::select('id', 'title')->limit(3)->get();
        $frqdata = Nutrition_diet_frequencies::all();
        $allrecipes = Nutrition_recipes::with('recipe_categorydata')->where('status','1')->orderBy('title','asc')->get();
        return view('admin.meals.create', compact('catedata','frqdata','allrecipes'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'calorie' => 'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'protein' => 'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'carbs'=>'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'fats'=>'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'status' => 'required',
            'frequency_id' => 'required',
        ]);
        $input = $request->only( 'title', 'calorie','protein','carbs','fats', 'status', 'frequency_id','recipe_id');
        $id = $request->only('id');
        $insert = Meal::updateOrCreate($id, $input);
        if ($insert) {
            if ($request->id) {
                $updatedata = Meal::where("recipe_id",$request->recipe_id)->where("is_recipe","1")->first();
                if ($updatedata) {
                    $input1 = $request->only( 'title', 'calorie','protein','carbs','fats');
                    $data1 =  Nutrition_recipes::where("id",$request->recipe_id)->update($input1);
                }
            }

            $message = $request->id ? 'Updated Successfully.' : 'Added Successfully.';
            return redirect()->route('meals')->withSuccess($message);
        } else {
            $message = $request->id ? 'Updating Failed.' : 'Adding Failed.';
            return redirect()->route('meals')->withError($message);
        }
    }

    public function edit($id)
    {
        $data = Meal::where('id', $id)->first();
        $catedata = Meal::select('id', 'title')->limit(3)->get();
        $frqdata = Nutrition_diet_frequencies::all();
        $allrecipes = Nutrition_recipes::with('recipe_categorydata')->where('status','1')->orderBy('title','asc')->get();
        if ($data) {
            return view('admin.meals.edit', compact('data', 'catedata', 'frqdata','allrecipes'));
        } else {
            return redirect()->route('meals')->withError("Not Data Available.");
        }
    }

    public function delete($id)
    {
        $data = Meal::find($id);
        $finddata = Meal::where("id",$id)->where("is_recipe","1")->first();
        if ($data->delete()) {
            if ($finddata) {
                $data1 =  Nutrition_recipes::where("id",$finddata->recipe_id)->delete();
            }
            return redirect()->route('meals')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('meals')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Meal::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
