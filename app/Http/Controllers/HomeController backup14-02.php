<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Razorpay\Api\Api;
use Session;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Languages;
use App\Models\Categories;
use App\Models\Servicepackages;
use App\Models\Servicecategories;
use App\Models\User_carts;
use App\Models\Settings;
use App\Models\User_queries;
use App\Models\Faqcategories;
use App\Models\Faqdatas;
use App\Models\Sliders;
use App\Models\Notifications;
use App\Models\Workoutcategories;
use App\Models\Workoutvideos;
use App\Models\User_cart_items;
use App\Models\User_orders;
use App\Models\User_order_items;
use App\Models\Nutrition_categories;
use App\Models\Nutrition_recipe_categories;
use App\Models\Nutrition_recipes;
use App\Models\User_diaries;
use App\Models\Recipe_comments;
use App\Models\Recipe_likes;
use App\Models\Nutrition_blogs;
use App\Models\Nutrition_blog_likes;
use App\Models\Nutrition_blog_comments;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_diet_datas;
use App\Models\User_completed_meals;
use App\Models\Meal;
use App\Models\User_waterlevels;
use App\Models\Addon_persons;
use App\Models\User_search_keywords;
use App\Models\User_newsletters;
use App\Models\Live_videos;
use App\Models\Live_video_users;
use App\Models\Cities;
use App\Models\States;
use App\Models\Sports_curriculums;
use App\Models\Phonecodes;
use PDF;
use Hash;
use App\Helpers\ApiHelper;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $freepackagedata =  Servicepackages::where('status', '1')->where('id','4')->first();   
        $sliders =  Sliders::where('status','1')->orderBy('position','asc')->get();
        $mission = Settings::where('type','mission')->first();
        $vision = Settings::where('type','vision')->first();
        return view('index',compact('mission','vision','sliders','freepackagedata'));
    }
    public function commingsoon()
    {
        return view('web.comming-soon');
    }
    public function sessiondata(Request $request)
    {
        Session::put('userdata', $request->data);
    }
    public function sessiondatadestroy(Request $request)
    {
        Session::flush(); 
    }
    public function workoutVideos()
    {
        $workoutvideo =  Workoutcategories::with('workoutvideodata')->where('status','1')->get();
        return view('web.workout-videos',compact('workoutvideo'));
    }
    public function getVideos(Request $request)
    {
        $category_id=$request->category_id;
        // $currentdate_time = date("Y-m-d H:i:s");
        $currentdate_time = Carbon::now();
        if ($category_id == '6') {
            $workoutvideodata = [];
            $recordedvideodata =  Live_videos::where('status','1')->whereDate('end_date_time','<=',$currentdate_time)->select('id','category_id','title','thumbnail','video','status','start_date_time','end_date_time','created_at','updated_at')->get();
            foreach ($recordedvideodata as $key => $value) {
                $date = Carbon::parse($value->start_date_time)->addMinutes(30);
                if ($date < $currentdate_time) {
                    $workoutvideodata[] = $value;
                }
            }
        }else{
            $workoutvideodata =  Workoutvideos::where('category_id',$category_id)->get();
        }
        $str = "";
        foreach ($workoutvideodata as $key => $value) {
            $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><a href=".asset($value->video)." class='ply-btn-video'><img src=".asset($value->thumbnail)." class='img-fluid' alt=''></a></div>";
        }
        echo $str;
    }
    public function nutrition()
    {
        $user_data = Auth::user();
        $user_id = auth()->user()->id;
        $data =  Nutrition_categories::where('status', '1')->get();
        $todaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d'))->get();
        $yesterdaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d',strtotime("-1 day")))->get();
        $height_feet = auth()->user()->height_feet;
        $height_inch = auth()->user()->height_inch;
        $weight = auth()->user()->weight;
        $t_calorie = 0;
        $t_protein = 0;
        $t_carbs = 0;
        $t_fats = 0;
        $y_calorie = 0;
        $y_protein = 0;
        $y_carbs = 0;
        $y_fats = 0;
        $frq_id = [];
        foreach ($todaymealsdata as $key => $value) {
            $frq_id[] = $value->category_id;
            if ($value->meal_id != NULL) {
                $mealdetail =  Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                if (!empty($mealdetail)) {
                    $t_calorie = $t_calorie +  $mealdetail->calorie;
                    $t_protein = $t_protein + $mealdetail->protein;
                    $t_carbs = $t_carbs + $mealdetail->carbs;
                    $t_fats = $t_fats + $mealdetail->fats;
                }
            } 
        }
        $uni_cat = array_unique($frq_id);
        $usermealdata =  Nutrition_diet_datas::where('user_id', $user_id)->first();
        if (!empty($usermealdata->diet)) {
            foreach ($usermealdata->diet as $key1 => $value1) {
                if (in_array($value1['frequency_id'], $uni_cat)) {
                    $mealdetail =  Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                    $t_calorie = $t_calorie +  ($mealdetail->calorie * $value1['quantity']);
                    $t_protein = $t_protein + ($mealdetail->protein * $value1['quantity']);
                    $t_carbs = $t_carbs + ($mealdetail->carbs * $value1['quantity']);
                    $t_fats = $t_fats + ($mealdetail->fats * $value1['quantity']);
                }
            }
        }
        $y_frq_id = [];
        foreach ($yesterdaymealsdata as $key => $value) {
            $y_frq_id[] = $value->category_id;
            if ($value->meal_id != NULL) {
                $mealdetail =  Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                if (!empty($mealdetail)) {
                    $y_calorie = $y_calorie +  $mealdetail->calorie ;
                    $y_protein = $y_protein + $mealdetail->protein ;
                    $y_carbs = $y_carbs + $mealdetail->carbs ;
                    $y_fats = $y_fats + $mealdetail->fats ;
                }
            } 
        }
        $y_uni_cat = array_unique($y_frq_id);
        if (!empty($usermealdata->diet)) {
            foreach ($usermealdata->diet as $key1 => $value1) {
                if (in_array($value1['frequency_id'], $y_uni_cat)) {
                    $mealdetail =  Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                    $y_calorie = $y_calorie +  ($mealdetail->calorie * $value1['quantity']);
                    $y_protein = $y_protein + ($mealdetail->protein * $value1['quantity']);
                    $y_carbs = $y_carbs + ($mealdetail->carbs * $value1['quantity']);
                    $y_fats = $y_fats + ($mealdetail->fats * $value1['quantity']);
                }
            }
        }
        $t_waterlevel = 0;
        $y_waterlevel = 0;
        $todaywaterleveldata = User_waterlevels::where('user_id',$user_id)->where('date',date("Y-m-d"))->first();
        if (!empty($todaywaterleveldata)) {
            $today_waterlevel = 300 - floor($todaywaterleveldata->water_level * 18.75);
            $t_waterlevel = $todaywaterleveldata->water_level * 250 / 1000;
        }else{
            $today_waterlevel = "300";
            $t_waterlevel = "0";
        }
        $yesterday_waterleveldata = User_waterlevels::where('user_id',$user_id)->where('date',date('Y-m-d',strtotime("-1 day")))->first();
        if (!empty($yesterday_waterleveldata)) {
            $yesterday_waterlevel = 300 - floor($yesterday_waterleveldata->water_level * 18.75);
            $y_waterlevel = $yesterday_waterleveldata->water_level * 250 / 1000; 
        }else{
            $yesterday_waterlevel = "300";
            $y_waterlevel = "0"; 
        }
        $nutrition_details = array('today'=> array('calorie' => $t_calorie,'protein' => $t_protein,'carbs' => $t_carbs,'fats' => $t_fats,'height_feet' => $height_feet,'height_inch' => $height_inch,'weight' => $weight, ), 'yesterday'=> array('calorie' => $y_calorie,'protein' => $y_protein,'carbs' => $y_carbs,'fats' => $y_fats,'height_feet' => $height_feet,'height_inch' => $height_inch,'weight' => $weight, ));
        return view('web.nutritions.nutrition',compact('nutrition_details','user_data','today_waterlevel','yesterday_waterlevel','t_waterlevel','y_waterlevel'));
    }
    public function userWaterLevel($type)
    {
        $user_id = auth()->user()->id;
        $currentdate = date('Y-m-d');
        $data =  User_waterlevels::where('user_id', $user_id)->where('date',$currentdate)->first();
        if (!empty($data)) {
            if ($type == "add") {
                if ($data->water_level < "16") {
                    $water_level = $data->water_level + 1;
                }else{
                    $water_level = $data->water_level;
                }
            }else{
                if ($data->water_level < "1") {
                    $water_level = $data->water_level;
                }else{
                    $water_level = $data->water_level - 1;
                }
            } 
            $data->update(['water_level'=>$water_level]);
        }else{
            $input['user_id'] = $user_id;
            $input['date'] = $currentdate;
            $input['water_level'] = '1';
            $data =  User_waterlevels::create($input);
        }
        // $check = array('user_id'=> $user_id, 'date' => $currentdate );
        // if ($type == "add") {
        //     $input['water_level'] = $request->water_level;
        // }
        // $data =  User_waterlevels::updateOrCreate($check, $input);
        if ($data) {
            return redirect(route('nutrition'))->withSuccess("Update Successfully");
        }
        return redirect()->back()->withError("Updatation Failed!");
    }
    public function recipes() 
    {
        $data =  Nutrition_recipe_categories::with('nutrition_recipedata')->where('status','1')->get();
        return view('web.nutritions.recipes',compact('data'));
    }
    public function allRecipes($category) 
    {
        $categorydata =  Nutrition_recipe_categories::where('slug',$category)->first();
        if(!empty($categorydata)){
            $recipedata =  Nutrition_recipes::where('category_id',$categorydata->id)->where('status','1')->orderBy('created_at','desc')->get();
            return view('web.nutritions.all-recipes',compact('categorydata','recipedata'));
        }
        return redirect()->back()->withError("No data Found!");
    }
    public function recipeDetails($slug) 
    {
        $recipedata =  Nutrition_recipes::where('slug',$slug)->first();
        if (!empty($recipedata)) {
             $shareRecipe = \Share::page(
                url('recipe-details', ['slug' => $slug]),
                $recipedata->title,
            )->facebook()->twitter()->linkedin()->whatsapp();
            $viewcount = $recipedata->view_count + 1;
            $updateviewcount =  Nutrition_recipes::where('id', $recipedata->id)->update(['view_count' => $viewcount]);
            $recipedata =  Nutrition_recipes::where('id',$recipedata->id)->first();
            $likedata =  User_diaries::where('recipe_id',$recipedata->id)->where('user_id',auth()->user()->id)->first();
            if (!empty($likedata)) {
                $recipedata->is_like = 1;
            }else{
                $recipedata->is_like = 0;
            }
            $commentlist =  Recipe_comments::with('userdata')->where('recipe_id', $recipedata->id)->orderBy('id','desc')->take(2)->get();
            foreach ($commentlist as $key => $value) {
                $date = Carbon::parse($value->created_at);
                $now = Carbon::now();
                $value->timediff = $date->diff($now)->format('%h h');
            }
            return view('web.nutritions.recipe-details',compact('recipedata','shareRecipe','commentlist'));
        }
        return redirect()->back()->withError("No data Found!");
    }
    public function recipeLike(Request $request)
    {
        $data =  Nutrition_recipes::where('id',$request->recipe_id)->first();
        if (!empty($data)) {
            $likedata =  User_diaries::where('recipe_id',$request->recipe_id)->where('user_id',auth()->user()->id)->first();
            if (empty($likedata)) {
                $input = $request->only('recipe_id');
                $input['user_id'] = auth()->user()->id;
                $input['status'] = '1';
                $data1 =  User_diaries::create($input);
                $likecount = $data->like_count + 1;
                $updatelikecount =  Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                if (!empty($data1)) {
                    return response()->json(['statusCode' => 200, 'message' => 'Added into Diary Successfully.','data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
            }else{
                $likedata->delete();
                $likecount = $data->like_count - 1;
                $data1 =  Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                return response()->json(['statusCode' => 300, 'message' => ' Recipe Removed From Diary.','data' => $likedata]);
            }
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Found.']);
        }
    }
    public function recipeShare(Request $request)
    {
        $data =  Nutrition_recipes::where('id',$request->recipe_id)->first();
        if (!empty($data)) {
            $count = $data->share_count + 1;
            $data1 =  Nutrition_recipes::where('id',$request->recipe_id)->update(['share_count'=>$count]);
            if (!empty($data1)) {
                return response()->json(['statusCode' => 200, 'message' => 'Recipe Shared.','data' => $data1]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Found.']);
        }
    }
    public function addrecipeComment(Request $request)
    {
        $input = $request->only('recipe_id','message');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = '1';
        $data =  Recipe_comments::create($input);
        if (!empty($data)) {
            $data =  Recipe_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
            return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.','data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
    }
    public function nutritionBlogs() 
    {
        $blogs =  Nutrition_blogs::where('status','1')->get();
        foreach ($blogs as $key => $value) {
            $likedata =  Nutrition_blog_likes::where('blog_id',$value->id)->where('user_id',auth()->user()->id)->first();
            if (!empty($likedata)) {
                $value->is_like = 1;
            }else{
                $value->is_like = 0;
            }
        }
        return view('web.nutritions.nutrition-blogs',compact('blogs'));
    }
    public function nutritionBlogDetails($slug) 
    {
        $blogdetail =  Nutrition_blogs::where('slug',$slug)->first();
        if (!empty($blogdetail)) {
            $shareBlog = \Share::page(
                url('nutritionblog-details', ['slug' => $slug]),
                $blogdetail->title,
            )->facebook()->twitter()->linkedin()->whatsapp();
                // ->telegram()
                // ->reddit();
            $view_count = $blogdetail->view_count + 1;
            $blogdetail->update(['view_count'=>$view_count]);
            $likedata =  Nutrition_blog_likes::where('blog_id',$blogdetail->id)->where('user_id',auth()->user()->id)->first();
            if (!empty($likedata)) {
                $blogdetail->is_like = 1;
            }else{
                $blogdetail->is_like = 0;
            }
            $commentlist =  Nutrition_blog_comments::with('userdata')->where('blog_id', $blogdetail->id)->orderBy('id','desc')->take(2)->get();
            foreach ($commentlist as $key => $value) {
                $date = Carbon::parse($value->created_at);
                $now = Carbon::now();
                $value->timediff = $date->diff($now)->format('%h h');
            }
            // print_r($commentlist);exit;
            return view('web.nutritions.nutritionblog-details',compact('blogdetail','commentlist','shareBlog'));
        }
        return redirect()->back()->withError('No Data Found!');
    }
    public function blogLike(Request $request)
    {
        $data =  Nutrition_blogs::where('id',$request->blog_id)->first();
        if (!empty($data)) {
            $likedata =  Nutrition_blog_likes::where('blog_id',$request->blog_id)->where('user_id',auth()->user()->id)->first();
            if (empty($likedata)) {
                $input = $request->only('blog_id');
                $input['user_id'] = auth()->user()->id;
                $data1 =  Nutrition_blog_likes::create($input);
                if (!empty($data1)) {
                    $likecount = $data->like_count + 1;
                    $data->update(['like_count'=>$likecount]);
                    return response()->json(['statusCode' => 200, 'message' => 'Liked.','data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
            }else{
                $likedata->delete();
                $likecount = $data->like_count - 1;
                $data->update(['like_count'=>$likecount]);
                return response()->json(['statusCode' => 300, 'message' => 'Removed From Liked.','data' => $likedata]);
            }
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Nutrition blog Not Found.']);
        }
    }
    public function blogShare(Request $request)
    {
        $data =  Nutrition_blogs::where('id',$request->blog_id)->first();
        if (!empty($data)) {
            $count = $data->share_count + 1;
            $data1 =  Nutrition_blogs::where('id',$request->blog_id)->update(['share_count'=>$count]);
            if (!empty($data1)) {
                return response()->json(['statusCode' => 200, 'message' => ' Nutrition Blog Shared.','data' => $data1]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Nutrition Blog Not Found.']);
        }
    }
    public function addblogComment(Request $request)
    {
        $input = $request->only('blog_id','message');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = '1';
        $data =  Nutrition_blog_comments::create($input);
        if (!empty($data)) {
            // $data =  Nutrition_blog_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
            return response()->json(['statusCode' => 200, 'message' => 'Comment Added Successfully.','data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
    }
    public function diary() 
    {
        $user = Auth::user();
        $date = Carbon::parse($user->dob);
        $now = Carbon::now();
        $user->age = $date->diff($now)->format('%y years');
        $recipecate =  Nutrition_recipe_categories::where('status','1')->get();
        $addonmealcount = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('meal_id','!=',NULL)->count();
        $frqudata =  Nutrition_diet_frequencies::where('status','1')->get();
        if (!empty($frqudata[0])) {
            foreach ($frqudata as $key => $value) {
                $is_mealcompletedata = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('category_id',$value->id)->where('meal_id',NULL)->first();
                if (!empty($is_mealcompletedata)) {
                    $value->is_complete = "1";
                }else{
                    $value->is_complete = "0";
                }
            } 
        }
        return view('web.nutritions.diary',compact('user','recipecate','frqudata','addonmealcount'));
    }
    public function getMealsbyFrequency(Request $request)
    {
        $frequency_id=$request->frequency_id;
        $data =  Meal::where('frequency_id',$request->frequency_id)->where('status','1')->get();
        $str = '<div class="diet_chart Completed" style="margin-top: 0px !important;">    <ul>';
        foreach ($data as $key => $value) {
            $str .= '        <li>            <a href="#!">                  <img src="'.asset("web/assets/img/right-arrow.png").'">                 <span>'.$value->title.' </span>            </a>              <label class="checkbox-container" style="margin-top: 5px !important;">                 <input type="checkbox" name="meal_data[0][meal_id][]" value='.$value->id.'>                <span class="checkmark"></span>            </label>         </li>    ';
        }
        $str .= '</ul></div>';
        echo $str;
    }
    public function mealsComplete(Request $request) 
    {
        if (empty($request->meal_data)) {
            return redirect()->back()->withError('Please select Category!');
        }
        $request->validate([
            'type' => 'required',
        ]);
        $currentdate = date('Y-m-d');
        $user_id = auth()->user()->id;
        if ($request->type == "addon") {
            $data =  User_completed_meals::where('user_id', $user_id)->where('date',$currentdate)->where('meal_id','!=',NULL)->delete();
            $meal_data = $request->meal_data;
            foreach ($meal_data as $key => $value) {
                $input['user_id'] = $user_id;
                $input['date'] = $currentdate;
                $input['category_id'] = $value['category_id'];
                if (!empty($value['meal_id'])) {
                    foreach ($value['meal_id'] as $key1 => $value1) {
                        $input['meal_id'] = $value1;
                        $data1 =  User_completed_meals::create($input);
                    }
                }else{
                    $data1 =  User_completed_meals::create($input);
                }
            }
        }else{
            $data =  User_completed_meals::where('user_id', $user_id)->where('date',$currentdate)->where('meal_id', NULL)->delete();
            $meal_data = $request->meal_data;
            foreach ($meal_data as $key => $value) {
                $input['user_id'] = $user_id;
                $input['date'] = $currentdate;
                $input['category_id'] = $value['category_id'];
                $input['meal_id'] = NULL;
                $data1 =  User_completed_meals::create($input);
            }
        }
        if ($data1) {
            return redirect(route('diary'))->withSuccess('Data Update Successfully.');
        }
        return redirect()->back()->withError('Updatation Failed!');
    }
    public function dietChart() 
    {
        $user = Auth::user();
        $data =  Nutrition_diet_datas::where('user_id', '=', $user->id)->get();
        $frqudata =  Nutrition_diet_frequencies::all();
        $mealdata =  Meal::all();
        $frqudata_arr = [];
        $mealdata_arr = [];
        foreach ($frqudata as $key => $value) {
            $frqudata_arr[$value->id] = $value->title;
        }
        foreach ($mealdata as $key => $value) {
            $mealdata_arr[$value->id] = $value->title;
        }
        foreach ($data as $key => $value) {
            $customarr = [];
            foreach ($value['diet'] as $key1 => $value1) {
                $customarr[$value1['frequency_id']][] = $value1;  
            }
            $customarr1 = [];
            foreach ($customarr as $key4 => $value4) {
                $customarr1[ $key4]['frequency_id'] = $value4[0]['frequency_id']; 
                $customarr1[ $key4]['frequency_name'] = $frqudata_arr[$value4[0]['frequency_id']]; 
                $customarr2 = [];
            foreach ($value4 as $key2 => $value2) {
                    $customarr2[$key2]['meal'] =$value2['meal']; 
                    $customarr2[$key2]['quantity'] = $value2['quantity']; 
                    $customarr2[$key2]['meal_name'] =$mealdata_arr[$value2['meal']]; 
            }
                $customarr1[$key4]['meal'] =   $customarr2;
        }
            $customarr1 = array_values($customarr1);
        }
        if (!empty($data[0])) {
            $data1 = [
                'title' => $user->name ?? 'Sportylife',
                'date' => date('m/d/Y'),
                'customarr1' => $customarr1
            ];
            $my_pdf_name = 'uploads/dietchart' . $user->id . '.pdf';
            $my_pdf_path = 'public/'.$my_pdf_name;
            $pdf = PDF::loadView('dietPDF', $data1)->save($my_pdf_path);
            // $user = Auth::user();
            $user->dietchart_pdf = $my_pdf_name;
            $user->save();
            $pdfurl = asset($user->dietchart_pdf);
            $note = array('bowl' => '100g','cup' => '100ml','glass' => '200ml','tbsp' => '15g','tsp' => '5g');
            return view('web.nutritions.diet-chart',compact('note','customarr1','pdfurl'));
        }
        return redirect()->back()->withError('No Data Found!');
    }
    public function frc() 
    {
        $user = Auth::user();
        // $height_cm = (($user->height_feet * 12) + $user->height_inch) * 2.54;
        // $height_mtr = $height_cm / 100;
        // $user->ibw = number_format(($height_cm - 100),2); // ibw = height(cm) - 100
        if ($user->height_type == "Inch" || $user->height_type == "Feet") {
            $height_cm = (($user->height_feet * 12) + $user->height_inch) * 2.54;
        }else{
            $height_cm = $user->height_feet + ($user->height_inch / 10);
        }

        if($user->gender == "female"){
            $user->ibw = number_format(($height_cm - 105),2); // ibw = height(cm) - 105
        }else{
            $user->ibw = number_format(($height_cm - 100),2); // ibw = height(cm) - 100
            // print_r($height_cm - 100);exit;
        }

        $height_mtr = $height_cm / 100;
        if ($user->weight_type == "Kilogram" || $user->weight_type == "kgs") {
            $kgweight = $user->weight;
        }else{
            $kgweight = $user->weight / 2.205;
        }
        $user->bmi = number_format(($kgweight/($height_mtr*$height_mtr)),2); // BMI = Weight(kg) /height (m)2
        // $user->bmi = number_format(($user->weight/($height_mtr*$height_mtr)),2); // BMI = Weight(kg) /height (m)2
        $estimator = $user->bmi;
        // if ($estimator < 18.5) {
        //     $user->frc_category = 'Underweight';
        //     $user->frc_color = 'blue'; //dark blue
        //     $user->bmi_range = 'Below 18.5'; //dark blue
        // }else
        if ($estimator >= 18.5 && $estimator <= 22.4) {
            $user->frc_category = 'Normal';
            $user->frc_color = 'green'; //green
            $user->bmi_range = '18.5 - 24.9'; //green
        }elseif ($estimator >= 22.5 && $estimator <= 29.99) {
            $user->frc_category = 'Overweight';
            $user->frc_color = 'yellow'; //yellow
            $user->bmi_range = '25.0 - 29.9'; //yellow
        }elseif ($estimator >= 30 && $estimator <= 34.99) {
            $user->frc_category = 'Obese 1';
            $user->frc_color = 'orange'; //orange
            $user->bmi_range = '30.0 - 34.9'; //orange
        }elseif ($estimator >= 35 && $estimator <= 39.99) {
            $user->frc_category = 'Obese 2 ';
            $user->frc_color = 'pink'; //pink
            $user->bmi_range = '35.0 - 39.9'; //pink
        }elseif ($estimator >= 40) {
            $user->frc_category = 'Obese 3';
            $user->frc_color = 'red'; //red
            $user->bmi_range = 'Above 40'; //red
        }
        // else{
        //     $user->frc_category = 'Underweight';
        //     $user->frc_color = 'blue'; //dark blue
        //     $user->bmi_range = 'Below 18.5'; //dark blue
        // }
        $date = Carbon::parse($user->dob);
        $now = Carbon::now();
        $user->age = $date->diff($now)->format('%y years');
        return view('web.frc',compact('user'));
    }
    public function settings() 
    {
        $privacy_policy = Settings::where('type','privacy_policy_content')->first();
        return view('web.settings',compact('privacy_policy'));
    }
    public function contactUs() 
    {
        return view('web.contact-us');
    }
    public function contactUsPost(Request $request) 
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ]);
        $input = $request->only('subject', 'description');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = 'pending';
        $data =  User_queries::create($input);
        if ($data) {
            $data =  User_queries::with('userdata')->where('id',$data->id)->first();
            return redirect(route('web.contact-us'))->withSuccess('Query Submit Successfully.');
        }
        return redirect()->back()->withError('Submission Failed!');
    }
    public function faq() 
    {
        $data =  Faqcategories::with('faqdata')->where('status','1')->get();
        return view('web.faq',compact('data'));
    }
    public function inviteFriends() 
    {
        return view('web.invite-friends');
    }
    public function inviteHistory() 
    {
        $data =  User::where('refer_by',auth()->user()->referral_code)->get();
        return view('web.invite-history',compact('data'));
    }
    public function myDiary() 
    {
        $user_id = auth()->user()->id;
        $data =  User_diaries::with('recipedata', 'userdata')->where('user_id', $user_id)->get();
        return view('web.my-diary',compact('data'));
    }
    public function privacyPolicy() 
    { 
        $data =  Settings::where('type',"privacy_policy_content")->first();
        return view('web.privacy-policy',compact('data'));
    }
    public function termsConditions() 
    {
        $data =  Settings::where('type',"terms_conditions_content")->first();
        return view('web.terms-conditions',compact('data'));
    }
    public function profile() 
    {
        $user = Auth::user();
        $user->profile_status = '50';
        if ($user->height_feet) {
            $user->profile_status = $user->profile_status + 10;
        }
        if ($user->weight) {
            $user->profile_status = $user->profile_status + 10;
        }
        if ($user->city) {
            $user->profile_status = $user->profile_status + 10;
        }
        if ($user->state) {
            $user->profile_status = $user->profile_status + 10;
        }
        if ($user->image) {
            $user->profile_status = $user->profile_status + 10;
        }
        $user->sport_name = "Football";
        $user->sport_image = "sports/footbal.png";
        // $user->active_plan = "Basic";
        $date = Carbon::parse($user->dob);
        $now = Carbon::now();
        $user->age = $date->diff($now)->format('%y');
        // $user->age = Carbon::parse($user->dob)->age;

        $getpackage_data = $this->getUserPackage();
        // print_r(json_encode($getpackage_data[0]['package'][0]['package_data']['title']));exit;
        if(!empty($getpackage_data[0])){
            $user->active_plan = $getpackage_data[0]['package'][0]['package_data']['title'] ;
        }elseif($user->is_active_freetrial == '1'){
            $user->active_plan = "Free Trial";
        }else{
            $user->active_plan = "No Plan Active";
        }
        return view('web.profile',compact('user'));
    }
    
    public function profileEdit($type) 
    {
        $user = Auth::user();
        $languages = Languages::where('status','1')->get();
        $state_data =  States::select('id','name')->orderBy('name',"asc")->get();
        $city_data =  Cities::select('id','name')->orderBy('name',"asc")->get();
        $phonecode_data =  Phonecodes::select('id','phone_code','country_name')->orderBy('country_name',"asc")->get();
        return view('web.profile-edit',compact('user','languages','state_data','city_data','phonecode_data','type'));
    }
    public function profileEditPost(Request $request) 
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'language_id' => 'required',
            'city' => 'nullable',
            'state' => 'nullable',
            'weight' => 'nullable',
            'height_feet' => 'nullable',
            'height_inch' => 'nullable',
            'image' => 'nullable',
        ]);
        $input = $request->only('first_name', 'last_name',  'gender','country_code', 'language_id','city','state','weight','weight_type','height_type','height_feet','height_inch','school_name','school_address');
        $input['name'] = @$request->first_name.' '.@$request->last_name;
        $input['dob'] = date("Y-m-d",strtotime($request->dob));
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/'. $imageName;
        }
        $user =  User::where('id', auth()->user()->id)->update($input);
        $page_type = $request->page_type;
        if ($user) {
            if ($page_type == "frc") {
                return redirect(route('frc'))->withSuccess('Update Successfully.');
            }else{
                return redirect(route('profile'))->withSuccess('Update Successfully.');
            }
        }
        return redirect()->back()->withError('Updatation Failed!');
    }
    public function notifications() 
    {
        $today =  Notifications::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->get();
        $previous =  Notifications::where('user_id',auth()->user()->id)->whereDate('created_at','<',date('Y-m-d'))->get();
        foreach ($today as $key => $value) {
            $date = Carbon::parse($value->created_at);
            $now = Carbon::now();
            $value->timediff = $date->diff($now)->format('%d days, %h hours');
        }
        foreach ($previous as $key1 => $value1) {
            $date = Carbon::parse($value1->created_at);
            $now = Carbon::now();
            $value1->timediff = $date->diff($now)->format('%d days, %h hours');
            // dd($value1->timediff);
        }
        // dd($today->count());
        // dd($previous->count());
        return view('web.notifications',compact('today', 'previous'));
    }
    
    public function search() 
    {
        $user_id = auth()->user()->id;
        $recent_search = User_search_keywords::where('user_id',$user_id)->get();
        $favourite_data =  Recipe_likes::with('recipedata')->where('user_id', $user_id)->get();
        return view('web.search',compact('recent_search','favourite_data'));
    }
    
    public function clearSerchHistory()
    {
        $data =  User_search_keywords::where('user_id',auth()->user()->id)->get();
        if (!empty($data[0])) {
            $data =  User_search_keywords::where('user_id',auth()->user()->id)->delete();
            return redirect(route('search'));
        }
        return redirect(route('search'))->withError("No Search History Found!");
    }
    public function getSearchData(Request $request)
    {
        $keyword  = $request->keyword;
        $user_id = auth()->user()->id;
        if (!empty($keyword)) {
            $check = array('user_id'=> $user_id, 'title' => $keyword );
            $input['user_id'] = $user_id;
            $input['title'] = $keyword;
            $data =  User_search_keywords::updateOrCreate($check, $input);
        }
        $recipe_data =  Nutrition_recipes::where('title','LIKE','%'.$keyword.'%')->where('status','1')->select('id','title','slug','type','uploads','thumbnail')->get();
        $blog_data =  Nutrition_blogs::where('title','LIKE','%'.$keyword.'%')->where('status','1')->select('id','title','slug','image')->get();
        foreach ($recipe_data as $key => $value) {
            $value->search_type = "recipe";
            if ($value->type == "video") {
                $value->image = $value->thumbnail;
            }else{
                $value->image = $value->uploads;
            }
        }
        foreach ($blog_data as $key1 => $value1) {
            $value1->search_type = "blog";
        }
        $recent_search = User_search_keywords::where('user_id',$user_id)->get();
        $favourite_data =  Recipe_likes::with('recipedata')->where('user_id', $user_id)->get();
        if (!empty($recipe_data[0]) || !empty($blog_data[0])) {
            $data = array_merge($recipe_data->toArray(), $blog_data->toArray());
            $str = "";
            foreach ($data as $key => $value) {
                if ($value['search_type'] == "recipe") {
                    $url = url('recipe-details/'.$value['slug']);
                }else{
                    $url = url('nutritionblog-details/'.$value['slug']);
                }
                $str .= "<div class='col-md-12'><div class='notification_Inner'>   <div class='readable_allowed'>      <div class='row'>         <div class='col-md-12'>             <div class='row'>               <div class='col-md-3'>                   <a href='".$url."'>                  <img style='height: 59px !important;border-radius: 10px;object-fit: cover;width: -webkit-fill-available;' src='".asset($value['image'])."'>        </a>      </div>      <div class='col-md-7'>        <a href='".$url."'><h5> ".\Str::limit($value['title'], 100, '...')."</h5></a>     </div>     <div class='col-md-2'>        <a href='".$url."'><span style='font-size: 12px;color: #212121;border-radius: 10px;background: yellow;padding: 0px 7px 0px 7px;font-weight: 700;float: right;'>".ucfirst($value['search_type'])."</span></a>                    </div>                 </div>              </div>           </div>        </div>     </div>  </div>";
            }
            echo $str;
            // return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('search_data'=>$data, 'recent_search'=> $recent_search, 'favourite_data'=> $favourite_data)]);
        }
        // $data = [];
        // return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('search_data'=>$data, 'recent_search'=> $recent_search, 'favourite_data'=> $favourite_data)]);
    }
    public function freeTrial() 
    {
        $user = Auth::user();
        $packagedata =  Servicepackages::where('status', '1')->where('id','4')->first();   
        if (!empty($packagedata)) {
            return view('web.services.free-trial',compact('packagedata','user'));
        }
        return redirect(route('services'))->withError("Data Not Found!");
    }
    public function startFreeTrial() 
    {
        $user =  auth()->user();
        if ($user->is_complete_freetrial == "1") {
            return redirect()->back()->withError("Already Used!");
        }
        if ($user->is_active_freetrial == "1") {
            return redirect()->back()->withError("Already Activeted!");
        }
        $currentdate = date("Y-m-d H:i:s");
        $freetrial_duration = Carbon::createFromFormat('Y-m-d H:i:s', $currentdate)->addDays(7);
        $user->update(['is_active_freetrial'=>'1', 'freetrial_duration'=>$freetrial_duration]);
        if (!empty($user)) {
            return redirect(route('free-trial'))->withSuccess("Free Trial Plan Active Successfully");
        }
        return redirect()->back()->withError("Activation Failed!");
    }
    public function aboutUs() 
    {
        return view('web.about-us');
    }
    public function services() 
    {
        $freepackagedata =  Servicepackages::where('status', '1')->where('id','4')->first();   
        $category =  Servicecategories::where('status', '1')->get();
        $packagedata =  Servicepackages::where('status', '1')->where('id','!=','4')->where('parent_id',NULL)->get();
        return view('web.services.services',compact('category','packagedata','freepackagedata'));
    }
    public function serviceDetails($slug) 
    {
        if(auth()->user()->is_active_freetrial != "1" && auth()->user()->is_complete_freetrial != "1"){
            return redirect()->back()->withError("Please Activate Free Trial!");
        }
        $packagedata =  Servicepackages::where('status', '1')->where('slug',$slug)->first();
        if (!empty($packagedata)) {
            $category =  Servicecategories::where('status', '1')->get();
            return view('web.services.service-details',compact('category','packagedata',));
        }
        return redirect(route('services'))->withError("Data Not Found!");
    }

    public function updateOrder(Request $request){
        // $arr = explode(',',$request->input('ids'));
        $arr = $request->input('ids');
        // if($request->has('ids')){
            foreach($arr as $sortOrder => $id){
                $cartdata =  User_cart_items::where('cart_id', $request->item_id)->where('category_id', $id)->first();
                $cartdata->category_year_srno = $sortOrder + 1; 
                $cartdata->save();
            }
            return ['success'=>true,'message'=>'Updated','data'=>$arr];
        // }
    }

    public function checkPersonType(Request $request)
    {
        $date = Carbon::parse($request->dob);
        $now = Carbon::now();
        $age = $date->diff($now)->format('%y'); 
        if ($age <= '18') {
            $person_type = "kid";
            return response()->json(['statusCode' => 200, 'person_type' => $person_type, 'age' => $age]);
        }else if ($age > '18'){
            $person_type = "adult";
            return response()->json(['statusCode' => 200, 'person_type' => $person_type, 'age' => $age]);
        }else{
            return response()->json(['statusCode' => 999, 'person_type' => '', 'age' => '']);
        }
    }

    public function buynow(Request $request) 
    {
        // dd($request->all());exit;
        $request->validate([
            'type' => 'required',
            'user_id' => 'required|numeric',
            // 'category_data.*.id' => 'required',
            'package_id' => 'required|numeric',
            'price' => 'required',
            'click_type' => 'required',
        ],[
            // 'category_data.required' => 'Please select any sport.',
        ]);
        $click_type = $request->click_type;
        $data =  Servicepackages::where('id', $request->package_id)->first();
        if (!empty($data)) {
            if ($click_type == "buynow") {
                $pervious_cartdata =  User_carts::where('click_type',"buynow")->where('user_id', $request->user_id)->get();
                if (!empty($pervious_cartdata[0])) {
                    foreach ($pervious_cartdata as $key => $value) {
                        $itemdata =  User_cart_items::where('cart_id', $value->id)->delete();
                    }
                    $deletecartdata =  User_carts::where('click_type',"buynow")->where('user_id', $request->user_id)->delete();
                }
            }
            $input = $request->only('type','user_id','package_id', 'price');
            $input['click_type'] = $click_type;
            $cartdata =  User_carts::create($input);
            $categorydata = [];
            if ($request->type == "sport" || $request->type == "addon_sport") {
                $categoryids = $request->category_data;
                $i = 1;
                foreach ($categoryids as $key => $value) {
                    $key1 = $key + 1;
                    $input1['cart_id'] = $cartdata->id;
                    $input1['package_id'] = $request->package_id;
                    $input1['category_id'] = $value['id'];
                    $input1['category_year_srno'] = $i;
                    $data1 =  User_cart_items::create($input1);
                    $category =  Servicecategories::where('id', $value['id'])->first();
                    array_push($categorydata,$category);
                    $i++;
                }
            }
            $data->categorydata = $categorydata;
            if ($click_type == "buynow") {
                return redirect('buy');
            }else{
                return redirect('cart');
            }
        
        }
        return redirect()->back()->withError("Package Data Not Found!");
    }

    

    public function cart(Request $request) 
    {
        $type = "sport";
        // $type = $request->type;
        $user_id = auth()->user()->id;
        $languages = Languages::where('status','1')->get();
        $state_data =  States::select('id','name')->orderBy('name',"asc")->get();
        $city_data =  Cities::select('id','name')->orderBy('name',"asc")->get();
        $phonecode_data =  Phonecodes::select('id','phone_code','country_name')->orderBy('country_name',"asc")->get();
        $data =  User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', "cart")->orderBy('created_at',"desc")->get();
        if ($data->count() > 0) {
            $cart_count =  User_carts::where('user_id', $user_id)->where('click_type', "cart")->count();
            $user_data =  User::where('id', $user_id)->first();
            $settings =  Settings::where('id', "1")->where('type', "gst")->first();
            $total_price = '0';
            $addonperson = [];
            foreach ($data as $key => $value) {
                $total_price = $total_price + $value->price;
                $items =  User_cart_items::where('cart_id', $value->id)->orderBy('category_year_srno','asc')->get();
                $categorydata = [];
                foreach ($items as $key1 => $value1) {
                    $category =  Servicecategories::where('id', $value1->category_id)->first();
                    array_push($categorydata,$category);
                }
                $value->categorydata = $categorydata;
                $value->items = $items;
                $value->packagedata->remaining_adult_count = "0";
                $value->packagedata->remaining_kid_count = "0";
                $existsaddon = Addon_persons::where('user_id',$user_id)->where('package_id',$value->package_id)->where("status",'1')->orderBy("created_at","desc")->get();
                
                if ($type == "sport") {
                    $addon_adult_count = $value->packagedata->addon_adult_count;
                    $addon_kid_count = $value->packagedata->addon_kid_count;
                    if (!empty($existsaddon[0])) {
                        $addonperson = $existsaddon;
                        $value->addonperson = $addonperson;
                        $adultcount =  $existsaddon->where('addon_type',"adult")->count();
                        if (!empty($adultcount)) {
                            $value->packagedata->remaining_adult_count = $addon_adult_count - $adultcount;
                            if ($value->packagedata->remaining_adult_count < 0) {
                                $value->packagedata->remaining_adult_count = 0;
                            }
                        }else{
                            $value->packagedata->remaining_adult_count = $addon_adult_count ;
                        }
                        $kidcount =  $existsaddon->where('addon_type',"kid")->count();
                        if (!empty($kidcount)) {
                            $value->packagedata->remaining_kid_count = $addon_kid_count - $kidcount;
                            if ($value->packagedata->remaining_kid_count < 0) {
                                $value->packagedata->remaining_kid_count = 0;
                            }
                        }else{
                            $value->packagedata->remaining_kid_count = $addon_kid_count ;
                        }
                    }else{
                        $value->packagedata->remaining_adult_count = $addon_adult_count ;
                        $value->packagedata->remaining_kid_count = $addon_kid_count ;
                    }
                }else{
                    if (!empty($existsaddon[0])) {
                        $addonperson[] = $existsaddon[0];
                        $value->addonperson = $existsaddon[0];
                        $value->packagedata->remaining_adult_count = '0' ;
                        $value->packagedata->remaining_kid_count = '0' ;
                    }else{
                        $value->packagedata->remaining_adult_count = '1' ;
                        $value->packagedata->remaining_kid_count = '1' ;
                    }
                    $value->packagedata->addon_adult_count = '1' ;
                    $value->packagedata->addon_kid_count = '1' ;
                }
                
            }

            $discount_amount = 0;
            if ($user_data->refer_by != NULL && $user_data->is_use_refer == 0) {
                $referby_user =  User::where('referral_code',$user_data->refer_by)->first();
                if (!empty($referby_user)) {
                    $refer_discount =  Settings::where('type','refer_discount')->first();
                    $discount_amount = round(($total_price * $refer_discount->value / 100),2); 
                }
            }
            
            $total_price_after_discount = $total_price - $discount_amount; 
            $gst_amount = ($total_price_after_discount * $settings->value)/100;
            $final_amount = $total_price_after_discount + $gst_amount;
            $order_id = "SPL".rand(100000,999999).time();

            $amountdetails = array('total_price' => round($total_price,2),'gst_percentage' => $settings->value,'gst_amount' => round($gst_amount,2),'final_amount' => round($final_amount,2),'discount_amount'=>$discount_amount,'total_price_after_discount'=>$total_price_after_discount,'cart_count' => $cart_count,'order_id' => $order_id);
            return view('web.services.cart',compact('amountdetails','data','languages','addonperson','state_data','city_data','phonecode_data'));
        }
        $amountdetails = [];
        $data = [];
        
        return view('web.services.cart',compact('amountdetails','data','languages','state_data','city_data','phonecode_data'));
    } 

    public function removeFromCart(Request $request) 
    {
        $data =  User_carts::where('id', $request->item_id)->where('user_id', $request->user_id)->first();
        if (!empty($data)) {
            $data =  User_carts::where('id', $request->item_id)->where('user_id', $request->user_id)->delete();
            $data1 =  User_cart_items::where('cart_id', $request->item_id)->delete();
            $cart_count =  User_carts::where('user_id', $request->user_id)->count();
            return response()->json(['statusCode' => 200, 'message' => 'Item removed from cart successfully.', 'cart_count'=> $cart_count,'data' => $data]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Item Not Found.']);
        }
    }

    public function buy(Request $request) 
    {
        // $type = "sport";
        // $type = $request->type;
        $user_id = auth()->user()->id;
        $languages = Languages::where('status','1')->get();
        $state_data =  States::select('id','name')->orderBy('name',"asc")->get();
        $city_data =  Cities::select('id','name')->orderBy('name',"asc")->get();
        $phonecode_data =  Phonecodes::select('id','phone_code','country_name')->orderBy('country_name',"asc")->get();
        $data =  User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', "buynow")->orderBy('created_at',"desc")->get();
        $type = $data[0]['type'];
        if ($data->count() > 0) {
            $cart_count =  User_carts::where('user_id', $user_id)->where('click_type', "buynow")->count();
            $user_data =  User::where('id', $user_id)->first();
            $settings =  Settings::where('id', "1")->where('type', "gst")->first();
            $total_price = '0';
            $addonperson = [];
            foreach ($data as $key => $value) {
                $total_price = $total_price + $value->price;
                $items =  User_cart_items::where('cart_id', $value->id)->orderBy('category_year_srno','asc')->get();
                $categorydata = [];
                foreach ($items as $key1 => $value1) {
                    $category =  Servicecategories::where('id', $value1->category_id)->first();
                    array_push($categorydata,$category);
                }
                $value->categorydata = $categorydata;
                $value->items = $items;
                $value->packagedata->remaining_adult_count = "0";
                $value->packagedata->remaining_kid_count = "0";
                $existsaddon = Addon_persons::where('user_id',$user_id)->where('package_id',$value->package_id)->where("status",'1')->orderBy("created_at","desc")->get();
                if ($type == "sport") {
                    $addon_adult_count = $value->packagedata->addon_adult_count;
                    $addon_kid_count = $value->packagedata->addon_kid_count;
                    if (!empty($existsaddon[0])) {
                        $addonperson = $existsaddon;
                        $value->addonperson = $addonperson;
                        $adultcount =  $existsaddon->where('addon_type',"adult")->count();
                        if (!empty($adultcount)) {
                            $value->packagedata->remaining_adult_count = $addon_adult_count - $adultcount;
                            if ($value->packagedata->remaining_adult_count < 0) {
                                $value->packagedata->remaining_adult_count = 0;
                            }
                        }else{
                            $value->packagedata->remaining_adult_count = $addon_adult_count ;
                        }
                        $kidcount =  $existsaddon->where('addon_type',"kid")->count();
                        if (!empty($kidcount)) {
                            $value->packagedata->remaining_kid_count = $addon_kid_count - $kidcount;
                            if ($value->packagedata->remaining_kid_count < 0) {
                                $value->packagedata->remaining_kid_count = 0;
                            }
                        }else{
                            $value->packagedata->remaining_kid_count = $addon_kid_count ;
                        }
                    }else{
                        $value->packagedata->remaining_adult_count = $addon_adult_count ;
                        $value->packagedata->remaining_kid_count = $addon_kid_count ;
                    }
                }else{
                    if (!empty($existsaddon[0])) {
                        $addonperson[] = $existsaddon[0];
                        $value->addonperson = $existsaddon[0];
                        $value->packagedata->remaining_adult_count = '0' ;
                        $value->packagedata->remaining_kid_count = '0' ;
                    }else{
                        $value->packagedata->remaining_adult_count = '1' ;
                        $value->packagedata->remaining_kid_count = '1' ;
                    }
                    $value->packagedata->addon_adult_count = '1' ;
                    $value->packagedata->addon_kid_count = '1' ;
                }
                
            }

            $discount_amount = 0;
            if ($user_data->refer_by != NULL && $user_data->is_use_refer == 0) {
                $referby_user =  User::where('referral_code',$user_data->refer_by)->first();
                if (!empty($referby_user)) {
                    $refer_discount =  Settings::where('type','refer_discount')->first();
                    $discount_amount = round(($total_price * $refer_discount->value / 100),2); 
                }
            }
            
            $total_price_after_discount = $total_price - $discount_amount; 
            $gst_amount = ($total_price_after_discount * $settings->value)/100;
            $final_amount = $total_price_after_discount + $gst_amount;
            $order_id = "SPL".rand(100000,999999).time();

            $amountdetails = array('total_price' => round($total_price,2),'gst_percentage' => $settings->value,'gst_amount' => round($gst_amount,2),'final_amount' => round($final_amount,2),'discount_amount'=>$discount_amount,'total_price_after_discount'=>$total_price_after_discount,'cart_count' => $cart_count,'order_id' => $order_id);
            return view('web.services.buynow',compact('amountdetails','data','languages','addonperson','state_data','city_data','phonecode_data','type'));
        }
        $amountdetails = [];
        $data = [];
        
        return view('web.services.buynow',compact('amountdetails','data','languages','state_data','city_data','phonecode_data'));
    } 

    public function addonsport(Request $request) 
    {
        
        if(auth()->user()->is_active_freetrial != "1" && auth()->user()->is_complete_freetrial != "1"){
            return redirect()->back()->withError("Please Activate Free Trial!");
        }
        if ($request->adddon_type == "addon_person") {
            // return redirect('addon-person');
            $package_id = $request->package_id;
            $user_id = $request->user_id; 
            $total_price = $request->price;
            $type = $request->adddon_type;
            $data =  Servicepackages::where('status', '1')->where('id',$package_id)->first();
            if (!empty($data)) {
                $category =  Servicecategories::where('status', '1')->get();
                // return view('web.services.addon-person',compact('category','data','type','price','user_id','package_id'));
                
                $languages = Languages::where('status','1')->get();
                $state_data =  States::select('id','name')->orderBy('name',"asc")->get();
                $city_data =  Cities::select('id','name')->orderBy('name',"asc")->get();
                $phonecode_data =  Phonecodes::select('id','phone_code','country_name')->orderBy('country_name',"asc")->get();
                $user_data =  User::where('id', $user_id)->first();
                $settings =  Settings::where('id', "1")->where('type', "gst")->first();
                $existsaddon = Addon_persons::where('user_id',$user_id)->where('package_id',$package_id)->where("status",'1')->orderBy("created_at","desc")->get();
                $addonperson = [];
                if (!empty($existsaddon[0])) {
                    $addonperson[] = $existsaddon[0];
                    $data->addonperson = $existsaddon[0];
                    $data->remaining_adult_count = '0' ;
                    $data->remaining_kid_count = '0' ;
                }else{
                    $data->remaining_adult_count = '1' ;
                    $data->remaining_kid_count = '1' ;
                    $data->addon_adult_count = '1' ;
                    $data->addon_kid_count = '1' ;
                }

                $discount_amount = 0;
                if ($user_data->refer_by != NULL && $user_data->is_use_refer == 0) {
                    $referby_user =  User::where('referral_code',$user_data->refer_by)->first();
                    if (!empty($referby_user)) {
                        $refer_discount =  Settings::where('type','refer_discount')->first();
                        $discount_amount = round(($total_price * $refer_discount->value / 100),2); 
                    }
                }
                
                $total_price_after_discount = $total_price - $discount_amount; 
                $gst_amount = ($total_price_after_discount * $settings->value)/100;
                $final_amount = $total_price_after_discount + $gst_amount;
                $order_id = "SPL".rand(100000,999999).time();

                $amountdetails = array('total_price' => round($total_price,2),'gst_percentage' => $settings->value,'gst_amount' => round($gst_amount,2),'final_amount' => round($final_amount,2),'discount_amount'=>$discount_amount,'total_price_after_discount'=>$total_price_after_discount,'order_id' => $order_id);
                return view('web.services.addon-person',compact('category','amountdetails','data','languages','addonperson','state_data','city_data','phonecode_data','type'));
            }
        }else{
            $package_id = $request->package_id;
            $user_id = $request->user_id; 
            $price = $request->price;
            $type = $request->adddon_type;
            $packagedata =  Servicepackages::where('status', '1')->where('parent_id',$package_id)->first();
            if (!empty($packagedata)) {
                $category =  Servicecategories::where('status', '1')->get();
                return view('web.services.addon-service-details',compact('category','packagedata','type','price','user_id','package_id','type'));
            }

        }
    }
    
    public function addonPerson(Request $request)
    {
        // print_r($request->all());exit;
        // $existsaddon = Addon_persons::where('user_id',$request->user_id)->where('package_id',$request->package_id)->get();
        // if (!empty($existsaddon[0])) {
        //     $packagedata =  Servicepackages::where('id', $request->package_id)->first();
        //     $package_adultcount = $packagedata->addon_adult_count;
        //     $exists_adultcount =  $existsaddon->where('addon_type',"adult")->count();
        //     $package_kidcount = $packagedata->addon_kid_count;
        //     $exists_kidcount =  $existsaddon->where('addon_type',"kid")->count();
        //     if ($request->addon_type == "adult") {
        //         if ($exists_adultcount > 0) {
        //             if ($exists_adultcount >= $package_adultcount) {
        //                 return response()->json(['statusCode' => 999, 'message' => 'Adults Limit Reached!']);
        //             }
        //         }
        //     }
        //     if ($request->addon_type == "kid") {
        //         if ($exists_kidcount > 0) {
        //             if ($exists_kidcount >= $package_kidcount) {
        //                 return response()->json(['statusCode' => 999, 'message' => 'Kids Limit Reached!']);
        //             }
        //         }
        //     }
        // }
        // return response()->json(['statusCode' => 200, 'message' => 'Added Successfully.']);
        $input1 = $request->only('order_id','addon_type','user_id','package_id','person_first_name','person_last_name', 'person_email', 'person_phone', 'gender','city','state','weight','height_feet','height_inch','language_id','relation','height_type','weight_type' );
        $input1['dob'] = date("Y-m-d",strtotime($request->dob));
        $input1['status'] = '0';
        $data =  Addon_persons::create($input1);
        if ($data) {
            $addon_data = Addon_persons::where('user_id',$request->user_id)->where('package_id',$request->package_id)
                            ->where(function ($query) use($request) {
                                $query->where('status', '1');
                            })->orWhere(function($query) use($request){
                                $query->where('order_id', $request->order_id)
                                    ->where('status', '0');	
                            })->orderBy("created_at","desc")->get();
            
            // $addon_data = Addon_persons::where('order_id',$request->order_id)->where('user_id',$request->user_id)->where('package_id',$request->package_id)->orderBy("created_at","desc")->get();
            return response()->json(['statusCode' => 200, 'message' => 'Added Successfully.','data' => $addon_data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Data Not Added Successfully!']);
    }
    public function removePerson(Request $request) 
    {
        $data =  Addon_persons::where('id', $request->id)->where('user_id', $request->user_id)->first();
        if (!empty($data)) {
            $data->delete();
            //  $addon_data = Addon_persons::where('order_id',$request->order_id)->where('user_id',$request->user_id)->where('package_id',$request->package_id)->orderBy("created_at","desc")->get();
             
             $addon_data = Addon_persons::where('user_id',$request->user_id)->where('package_id',$request->package_id)
                            ->where(function ($query) use($request) {
                                $query->where('status', '1');
                            })->orWhere(function($query) use($request){
                                $query->where('order_id', $request->order_id)
                                    ->where('status', '0');	
                            })->orderBy("created_at","desc")->get();
            return response()->json(['statusCode' => 200, 'message' => 'Person removed successfully.', 'data' => $addon_data]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        }
    }

    public function orderPlace(Request $request)
    {
        // print_r($request->all());exit;
        $request->validate([
            'type' => 'required',
            'order_id' => 'required',
            'user_id' => 'required|numeric',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable|numeric',
            'package_id' => 'nullable|numeric',
            // 'category_data' => 'nullable',
            'total_price' => 'required',
            'gst_percentage' => 'required',
            'gst_amount' => 'required',
            'final_amount' => 'required',
            'click_type' => 'required',
        ]);
        $packagedata = Servicepackages::where('id', $request->package_id)->first();
        $input = $request->only('user_id','first_name','last_name','package_id', 'email', 'phone',  'total_price', 'gst_percentage', 'gst_amount', 'final_amount','discount_amount','click_type');
        // $input = $request->only('user_id','first_name','last_name', 'email', 'phone', 'package_id', 'total_price', 'gst_percentage', 'gst_amount', 'final_amount','discount_amount');
        $input['order_id'] = $request->order_id;
        $input['status'] = "1";
        $input['name'] = @$request->first_name.' '.@$request->last_name;
        $input['type'] = $request->type;
        $input['payment_status'] = "pending";
        $input['start_date'] = date('Y-m-d H:i:s');
        // $input['end_date'] = date('Y-m-d H:i:s', strtotime('+'.@$packagedata->package_duration.' years'));
        $data =  User_orders::create($input);
        if ($data) {
            $store = $request->store;
            if (!empty($store[0])) {
                foreach ($store as $key3 => $value3) {
                    if ($value3['type'] == "sport" || $value3['type'] == "addon_sport") {
                        $cartdata =  User_carts::with('packagedata')->where('user_id', $request->user_id)->where('package_id',$value3['package_id'])->get();
                        foreach ($cartdata as $key2 => $value2) {
                            // $categoryids = $request->category_data;
                            $categoryids =  User_cart_items::where('cart_id', $value2->id)->orderBy('category_year_srno','asc')->get();
                            foreach ($categoryids as $key => $value) {
                                $input1['order_primary_id'] = $data->id;
                                $input1['order_id'] = $data->order_id;
                                $input1['package_id'] = $value2->package_id;
                                $input1['category_id'] = $value['category_id'];
                                $input1['category_year_srno'] = $value['category_year_srno'];
                                $key1 = $key + 1;
                                $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                                $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                                // $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $orderdata->created_at)->addYear($key1)->subDays(1);
                                if ($value['value'] == 1) {
                                    $input1['status'] = '1';
                                }else {
                                    $input1['status'] = '0';
                                }
                                $data1 =  User_order_items::create($input1);
                            }
                        }
                    }else{
                        $input1 = $request->only('user_id','package_id','person_first_name','person_last_name', 'person_email', 'person_phone', 'dob', 'gender','city','state','weight','height_feet','height_inch','language_id','relation' );
                        $input1['order_id'] = $data->order_id;
                        $addon_persons =  Addon_persons::create($input1);
                    }
                }
            }
            
            $payment_link = route("razorpay-payment",array('orderid'=> $data->order_id));
            // return response()->json(['statusCode' => 200, 'message' => 'Payment Link.','data' => $payment_link]);
            return redirect($payment_link);
        }
        return redirect()->back()->withError("Please, Try Again!");
    }

    public function myPlans() 
    {
        $result = $this->getUserPackage();
        return view('web.my-plans',compact('result'));
    }

    public function newsletters(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user_id = auth()->user()->id;
        $email = $request->email;
        $input['user_id'] = $user_id;
        $input['email'] = $email;
        $check = array('user_id'=> $user_id, 'email' => $email );
        $data =  User_newsletters::updateOrCreate($check, $input);
        if (!empty($data)) {
            return redirect()->back()->withSuccess("Data Submit Successfully.");
        }else{
            return redirect()->back()->withError("Please, Try Again!");
        }
    }
    public function liveSessions()
    {
        $currentdate_time = date("Y-m-d H:i:s");
        // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->get();
        // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $today = Carbon::now();
        $today_name = Carbon::now()->format("l");
        if ($today_name == "Monday") {
            $nextday = Carbon::now()->addDay(2); 
            $second_nextday = Carbon::now()->addDay(4);
            $third_nextday = '';
        }
        if ($today_name == "Tuesday") {
            $nextday = Carbon::now()->addDay(1); 
            $second_nextday = Carbon::now()->addDay(3);
            $third_nextday = Carbon::now()->addDay(6);
        }
        if ($today_name == "Wednesday") {
            $nextday = Carbon::now()->addDay(2); 
            $second_nextday = Carbon::now()->addDay(5);
            $third_nextday = '';
        }
        if ($today_name == "Thursday") {
            $nextday = Carbon::now()->addDay(1); 
            $second_nextday = Carbon::now()->addDay(4);
            $third_nextday = Carbon::now()->addDay(6);
        }
        if ($today_name == "Friday") {
            $nextday = Carbon::now()->addDay(3); 
            $second_nextday = Carbon::now()->addDay(5);
            $third_nextday = '';
        }
        if ($today_name == "Saturday") {
            $nextday = Carbon::now()->addDay(2); 
            $second_nextday = Carbon::now()->addDay(4);
            $third_nextday = Carbon::now()->addDay(6);
        }
        if ($today_name == "Sunday") {
            $nextday = Carbon::now()->addDay(1); 
            $second_nextday = Carbon::now()->addDay(3);
            $third_nextday = Carbon::now()->addDay(5);
        }
        // $today = Carbon::now()->addDay(6);
        // $nextday = Carbon::now()->addDay(6)->addDay(1); 
        // $second_nextday = Carbon::now()->addDay(6)->addDay(3);
        // $third_nextday = Carbon::now()->addDay(6)->addDay(6);
        // print_r($today->format("l")); 
        // print_r($nextday->format("l"));
        // print_r($second_nextday->format("l")); 
        // print_r($third_nextday->format("l")); 
        // exit;
        $nextday_name = $nextday->format("l");
        $second_nextday_name = $second_nextday->format("l");
        if (!empty($third_nextday)) {
            $third_nextday_name = $third_nextday->format("l");
            $day_arr = [$nextday,$second_nextday,$third_nextday];
            $day_name = [$nextday_name,$second_nextday_name,$third_nextday_name];
        }else{
            $day_arr = [$today,$nextday,$second_nextday];
            $day_name = [$today_name,$nextday_name,$second_nextday_name];
        }
        // $day_arr = [$today,$nextday,$second_nextday];
        // $day_name = [$today_name,$nextday_name,$second_nextday_name];
        // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $data = [];
        foreach ($day_arr as $key1 => $value1) {
            $item_data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereDate('start_date_time', $value1)->get();
            if (!empty($item_data[0])) {
                foreach ($item_data as $key => $value) {
                    if ($value->start_date_time <= $currentdate_time) {
                        $value->is_play = "1";
                    }else{
                        $value->is_play = "0";
                    }
                    $date = Carbon::parse($value->start_date_time);
                    $now = Carbon::now();
                    $value->difference = $date->diffInSeconds($now);
                    $value->dayname = $date->format('l');
                    $value->start_date_time = date("H:i:s",strtotime($value->start_date_time));
                    $value->end_date_time = date("H:i:s",strtotime($value->end_date_time));
                }
            }
            $data[0][$key1] = $item_data;
            // $data[0][strval($value1->format("l"))] = $item_data;
        }
        if (!empty($data[0])) {
            return view('web.livevideo.live-videos',compact('day_name','data'));
        }
    }
    public function liveSessionDetails(Request $request, $id)
    {
        $currentdate_time = date("Y-m-d H:i:s");
        // $data =  Live_videos::where('id', $id)->first();
        $data =  Live_videos::where('id', $id)->where('status','1')->where('end_date_time','>=',$currentdate_time)->first();
        if (!empty($data)) {
            if ($data->start_date_time <= $currentdate_time) {
                $data->is_play = "1";
            }else{
                $data->is_play = "0";
            }
            $user = auth()->user();
            $date = Carbon::parse($data->start_date_time);
            $now = Carbon::now();
            $data->difference = $date->diffInSeconds($now);
            $data->dayname = $date->format('l');
            $data->start_date = date("l, M d, Y",strtotime($data->start_date_time)); 
            $data->start_date_time = date("H:i:s",strtotime($data->start_date_time));
            $data->end_date_time = date("H:i:s",strtotime($data->end_date_time));

            $getpackage_data = $this->getUserPackage();

            if(!empty($getpackage_data[0])){
                $data->package_name = $getpackage_data[0]['package'][0]['package_data']['title'] ;
            }elseif($user->is_active_freetrial == '1'){
                $data->package_name = "Free Trial";
            }else{
                $data->package_name = "No Plan Active";
            }
            return view('web.livevideo.live-video-details',compact('data'));
        }
        return redirect()->route("live-sessions")->withError("Video is no longer available!");
    }
    public function liveVideoUser(Request $request)
    {
        $video_id = $request->video_id;
        $user_id = auth()->user()->id;
        $data =  Live_videos::where('id',$video_id)->first();
        if (!empty($data)) {
            $data->view_count = $data->view_count + 1;
            $data->save();
            // $input = $request->only('video_id','user_id');
            $input['video_id'] = $video_id;
            $input['user_id'] = $user_id;
            $check = array('user_id'=> $user_id, 'video_id' => $video_id);
            $data1 =  Live_video_users::updateOrCreate($check, $input);
            return response()->json(['statusCode' => 200, 'message' => ' Added successfully.','data' => $data1]);
        }else{
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        }
    }
    public function sportsCurriculum()
    {
        $data =  Sports_curriculums::where('status','1')->get();
        foreach ($data as $key => $value) { 
            if ($value->type == "sports") {
                $category =  Servicecategories::where('id', $value->category)->first();
                $value->category_title = $category->title;
            }else{
                if ($value->category == "sporty_kid_7") {
                    $value->category_title = "Sports Kid (4 to 7)";
                }else{
                    $value->category_title = "Sports Kid (7 to 9)";
                }
            }
        }
        return view('web.sports-curriculum',compact('data'));
    }
    
    public function updatepasswordPage()
    {
        $user = Auth::user();
        return view('web.update-password', compact('user'));
    }
    public function updatepasswordPost(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user = Auth::user();
        $check = Hash::check($request->current_password, $user->password);
        if ($check) {
            $input['password'] = Hash::make($request->password);
            $user =  auth()->user()->update($input);
            if ($user) {
                $user_data =  User::where('email', $request->email)->first();
                 Auth::logout();
                return redirect(route('login'))->withSuccess('Password Update Successfully. Please Login Again');
            }
           return redirect()->back()->withError('Updation Failed!');
        }else{
            return redirect()->back()->withError('The current password does not match.');
        }
    }

    public function getUserPackage(){
        $user = Auth::user();
        $order_data =  User_orders::where('user_id',$user->id)->where('payment_status',"complete")->orderBy('created_at','desc')->get();
        $result=array();
        if (!empty($order_data[0])) {
            foreach ($order_data as $key => $value) {
                $result[$key]=$value;
                $order_items = User_order_items::select('package_id')->where('order_primary_id',$value->id)->distinct()->get();
                $package=array();
                
                if (!empty($order_items[0])) {
                    foreach ($order_items as $key1 => $value1) {
                        $index = $value1->package_id;
                        $order_package_items = User_order_items::where('order_primary_id',$value->id)->where('package_id',$index)->orderBy("category_year_srno","desc")->get();
                        $package_detail = Servicepackages::where('id',$value1->package_id)->first();
                        
                        $addon_package_detail = Servicepackages::where('parent_id',$value1->package_id)->first();
                        $value1->package_data =  $package_detail;
                        if (!empty($addon_package_detail)) {
                            $value1->addon_package_data =  $addon_package_detail;
                            if ($value1->package_data->addon == '1') {
                                if ($addon_package_detail->addon_price_type == "sport") {
                                    $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
                                    $value1->addon_package_data->addon_price_person = 0;
                                }else{
                                    $value1->addon_package_data->addon_price_sport = 0;
                                    $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
                                }
                            }
                        }else{
                            $value1->addon_package_data =  NULL;
                        }
                        $package[$key1]=$value1;
                        $value1->expiry_date =  $order_package_items[0]['end_date'];
                        
                        $items=array();
                        foreach($order_package_items as $key2=>$value2)
                        {
                            $items[$key2]=$value2;
                        }
                        $package[$key1]['item']=$items;
                        
                        $category_detail = array();
                        foreach ($package[$key1]['item'] as $key3 => $value3) {
                            $category_detail = Servicecategories::where('id',$value3->category_id)->first();
                            $value3->category_detail =  $category_detail;
                        }
                    }
                }else{
                    if ($value->type == "addon_person" || $value->type == "addon_sport") {
                        $package_detail = Servicepackages::where('id',$value->package_id)->first();
                        $package[0]['package_data']=$package_detail;
                    }
                }
                
                 $result[$key]['package']=$package;
            }
        }
        
        return $result;
    }
    public function paymentResponse()
    {
        return view('payment-response');
    }
    //==========================
    
}
