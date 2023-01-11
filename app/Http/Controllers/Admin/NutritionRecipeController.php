<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;
use App\Models\Nutrition_recipe_categories;
use App\Models\Nutrition_recipes;
use App\Models\Ingredients;
use FFMpeg;
use Str;
use App\Jobs\compressVideo;

class NutritionRecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Nutrition_recipes::with('recipe_categorydata')->orderBy("created_at","desc")->get();
        return view('admin.nutritionRecipes',compact('data'));
    }
    public function add()
    {
        $meals=Ingredients::where('status','1')->orderBy("title",'asc')->get();
        $catedata = Nutrition_recipe_categories::where('status','1')->get();
        $recipes_meals = Meal::with('frequencydata')->where('status','1')->get();
        return view('admin.nutritionRecipeAdd',compact('catedata', 'meals','recipes_meals'));
    }
    
    public function getrecipeMeal(Request $request)
    {
        $data = Meal::with('frequencydata')->where('id', $request->id)->where('status','1')->first();
        if (!empty($data)) {
            return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => $data]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        }
    }
    public function post(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'calorie' => 'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'protein' => 'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'carbs'=>'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'fats'=>'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'preparation_time'=>'numeric|regex:/^-?[0-9]+(?:.[0-9]{1,2})?$/',
            'person_to_serve'=>'numeric|regex:/^-?[0-9]+(?:.[0-9]{1,2})?$/',
        ]);
        $input = $request->only('category_id', 'title', 'type','calorie','protein','carbs','fats','preparation','status','preparation_time','person_to_serve','recipes_meal_id','source_link');
        $input['ingredients'] = array_values($request->store);
        $input['slug'] = Str::slug($request->title, '-');
        if ($request->type == "image") {
            $imageName = $request->uploadimage->store('/images');
            $input['uploads'] = 'uploads/'. $imageName;
        }
        if ($request->type == "video") {
            $videoName = $request->uploadvideo->store('/videos');
            $input['uploads'] ='uploads/'.$videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid().time().'.png';
            $thumbnail = 'uploads/images/'.$imageTo;
            FFMpeg::fromDisk('videos')
            ->open($videoFrom[1])
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('thumbnail')
            ->save($imageTo);

            $new = 'compressed'.$videoFrom[1];
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['uploads'] = "uploads/videos/".$new;
            $input['thumbnail'] = $thumbnail;
        }
        $insert = Nutrition_recipes::create($input);
        if($insert) {
            $input1 = $request->only( 'title', 'calorie','protein','carbs','fats', 'status');
            $input1['recipe_id'] = $insert->id;
            $input1['is_recipe'] = "1";
            $insert1 = Meal::create($input1);
            return redirect()->route('nutrition-recipes')->withSuccess("Added Successfully.");
        }else{
            return redirect()->route('nutrition-recipes')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $meals=Ingredients::where('status','1')->orderBy("title",'asc')->get();
        $data = Nutrition_recipes::where('id',$id)->first();
        $recipes_meals = Meal::with('frequencydata')->where('status','1')->get();
        $catedata = Nutrition_recipe_categories::all();
        if($data) {
            return view('admin.nutritionRecipeUpdate',compact('data','catedata', 'meals','recipes_meals'));
        }else{
            return redirect()->route('nutrition-recipes')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
           'category_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'calorie' => 'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'protein' => 'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'carbs'=>'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'fats'=>'required|numeric|regex:/^-?[0-9]+(?:.[0-9]{1,3})?$/',
            'preparation_time'=>'numeric|regex:/^-?[0-9]+(?:.[0-9]{1,2})?$/',
            'person_to_serve'=>'numeric|regex:/^-?[0-9]+(?:.[0-9]{1,2})?$/',
            'status' => 'required',
        ]);
        $input = $request->only('category_id', 'title', 'type','calorie','protein','carbs','fats','preparation','status','preparation_time','person_to_serve','recipes_meal_id','source_link');
        $input['ingredients'] = array_values($request->store);
        $input['slug'] = Str::slug($request->title, '-');
        if ($request->uploadimage && $request->type == "image") {
            $imageName = $request->uploadimage->store('/images');
            $input['uploads'] = 'uploads/'. $imageName;
            $input['thumbnail'] = NULL;
        }
        if ($request->uploadvideo && $request->type == "video") {
            $videoName = $request->uploadvideo->store('/videos');
            $input['uploads'] ='uploads/'.$videoName;
            $videoFrom = explode('/', $videoName);
            $imageTo = uniqid().time().'.png';
            $thumbnail = 'uploads/images/'.$imageTo;
            FFMpeg::fromDisk('videos')
            ->open($videoFrom[1])
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('thumbnail')
            ->save($imageTo);

            $new = 'compressed'.$videoFrom[1];
            $response = compressVideo::dispatchSync($videoFrom[1]);
            $input['uploads'] = "uploads/videos/".$new;
            
            $input['thumbnail'] = $thumbnail;
        }

        $insert = Nutrition_recipes::where('id',$request->id)->update($input);
        if($insert) {
            $input1 = $request->only( 'title', 'calorie','protein','carbs','fats', 'status');
            $input1['recipe_id'] = $request->id;
            $input1['is_recipe'] = "1";
            $check = array('recipe_id'=> $request->id, 'is_recipe' => "1");
            $data1 =  Meal::updateOrCreate($check, $input1);
            
            return redirect()->route('nutrition-recipes')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('nutrition-recipes')->withError("Updation Failed.");
        }
    }
    public function delete($id)
    {
        $data = Nutrition_recipes::find($id);
        $finddata = Meal::where("recipe_id",$id)->where("is_recipe","1")->first();
        if($data->delete()) {
            if ($finddata) {
                $finddata->delete();
            }
            return redirect()->route('nutrition-recipes')->withSuccess("Deleted Successfully.");
        }else{
            return redirect()->route('nutrition-recipes')->withError("Error! Please Try Again.");
        }
    }
    public function changeStatus(Request $request)
    {
        $data = Nutrition_recipes::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

    //Nutrition recipe category
    public function category()
    {
        $workoutcats = Workoutcategories::all();
        return view('admin.workoutCategory',compact('workoutcats'));
    }
    public function categoryAdd()
    {
        return view('admin.workoutCategoryAdd');
    }
    public function categoryPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $insert = Workoutcategories::create($input);
        if($insert) {
            return redirect()->route('workout-category')->withSuccess("Category Added Successfully.");
        }else{
            return redirect()->route('workout-category')->withError("Not Added Successfully.");
        }
    }
    public function categoryEdit($id)
    {
        $workoutcat = Workoutcategories::where('id',$id)->first();
        if($workoutcat) {
            return view('admin.workoutCategoryUpdate',compact('workoutcat'));
        }else{
            return redirect()->route('workout-category')->withError("Data Not Available.");
        }
    }

    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $insert = Workoutcategories::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('workout-category')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('workout-category')->withError("Updation Failed.");
        }
    }
    public function categoryDelete($id)
    {
        $workoutcat = Workoutcategories::find($id);
        if($workoutcat->delete()) {
            return redirect()->route('workout-category')->withSuccess("Deleted Successfully.");
        }else{
            return redirect()->route('workout-category')->withError("Error! Please Try Again.");
        }
    }
    public function changeWorkoutCategoryStatus(Request $request)
    {
        $workoutcat = Workoutcategories::find($request->id);
        $workoutcat->status = $request->status;
        $workoutcat->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
