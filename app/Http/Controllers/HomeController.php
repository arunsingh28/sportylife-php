<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Models\Addon_persons;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Faqcategories;
use App\Models\Ingredients;
use App\Models\Languages;
use App\Models\Live_videos;
use App\Models\Live_video_users;
use App\Models\Meal;
use App\Models\News_feeds;
use App\Models\News_feed_comments;
use App\Models\News_feed_likes;
use App\Models\Notifications;
use App\Models\Nutrition_blogs;
use App\Models\Nutrition_blog_comments;
use App\Models\Nutrition_blog_likes;
use App\Models\Nutrition_categories;
use App\Models\Nutrition_diet_datas;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_quotes;
use App\Models\Nutrition_recipes;
use App\Models\Nutrition_recipe_categories;
use App\Models\Phonecodes;
use App\Models\Recipe_comments;
use App\Models\Recipe_likes;
use App\Models\Servicecategories;
use App\Models\Servicepackages;
use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Sports_curriculums;
use App\Models\States;
use App\Models\User;
use App\Models\User_carts;
use App\Models\User_cart_items;
use App\Models\User_completed_meals;
use App\Models\User_diaries;
use App\Models\User_faq_datas;
use App\Models\User_newsletters;
use App\Models\User_orders;
use App\Models\User_order_items;
use App\Models\User_queries;
use App\Models\User_search_keywords;
use App\Models\User_waterlevels;
use App\Models\Workoutcategories;
use App\Models\Workoutvideos;
use App\Models\About_us_pages;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use PDF;
use Session;
use URL;

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
        // $this->checkuserlogin();
        $freepackagedata = Servicepackages::where('status', '1')->where('id', '4')->first();
        $sliders = Sliders::where('status', '1')->orderBy('position', 'asc')->get();
        $mission = Settings::where('type', 'mission')->first();
        $vision = Settings::where('type', 'vision')->first();
        $homecategory = Categories::where('status', '1')->get();
        $userdata = User::where('id', auth()->user()->id)->first();
        $user_id = auth()->user()->id;
        $order_data = User_orders::where('user_id', $user_id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->count();
        if (!empty($order_data)) {
            if ($order_data >= 1) {
                $userdata->is_purchase = '1';
            } else {
                $userdata->is_purchase = '0';
            }
        } else {
            $userdata->is_purchase = '0';
        }

        if (!empty($userdata->freetrial_duration)) {
            $date_from = Carbon::now();
            $date_to = Carbon::parse($userdata->freetrial_duration);
            $interval = $date_from->diffInMinutes($date_to);
            $userdata->freetrial_left_time = $interval;
        } else {
            $userdata->freetrial_left_time = null;
        }

        return view('index', compact('mission', 'vision', 'sliders', 'freepackagedata', 'homecategory', 'userdata'));
    }

    public function checkuserlogin()
    {
        $user = Auth::user();
        if ($user) {
            return redirect(route('home'));
            // return response()->json(['statusCode' => 200, 'message' => ' User Authenticate.','data' => $user]);
        } else {
            return redirect()->back();
            // return response()->json(['statusCode' => 999, 'message' => ' User Not Authenticate.']);
        }
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
        $workoutvideo = Workoutcategories::with('workoutvideodata')->where('status', '1')->where('id', '!=', '6')->get();

        $getpackage_data = $this->getUserPackage();

        if (!empty($getpackage_data[0])) {
            $user = @$getpackage_data[0]['package'][0]['package_data']['title'];
        } elseif (auth()->user()->is_active_freetrial == '1' && auth()->user()->is_complete_freetrial == '0') {
            $user = "Free Trial";
        } else {
            $user = "No Plan Active";
        }
        // echo"<PRE>"; print_r($user);die;
        return view('web.workout-videos', compact('workoutvideo', 'user'));
    }
    public function getVideos(Request $request)
    {
        $category_id = $request->category_id;
        // $currentdate_time = date("Y-m-d H:i:s");
        $currentdate_time = Carbon::now()->subDays(5);
        $getpackage_data = $this->getUserPackage();
        $data = [];
        if (!empty($getpackage_data[0])) {

            foreach ($getpackage_data as $key => $item) {
                foreach ($item->package as $key => $value) {
                    if ($value->package_data->title)  array_push($data, $value->package_data->title);
                }
            }
            $user = @$getpackage_data[0]['package'][0]['package_data']['title'];
        } elseif (auth()->user()->is_active_freetrial == '1' && auth()->user()->is_complete_freetrial == '0') {
            $user = "Free Trial";
        } else {
            $user = "No Plan Active";
        }
        if ($category_id == '6') {
            $workoutvideodata = [];
            // $recordedvideodata = Live_videos::with('workoutcategorydata')->where('status', '1')->whereDate('end_date_time', '<=', $currentdate_time)->select('id', 'category_id', 'title', 'thumbnail', 'video', 'status', 'start_date_time', 'end_date_time', 'created_at', 'updated_at')->get();
            // foreach ($recordedvideodata as $key => $value) {
            //     $date = Carbon::parse($value->start_date_time)->addMinutes(30);
            //     if ($date < $currentdate_time) {
            //         $workoutvideodata[] = $value;
            //     }
            // }
            // $str = "<div class='row'>";
            // foreach ($workoutvideodata as $key => $value) {
            //     // $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><a href=" . asset($value->video) . " class='ply-btn-video'><img src=" . asset($value->thumbnail) . " class='img-fluid' alt=''></a></div>";
            //     // $str .= "<h5 style='color:white;'>".$value->workoutcategorydata->title."</h5><div class='col-lg-3 col-md-6 portfolio-item filter-app'><a href=" . asset($value->video) . " class='ply-btn-video'><img src=" . asset($value->thumbnail) . " class='img-fluid' alt=''></a></div>";
            // }
            // $str .= "</div>";
            // echo $str;
            $arr = [];

            $data = Workoutcategories::where('id', '!=', '6')->where('status', '1')->get();
            foreach ($data as $key => $value) {
                $recordedvideodata = Live_videos::where('category_id', $value->id)->where('status', '1')->whereDate('end_date_time', '<=', $currentdate_time)->select('id', 'category_id', 'title', 'thumbnail', 'video', 'status', 'start_date_time', 'created_at', 'updated_at')->orderBy('id', 'desc')->get();
                foreach ($recordedvideodata as $key1 => $value1) {
                    $date = Carbon::parse($value1->start_date_time)->addMinutes(30);
                    if ($date <= $currentdate_time) {
                        $value->workoutvideodata[] = $value1;
                    }
                }
                if (!empty($value->workoutvideodata[0])) {
                    $arr[] = $value;
                }
                // $value->workoutvideodata = $workoutvideodata;
            }
            // print_r(json_encode($workoutvideodata));exit;
            $str = "<div class='row'>";
            foreach ($arr as $key => $value) {
                // $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><a href=" . asset($value->video) . " class='ply-btn-video'><img src=" . asset($value->thumbnail) . " class='img-fluid' alt=''></a></div>";
                $str .= "<h5 style='color:white;'>" . $value->title . "</h5>";
                foreach ($value->workoutvideodata as $key1 => $value1) {

                    if (count($data)  >= 2 || !in_array($user, ['Nutrition (Duration 6 Months)', 'NUTRITION', 'No Plan Active'])) {
                        $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><a href=" . asset(@$value1->video) . " class='ply-btn-video'><img src=" . asset(@$value1->thumbnail) . " class='img-fluid' alt=''></a><span>" . @$value1->title . "</span></div>";
                    } else {
                        $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><img src=" . asset(@$value1->thumbnail) . " class='img-fluid' alt=''><span>" . @$value1->title . "</span></div>";
                    }
                }
            }
            $str .= "</div>";
            echo $str;
        } else {
            $workoutvideodata = Workoutvideos::where('category_id', $category_id)->get();
            $str = "";
            foreach ($workoutvideodata as $key => $value) {

                if (count($data) >= 2 || !in_array($user, ['Nutrition (Duration 6 Months)', 'NUTRITION', 'No Plan Active'])) {
                    $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><a href=" . asset($value->video) . " class='ply-btn-video'><img src=" . asset($value->thumbnail) . " class='img-fluid' alt=''><span>" . @$value->title . "</span></a></div>";
                } else {
                    $str .= "<div class='col-lg-3 col-md-6 portfolio-item filter-app'><img src=" . asset($value->thumbnail) . " class='img-fluid' alt=''><span>" . @$value->title . "</span></div>";
                }
            }
            echo $str;
        }
    }
    public function nutrition()
    {
        $user_data = Auth::user();
        $user_id = auth()->user()->id;
        $data = Nutrition_categories::where('status', '1')->get();
        $nutrition_quotes = Nutrition_quotes::where('status', '1')->get();
        $todaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d'))->get();
        $yesterdaymealsdata = User_completed_meals::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime("-1 day")))->get();
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
            if ($value->meal_id != null) {
                $mealdetail = Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                if (!empty($mealdetail)) {
                    $t_calorie = $t_calorie + @$mealdetail->calorie;
                    $t_protein = $t_protein + @$mealdetail->protein;
                    $t_carbs = $t_carbs + @$mealdetail->carbs;
                    $t_fats = $t_fats + @$mealdetail->fats;
                }
            }
        }

        $uni_cat = array_unique($frq_id);
        $usermealdata = Nutrition_diet_datas::where('user_id', $user_id)->first();
        if (!empty($usermealdata->diet)) {
            foreach ($usermealdata->diet as $key1 => $value1) {
                if (in_array($value1['frequency_id'], $uni_cat)) {
                    $mealdetail = Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                    $t_calorie = ($t_calorie + (@$mealdetail->calorie * $value1['quantity'])) - @$mealdetail->calorie;
                    $t_protein = ($t_protein + (@$mealdetail->protein * $value1['quantity'])) - @$mealdetail->protein;
                    $t_carbs = ($t_carbs + (@$mealdetail->carbs * $value1['quantity'])) - @$mealdetail->carbs;
                    $t_fats = ($t_fats + (@$mealdetail->fats * $value1['quantity'])) - @$mealdetail->fats;
                }
            }
        }
        $y_frq_id = [];
        foreach ($yesterdaymealsdata as $key => $value) {
            $y_frq_id[] = $value->category_id;
            if ($value->meal_id != null) {
                $mealdetail = Meal::where('frequency_id', $value->category_id)->where('id', $value->meal_id)->first();
                if (!empty($mealdetail)) {
                    $y_calorie = $y_calorie + @$mealdetail->calorie;
                    $y_protein = $y_protein + @$mealdetail->protein;
                    $y_carbs = $y_carbs + @$mealdetail->carbs;
                    $y_fats = $y_fats + @$mealdetail->fats;
                }
            }
        }
        $y_uni_cat = array_unique($y_frq_id);
        if (!empty($usermealdata->diet)) {
            foreach ($usermealdata->diet as $key1 => $value1) {
                if (in_array($value1['frequency_id'], $y_uni_cat)) {
                    $mealdetail = Meal::where('frequency_id', $value1['frequency_id'])->where('id', $value1['meal'])->first();
                    $y_calorie = ($y_calorie + (@$mealdetail->calorie * $value1['quantity'])) - @$mealdetail->calorie;
                    $y_protein = ($y_protein + (@$mealdetail->protein * $value1['quantity'])) - @$mealdetail->protein;
                    $y_carbs = ($y_carbs + (@$mealdetail->carbs * $value1['quantity'])) - @$mealdetail->carbs;
                    $y_fats = ($y_fats + (@$mealdetail->fats * $value1['quantity'])) - @$mealdetail->fats;
                }
            }
        }
        $t_waterlevel = 0;
        $y_waterlevel = 0;
        $todaywaterleveldata = User_waterlevels::where('user_id', $user_id)->where('date', date("Y-m-d"))->first();
        if (!empty($todaywaterleveldata)) {
            $today_waterlevel = 300 - floor($todaywaterleveldata->water_level * 18.75);
            $t_waterlevel = $todaywaterleveldata->water_level * 250 / 1000;
        } else {
            $today_waterlevel = "300";
            $t_waterlevel = "0";
        }
        $yesterday_waterleveldata = User_waterlevels::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime("-1 day")))->first();
        if (!empty($yesterday_waterleveldata)) {
            $yesterday_waterlevel = 300 - floor($yesterday_waterleveldata->water_level * 18.75);
            $y_waterlevel = $yesterday_waterleveldata->water_level * 250 / 1000;
        } else {
            $yesterday_waterlevel = "300";
            $y_waterlevel = "0";
        }
        $nutrition_details = array('today' => array('calorie' => round($t_calorie), 'protein' => round($t_protein), 'carbs' => round($t_carbs), 'fats' => round($t_fats), 'height_feet' => $height_feet, 'height_inch' => $height_inch, 'weight' => $weight), 'yesterday' => array('calorie' => round($y_calorie), 'protein' => round($y_protein), 'carbs' => round($y_carbs), 'fats' => round($y_fats), 'height_feet' => $height_feet, 'height_inch' => $height_inch, 'weight' => $weight));
        return view('web.nutritions.nutrition', compact('nutrition_details', 'user_data', 'today_waterlevel', 'yesterday_waterlevel', 't_waterlevel', 'y_waterlevel', 'todaywaterleveldata', 'nutrition_quotes'));
    }
    public function userWaterLevel($type)
    {
        $user_id = auth()->user()->id;
        $currentdate = date('Y-m-d');
        $data = User_waterlevels::where('user_id', $user_id)->where('date', $currentdate)->first();
        if (!empty($data)) {
            if ($type == "add") {
                if ($data->water_level < "16") {
                    $water_level = $data->water_level + 1;
                } else {
                    return redirect()->back()->withError("Today water limit is complete.");
                    $water_level = $data->water_level;
                }
            } else {
                if ($data->water_level < "1") {
                    return redirect()->back()->withError("You can not decrease more!");
                    // $water_level = $data->water_level;
                } else {
                    $water_level = $data->water_level - 1;
                }
            }
            $data->update(['water_level' => $water_level]);
        } else {
            $input['user_id'] = $user_id;
            $input['date'] = $currentdate;
            $input['water_level'] = '1';
            $data = User_waterlevels::create($input);
        }
        // $check = array('user_id'=> $user_id, 'date' => $currentdate );
        // if ($type == "add") {
        //     $input['water_level'] = $request->water_level;
        // }
        // $data =  User_waterlevels::updateOrCreate($check, $input);
        if ($data) {
            sleep(1);
            return redirect(route('nutrition'));
            // return redirect(route('nutrition'))->withSuccess("Update Successfully");
        }
        return redirect()->back()->withError("Updatation Failed!");
    }
    public function recipes()
    {
        $data = Nutrition_recipe_categories::with('nutrition_recipedata')->where('status', '1')->orderBy('position', 'asc')->get();
        return view('web.nutritions.recipes', compact('data'));
    }
    public function allRecipes($category)
    {
        $categorydata = Nutrition_recipe_categories::where('slug', $category)->first();
        if (!empty($categorydata)) {
            $recipedata = Nutrition_recipes::where('category_id', $categorydata->id)->where('status', '1')->orderBy('created_at', 'desc')->get();
            return view('web.nutritions.all-recipes', compact('categorydata', 'recipedata'));
        }
        return redirect()->back()->withError("No data Found!");
    }
    public function recipeDetails()
    {
        $url = URL::full();
        $explode = explode("?id=", $url);
        $id = $explode[1];

        $recipedata = Nutrition_recipes::where('id', $id)->first();
        if (!empty($recipedata)) {
            $shareRecipe = \Share::page(
                url('recipe-details/?id=' . $id),
                $recipedata->title,
            )->facebook()->twitter()->linkedin()->whatsapp();
            $viewcount = $recipedata->view_count + 1;
            $updateviewcount = Nutrition_recipes::where('id', $recipedata->id)->update(['view_count' => $viewcount]);
            $recipedata = Nutrition_recipes::where('id', $recipedata->id)->first();
            $likedata = Recipe_likes::where('recipe_id', $recipedata->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($likedata)) {
                $recipedata->is_like = 1;
            } else {
                $recipedata->is_like = 0;
            }
            $is_in_diary = User_diaries::where('recipe_id', $recipedata->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($is_in_diary)) {
                $recipedata->is_in_diary = 1;
            } else {
                $recipedata->is_in_diary = 0;
            }
            $arr = [];
            foreach ($recipedata->ingredients as $key => $value) {
                $ingredientsdata = Ingredients::where('id', $value['name'])->first();
                if (!empty($ingredientsdata)) {
                    $arr[$key]['name'] = $ingredientsdata->title;
                    $arr[$key]['quantity'] = $value['quantity'];
                } else {
                    $arr[$key]['name'] = $value['name'];
                    $arr[$key]['quantity'] = $value['quantity'];
                }
            }
            unset($recipedata->ingredients);
            array_multisort(array_column($arr, 'name'), SORT_DESC, $arr);
            $recipedata->ingredients = $arr;
            // $recipedata->ingredients = $arr;
            $commentlist = Recipe_comments::with('userdata')->where('recipe_id', $recipedata->id)->orderBy('id', 'desc')->take(2)->get();
            foreach ($commentlist as $key => $value) {
                $date = Carbon::parse($value->created_at);
                $now = Carbon::now();
                $value->timediff = $date->diff($now)->format('%h h');
            }
            return view('web.nutritions.recipe-details', compact('recipedata', 'shareRecipe', 'commentlist'));
        }
        return redirect()->back()->withError("No data Found!");
    }
    public function recipeLike(Request $request)
    {
        $data = Nutrition_recipes::where('id', $request->recipe_id)->first();
        if (!empty($data)) {
            if (@$request->type == "favourite") {
                $favourite_data = Recipe_likes::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();
                if (empty($favourite_data)) {
                    $input = $request->only('recipe_id');
                    $input['user_id'] = auth()->user()->id;
                    $data1 = Recipe_likes::create($input);
                    $likecount = $data->like_count + 1;
                    $updatelikecount = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                    if (!empty($data1)) {
                        return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Favourite Successfully.', 'data' => $data1]);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                } else {
                    $favourite_data->delete();
                    $likecount = $data->like_count - 1;
                    $data1 = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                    return response()->json(['statusCode' => 300, 'message' => ' Recipe Removed From Favourite.', 'data' => $favourite_data]);
                }
            } else {
                $likedata = User_diaries::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();
                if (empty($likedata)) {
                    $input = $request->only('recipe_id');
                    $input['user_id'] = auth()->user()->id;
                    $input['status'] = '1';
                    $data1 = User_diaries::create($input);
                    $likecount = $data->like_count + 1;
                    $updatelikecount = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                    if (!empty($data1)) {
                        return response()->json(['statusCode' => 200, 'message' => ' Recipe Added into Diary Successfully.', 'data' => $data1]);
                    }
                    return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
                } else {
                    $likedata->delete();
                    $likecount = $data->like_count - 1;
                    $data1 = Nutrition_recipes::where('id', $request->recipe_id)->update(['like_count' => $likecount]);
                    return response()->json(['statusCode' => 300, 'message' => ' Recipe Removed From Diary.', 'data' => $likedata]);
                }
            }
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Found.']);
        }
    }
    public function recipeShare(Request $request)
    {
        $data = Nutrition_recipes::where('id', $request->recipe_id)->first();
        if (!empty($data)) {
            $count = $data->share_count + 1;
            $data1 = Nutrition_recipes::where('id', $request->recipe_id)->update(['share_count' => $count]);
            if (!empty($data1)) {
                return response()->json(['statusCode' => 200, 'message' => 'Recipe Shared.', 'data' => $data1]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
        }
        // else{
        //     return response()->json(['statusCode' => 999, 'message' => 'Recipe Not Found.']);
        // }
    }
    public function addrecipeComment(Request $request)
    {
        $input = $request->only('recipe_id', 'message');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = '1';
        $data = Recipe_comments::create($input);
        if (!empty($data)) {
            $data = Recipe_comments::with('userdata', 'recipedata.recipe_categorydata')->where('id', $data->id)->first();
            return response()->json(['statusCode' => 200, 'message' => ' Comment Added Successfully.', 'data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
    }
    public function nutritionBlogs()
    {
        $blogs = Nutrition_blogs::where('status', '1')->get();
        foreach ($blogs as $key => $value) {
            $likedata = Nutrition_blog_likes::where('blog_id', $value->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($likedata)) {
                $value->is_like = 1;
            } else {
                $value->is_like = 0;
            }
        }
        return view('web.nutritions.nutrition-blogs', compact('blogs'));
    }
    public function nutritionBlogDetails()
    {
        $url = URL::full();
        $explode = explode("?id=", $url);
        $id = $explode[1];

        $blogdetail = Nutrition_blogs::where('id', $id)->first();
        if (!empty($blogdetail)) {
            $shareBlog = \Share::page(
                url('nutritionblog-details/?id=' . $id),
                $blogdetail->title,
            )->facebook()->twitter()->linkedin()->whatsapp();
            // ->telegram()
            // ->reddit();
            $view_count = $blogdetail->view_count + 1;
            $blogdetail->update(['view_count' => $view_count]);
            $likedata = Nutrition_blog_likes::where('blog_id', $blogdetail->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($likedata)) {
                $blogdetail->is_like = 1;
            } else {
                $blogdetail->is_like = 0;
            }
            $commentlist = Nutrition_blog_comments::with('userdata')->where('blog_id', $blogdetail->id)->orderBy('created_at', 'desc')->get();
            // $commentlist =  Nutrition_blog_comments::with('userdata')->where('blog_id', $blogdetail->id)->orderBy('id','desc')->take(2)->get();
            foreach ($commentlist as $key => $value) {
                $date = Carbon::parse($value->created_at);
                $now = Carbon::now();
                $value->timediff = $date->diff($now)->format('%m month, %d days, %h h');
            }

            // print_r($commentlist);exit;
            return view('web.nutritions.nutritionblog-details', compact('blogdetail', 'commentlist', 'shareBlog'));
        }
        return redirect()->back()->withError('No Data Found!');
    }
    public function blogLike(Request $request)
    {
        $data = Nutrition_blogs::where('id', $request->blog_id)->first();
        if (!empty($data)) {
            $likedata = Nutrition_blog_likes::where('blog_id', $request->blog_id)->where('user_id', auth()->user()->id)->first();
            if (empty($likedata)) {
                $input = $request->only('blog_id');
                $input['user_id'] = auth()->user()->id;
                $data1 = Nutrition_blog_likes::create($input);
                if (!empty($data1)) {
                    $likecount = $data->like_count + 1;
                    $data->update(['like_count' => $likecount]);
                    return response()->json(['statusCode' => 200, 'message' => 'Liked.', 'data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
            } else {
                $likedata->delete();
                $likecount = $data->like_count - 1;
                $data->update(['like_count' => $likecount]);
                return response()->json(['statusCode' => 300, 'message' => 'Removed From Liked.', 'data' => $likedata]);
            }
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Nutrition blog Not Found.']);
        }
    }
    public function blogShare(Request $request)
    {
        $data = Nutrition_blogs::where('id', $request->blog_id)->first();
        if (!empty($data)) {
            $count = $data->share_count + 1;
            $data1 = Nutrition_blogs::where('id', $request->blog_id)->update(['share_count' => $count]);
            if (!empty($data1)) {
                return response()->json(['statusCode' => 200, 'message' => ' Nutrition Blog Shared.', 'data' => $data1]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Error!.']);
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Nutrition Blog Not Found.']);
        }
    }
    public function addblogComment(Request $request)
    {
        $input = $request->only('blog_id', 'message');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = '1';
        $data = Nutrition_blog_comments::create($input);
        if (!empty($data)) {
            // $data =  Nutrition_blog_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
            return response()->json(['statusCode' => 200, 'message' => 'Comment Added Successfully.', 'data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
    }
    public function diary()
    {
        $user = Auth::user();
        $date = Carbon::parse($user->dob);
        $now = Carbon::now();
        $user->age = $date->diff($now)->format('%y years');
        $recipecate = Nutrition_recipe_categories::where('status', '1')->get();
        $addonmealcount = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('meal_id', '!=', null)->count();
        $frqudata = Nutrition_diet_frequencies::where('status', '1')->get();
        if (!empty($frqudata[0])) {
            foreach ($frqudata as $key => $value) {
                $is_mealcompletedata = User_completed_meals::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->where('category_id', $value->id)->where('meal_id', null)->first();
                if (!empty($is_mealcompletedata)) {
                    $value->is_complete = "1";
                } else {
                    $value->is_complete = "0";
                }
            }
        }
        return view('web.nutritions.diary', compact('user', 'recipecate', 'frqudata', 'addonmealcount'));
    }
    public function getMealsbyFrequency(Request $request)
    {
        $frequency_id = $request->frequency_id;
        $data = Meal::where('frequency_id', $request->frequency_id)->where('status', '1')->get();
        $str = '<div class="diet_chart Completed" style="margin-top: 0px !important;">    <ul>';
        foreach ($data as $key => $value) {
            $str .= '        <li>            <a href="#!">                  <img src="' . asset("web/assets/img/right-arrow.png") . '">                 <span>' . $value->title . ' </span>            </a>              <label class="checkbox-container" style="margin-top: 5px !important;">                 <input type="checkbox" name="meal_data[0][meal_id][]" value=' . $value->id . '>                <span class="checkmark"></span>            </label>         </li>    ';
        }
        $str .= '</ul></div>';
        echo $str;
    }
    public function mealsComplete(Request $request)
    {
        if (empty($request->meal_data)) {
            return redirect()->back()->withError('Please select Category!');
        }
        $user_id = auth()->user()->id;
        $nutrition_diet_datas = Nutrition_diet_datas::where('user_id', $user_id)->first();
        if (empty($nutrition_diet_datas)) {
            return redirect()->back()->withError('Your diet chart is not created yet.');
        }
        $request->validate([
            'type' => 'required',
        ]);
        $currentdate = date('Y-m-d');
        if ($request->type == "addon") {
            // $data =  User_completed_meals::where('user_id', $user_id)->where('date',$currentdate)->where('meal_id','!=',NULL)->delete();
            $meal_data = $request->meal_data;
            foreach ($meal_data as $key => $value) {
                $input['user_id'] = $user_id;
                $input['date'] = $currentdate;
                $input['category_id'] = $value['category_id'];
                if (!empty($value['meal_id'])) {
                    foreach ($value['meal_id'] as $key1 => $value1) {
                        // $input['meal_id'] = $value1;
                        // $data1 =  User_completed_meals::create($input);
                        $data = User_completed_meals::where('user_id', $user_id)->where('date', $currentdate)->where('category_id', '=', $value['category_id'])->where('meal_id', '=', $value1)->first();
                        if (!empty($data)) {
                            $input['meal_id'] = $value1;
                            $data1 = $data->update($input);
                        } else {
                            $input['meal_id'] = $value1;
                            $data1 = User_completed_meals::create($input);
                        }
                    }
                } else {
                    $data1 = User_completed_meals::create($input);
                }
            }
        } else {
            $data = User_completed_meals::where('user_id', $user_id)->where('date', $currentdate)->where('meal_id', null)->delete();
            $meal_data = $request->meal_data;
            foreach ($meal_data as $key => $value) {
                $input['user_id'] = $user_id;
                $input['date'] = $currentdate;
                $input['category_id'] = $value['category_id'];
                $input['meal_id'] = null;
                $data1 = User_completed_meals::create($input);
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
        $data = Nutrition_diet_datas::where('user_id', '=', $user->id)->get();
        $frqudata = Nutrition_diet_frequencies::all();
        $mealdata = Meal::all();
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
                $customarr1[$key4]['frequency_id'] = $value4[0]['frequency_id'];
                $customarr1[$key4]['frequency_name'] = $frqudata_arr[$value4[0]['frequency_id']];
                $customarr2 = [];
                foreach ($value4 as $key2 => $value2) {
                    $customarr2[$key2]['meal'] = $value2['meal'];
                    $customarr2[$key2]['quantity'] = $value2['quantity'];
                    $customarr2[$key2]['meal_name'] = @$mealdata_arr[$value2['meal']] ?? 'N/A';
                }
                $customarr1[$key4]['meal'] = $customarr2;
            }
            $customarr1 = array_values($customarr1);
        }
        if (!empty($data[0])) {
            $data1 = [
                'title' => $user->name ?? 'Sportylife',
                'date' => date('m/d/Y'),
                'customarr1' => $customarr1,
            ];
            $my_pdf_name = 'uploads/dietchart' . $user->id . '.pdf';
            $my_pdf_path = 'public/' . $my_pdf_name;
            $pdf = PDF::loadView('dietPDF', $data1)->save($my_pdf_path);
            // return $pdf->download($my_pdf_name);
            //  $browsershot = new Browsershot();
            // 9HtUv1B7a4nHbPoIkRXIOzudqxmsqGTBFgWn93sVkGCPXfAPKqCt5WWUHp9WBElh
            // $user = Auth::user();
            $user->dietchart_pdf = $my_pdf_name;
            $user->save();
            $pdfurl = asset($user->dietchart_pdf);
            $note = array('bowl' => '100g', 'cup' => '100ml', 'glass' => '200ml', 'tbsp' => '15g', 'tsp' => '5g');
            return view('web.nutritions.diet-chart', compact('note', 'customarr1', 'pdfurl'));
        }
        return redirect()->back()->withError('No Data Found!');
    }
    public function frc()
    {
        $user_id = Auth::user()->id;
        $user = ApiHelper::getUserFrc($user_id);

        return view('web.frc', compact('user'));
    }
    public function settings()
    {
        $privacy_policy = Settings::where('type', 'privacy_policy_content')->first();
        return view('web.settings', compact('privacy_policy'));
    }
    public function contactUs()
    {
        return view('web.contact-us');
    }
    public function contactUsPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'description' => 'required',
        ]);
        $input = $request->only('name', 'phone', 'subject', 'description');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = 'pending';
        $data = User_queries::create($input);
        if ($data) {
            $email = "support@sportylife.in";
            $subject = $request->subject;
            $mail_res = \Mail::send(
                'sendEnquiryMail',
                ['name' => $request->name, 'phone' => $request->phone, 'subject' => $request->subject, 'description' => $request->description],
                function ($message) use ($email, $subject) {
                    $message->to($email)
                        ->subject($subject);
                }
            );
            $data = User_queries::with('userdata')->where('id', $data->id)->first();
            return redirect(route('web.contact-us'))->withSuccess('Query Submit Successfully.');
        }
        return redirect()->back()->withError('Submission Failed!');
    }
    public function faq()
    {
        $data = Faqcategories::with('faqdata')->where('status', '1')->get();
        $user_id = auth()->user()->id;

        foreach ($data as $key => $value) {
            foreach ($value->faqdata as $key1 => $value1) {
                $getData = User_faq_datas::where('user_id', $user_id)->where('faq_id', $value1->id)->first();
                if (!empty($getData)) {
                    $value1->faq_user_response = $getData->response;
                } else {
                    $value1->faq_user_response = null;
                }
            }
        }
        return view('web.faq', compact('data'));
    }

    public function faqUpdateResponseweb(Request $request)
    {
        $user_id = auth()->user()->id;
        $getData = User_faq_datas::where('user_id', $user_id)->where('faq_id', $request->faq_id)->first();
        if (!empty($getData)) {
            $getData->response = $request->response;
            $getData->save();
            $data = User_faq_datas::where('user_id', $user_id)->where('faq_id', $request->faq_id)->first();
        } else {
            $input = $request->only('faq_id', 'response');
            $input['user_id'] = $user_id;
            $data = User_faq_datas::create($input);
        }
        if ($data) {
            return response()->json(['statusCode' => 200, 'message' => 'Submit Successfully.', 'data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Submission Failed.']);
    }
    public function inviteFriends()
    {
        return view('web.invite-friends');
    }
    public function inviteHistory()
    {
        $data = User::where('refer_by', auth()->user()->referral_code)->get();
        return view('web.invite-history', compact('data'));
    }
    public function myDiary()
    {
        $user_id = auth()->user()->id;
        $data = User_diaries::with('recipedata', 'userdata')->where('user_id', $user_id)->get();
        return view('web.my-diary', compact('data'));
    }
    public function privacyPolicy()
    {
        $data = Settings::where('type', "privacy_policy_content")->first();
        return view('web.privacy-policy', compact('data'));
    }
    public function termsConditions()
    {
        $data = Settings::where('type', "terms_conditions_content")->first();
        return view('web.terms-conditions', compact('data'));
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
        // print_r(json_encode($getpackage_data));exit;
        if (!empty($getpackage_data[0])) {
            $user->active_plan = @$getpackage_data[0]['package'][0]['package_data']['title'];
        } elseif ($user->is_active_freetrial == '1' && $user->is_complete_freetrial == '0') {
            $user->active_plan = "Free Trial";
        } else {
            $user->active_plan = "No Plan Active";
        }
        return view('web.profile', compact('user'));
    }

    public function profileEdit($type)
    {
        $user = Auth::user();
        $languages = Languages::where('status', '1')->get();
        $state_data = States::select('id', 'name')->orderBy('name', "asc")->get();
        $city_data = Cities::select('id', 'name')->orderBy('name', "asc")->get();
        $phonecode_data = Phonecodes::select('id', 'phone_code', 'country_name')->orderBy('country_name', "asc")->get();
        return view('web.profile-edit', compact('user', 'languages', 'state_data', 'city_data', 'phonecode_data', 'type'));
    }
    public function profileEditPost(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'language_id' => 'required',
            'city' => 'nullable',
            'state' => 'nullable',
            'weight' => 'nullable|numeric|regex:/^[0-9]+$/',
            'height_feet' => 'nullable|numeric|regex:/^[0-9]+$/',
            'height_inch' => 'nullable|numeric|regex:/^[0-9]+$/',
            'image' => 'nullable',
        ]);
        $input = $request->only('first_name', 'last_name', 'country_code', 'language_id', 'city', 'state', 'weight', 'weight_type', 'height_type', 'height_feet', 'height_inch', 'school_name', 'school_address', 'school_unique_id', 'zipcode', 'gender');
        $input['name'] = @$request->first_name . ' ' . @$request->last_name;
        $input['dob'] = date("Y-m-d", strtotime($request->dob));
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/' . $imageName;
        }
        $user = User::where('id', auth()->user()->id)->update($input);
        $page_type = $request->page_type;
        if ($user) {
            if ($page_type == "frc") {
                return redirect(route('frc'))->withSuccess('Update Successfully.');
            } else {
                return redirect(route('profile'))->withSuccess('Update Successfully.');
            }
        }
        return redirect()->back()->withError('Updatation Failed!');
    }
    public function notifications()
    {
        $today = Notifications::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->orderBy("created_at", "DESC")->get();
        $previous = Notifications::where('user_id', auth()->user()->id)->whereDate('created_at', '<', date('Y-m-d'))->orderBy("created_at", "DESC")->get();
        foreach ($today as $key => $value) {
            $date = Carbon::parse($value->created_at);
            $now = Carbon::now();
            // $value->timediff = $date->diff($now)->format('%d days, %h hours');
            $value->timediff = $date->diff($now);
            if ($value->timediff->y > 0) {
                $value->timediff = $date->diff($now)->format('%y year');
            } elseif ($value->timediff->m > 0) {
                $value->timediff = $date->diff($now)->format('%m month');
            } elseif ($value->timediff->d > 0) {
                $value->timediff = $date->diff($now)->format('%d days');
            } elseif ($value->timediff->h > 0) {
                $value->timediff = $date->diff($now)->format('%h hour');
            } elseif ($value->timediff->i > 0) {
                $value->timediff = $date->diff($now)->format('%i minute');
            } else {
                $value->timediff = $date->diff($now)->format('%s second');
            }
        }
        foreach ($previous as $key1 => $value1) {
            $date = Carbon::parse($value1->created_at);
            $now = Carbon::now();
            // $value1->timediff = $date->diff($now)->format('%d days, %h hours');
            $value1->timediff = $date->diff($now);
            if ($value1->timediff->y > 0) {
                $value1->timediff = $date->diff($now)->format('%y year');
            } elseif ($value1->timediff->m > 0) {
                $value1->timediff = $date->diff($now)->format('%m month');
            } elseif ($value1->timediff->d > 0) {
                $value1->timediff = $date->diff($now)->format('%d days');
            } elseif ($value1->timediff->h > 0) {
                $value1->timediff = $date->diff($now)->format('%h hour');
            } elseif ($value1->timediff->i > 0) {
                $value1->timediff = $date->diff($now)->format('%i minute');
            } else {
                $value1->timediff = $date->diff($now)->format('%s second');
            }
            // dd($value1->timediff);
        }
        // dd($today->count());
        // dd($previous->count());
        return view('web.notifications', compact('today', 'previous'));
    }

    public function familyMembers()
    {
        $mainuser = Auth::user();
        $addon_users = User::where("parent_id", $mainuser->id)->orderBy("first_name", 'asc')->get();
        // $family_members = Addon_persons::where("cart_id", NULL)->where("status", '1')->where("user_id", $user->id)->orderBy("person_first_name", 'asc')->select('id', 'user_id', 'person_first_name', 'person_last_name', 'person_email', 'person_phone', 'dob', 'gender')->get();
        // foreach ($family_members as $key => $value) {
        //     $value->id = $value->id;
        //     $value->parent_id = $value->user_id;
        //     $value->first_name = $value->person_first_name;
        //     $value->last_name = $value->person_last_name;
        //     $value->email = $value->person_email;
        //     $value->phone = $value->person_phone;
        //     $value->dob = $value->dob;
        //     $value->gender = $value->gender;
        //     $value->image = "uploads/images/dummy_male.png";
        // }

        return view('web.services.family-members', compact('addon_users'));
    }

    public function search()
    {
        $user_id = auth()->user()->id;
        $recent_search = User_search_keywords::where('user_id', $user_id)->get();
        $favourite_data = Recipe_likes::with('recipedata')->where('user_id', $user_id)->get();
        return view('web.search', compact('recent_search', 'favourite_data'));
    }

    public function clearSerchHistory()
    {
        $data = User_search_keywords::where('user_id', auth()->user()->id)->get();
        if (!empty($data[0])) {
            $data = User_search_keywords::where('user_id', auth()->user()->id)->delete();
            return redirect(route('search'));
        }
        return redirect(route('search'))->withError("No Search History Found!");
    }
    public function getSearchData(Request $request)
    {
        $keyword = $request->keyword;
        $user_id = auth()->user()->id;
        // if (!empty($keyword)) {
        //     $check = array('user_id'=> $user_id, 'title' => $keyword );
        //     $input['user_id'] = $user_id;
        //     $input['title'] = $keyword;
        //     $data =  User_search_keywords::updateOrCreate($check, $input);
        // }
        $recipe_data = Nutrition_recipes::where('title', 'LIKE', '%' . $keyword . '%')->where('status', '1')->select('id', 'title', 'slug', 'type', 'uploads', 'thumbnail')->get();
        $blog_data = Nutrition_blogs::where('title', 'LIKE', '%' . $keyword . '%')->where('status', '1')->select('id', 'title', 'slug', 'image')->get();
        foreach ($recipe_data as $key => $value) {
            $value->search_type = "recipe";
            if ($value->type == "video") {
                $value->image = $value->thumbnail;
            } else {
                $value->image = $value->uploads;
            }
        }
        foreach ($blog_data as $key1 => $value1) {
            $value1->search_type = "blog";
        }
        $recent_search = User_search_keywords::where('user_id', $user_id)->get();
        $favourite_data = Recipe_likes::with('recipedata')->where('user_id', $user_id)->get();
        if (!empty($recipe_data[0]) || !empty($blog_data[0])) {
            $data = array_merge($recipe_data->toArray(), $blog_data->toArray());
            $str = "";
            foreach ($data as $key => $value) {
                if ($value['search_type'] == "recipe") {
                    $url = url('recipe-details/?id=' . $value['id']);
                } else {
                    $url = url('nutritionblog-details/?id=' . $value['id']);
                }
                $str .= "<div class='col-md-12'><div class='notification_Inner'>   <div class='readable_allowed'>      <div class='row'>         <div class='col-md-12'>             <div class='row'>               <div class='col-md-3'>                   <a href='" . $url . "'>                  <img style='height: 59px !important;border-radius: 10px;object-fit: cover;width: -webkit-fill-available;' src='" . asset($value['image']) . "'>        </a>      </div>      <div class='col-md-7'>        <a href='" . $url . "'><h5> " . \Str::limit($value['title'], 100, '...') . "</h5></a>     </div>     <div class='col-md-2'>        <a href='" . $url . "'><span style='font-size: 12px;color: #212121;border-radius: 10px;background: yellow;padding: 0px 7px 0px 7px;font-weight: 700;float: right;'>" . ucfirst($value['search_type']) . "</span></a>                    </div>                 </div>              </div>           </div>        </div>     </div>  </div>";
            }
            echo $str;
            // return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('search_data'=>$data, 'recent_search'=> $recent_search, 'favourite_data'=> $favourite_data)]);
        }
        // $data = [];
        // return response()->json(['statusCode' => 200, 'message' => 'Data Available.','data' => array('search_data'=>$data, 'recent_search'=> $recent_search, 'favourite_data'=> $favourite_data)]);
    }

    public function saveSearchData(Request $request)
    {
        $keyword = $request->keyword;
        $user_id = auth()->user()->id;
        if (!empty($keyword)) {
            $check = array('user_id' => $user_id, 'title' => $keyword);
            $input['user_id'] = $user_id;
            $input['title'] = $keyword;
            $data = User_search_keywords::updateOrCreate($check, $input);
        }
        return response()->json(['statusCode' => 200, 'message' => 'Saved.']);
    }
    public function freeTrial()
    {
        $user = Auth::user();
        $packagedata = Servicepackages::where('status', '1')->where('id', '4')->first();
        if (!empty($packagedata)) {
            return view('web.services.free-trial', compact('packagedata', 'user'));
        }
        return redirect(route('services'))->withError("Data Not Found!");
    }
    public function startFreeTrial()
    {
        $user = auth()->user();
        if ($user->is_complete_freetrial == "1") {
            return redirect()->back()->withError("Already Used!");
        }
        if ($user->is_active_freetrial == "1") {
            return redirect()->back()->withError("Already Activeted!");
        }
        $currentdate = date("Y-m-d H:i:s");
        $freetrial_duration = Carbon::createFromFormat('Y-m-d H:i:s', $currentdate)->addDays(7);
        $user->update(['is_active_freetrial' => '1', 'freetrial_duration' => $freetrial_duration]);
        if (!empty($user)) {
            $user_data = auth()->user();

            $message_data_freetrial = "Dear " . $user_data->name . ", Free Trial Activated Successfully!";
            @$sendemail = ApiHelper::sendEmailMessage($message_data_freetrial, $user_data->email, "Free Trial");

            return redirect(route('free-trial'))->withSuccess("Free Trial Plan Active Successfully");
        }
        return redirect()->back()->withError("Activation Failed!");
    }
    public function aboutUs()
    {
        $content1 = About_us_pages::where('type', 'content')->where('id', '1')->where('status', '1')->first();
        $content2 = About_us_pages::where('type', 'content')->where('id', '2')->where('status', '1')->first();
        $members = About_us_pages::where('type', 'member')->where('status', '1')->get();
        return view('web.about-us', compact('content1', 'content2', 'members'));
    }
    public function services()
    {
        $freepackagedata = Servicepackages::where('status', '1')->where('id', '4')->first();
        $category = Servicecategories::where('status', '1')->get();
        $sportPackagedata = Servicepackages::where('package_type', 'android')->where('status', '1')->whereIn('id', [1, 2, 3])->where('parent_id', null)->get();
        $lifePackagedata = Servicepackages::where('package_type', 'android')->where('status', '1')->whereIn('id', [6, 14, 15])->where('parent_id', null)->get();
        $nutritionPackagedata = Servicepackages::where('package_type', 'android')->where('status', '1')->whereIn('id', [16])->where('parent_id', null)->get();
        $user = auth()->user();
        $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->count();
        if (!empty($order_data)) {
            if ($order_data >= 1) {
                $user->is_purchase = '1';
            } else {
                $user->is_purchase = '0';
            }
        } else {
            $user->is_purchase = '0';
        }
        return view('web.services.services', compact('category', 'sportPackagedata', 'lifePackagedata', 'nutritionPackagedata', 'freepackagedata', 'user'));
    }
    public function test()
    {
        $freepackagedata = Servicepackages::where('status', '1')->where('id', '4')->first();
        $category = Servicecategories::where('status', '1')->get();
        $sportPackagedata = Servicepackages::where('package_type', 'android')->where('status', '1')->whereIn('id', [1, 2, 3])->where('parent_id', null)->get();
        $lifePackagedata = Servicepackages::where('package_type', 'android')->where('status', '1')->whereIn('id', [6, 14, 15])->where('parent_id', null)->get();
        $nutritionPackagedata = Servicepackages::where('package_type', 'android')->where('status', '1')->whereIn('id', [16])->where('parent_id', null)->get();
        $user = auth()->user();
        $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->count();
        if (!empty($order_data)) {
            if ($order_data >= 1) {
                $user->is_purchase = '1';
            } else {
                $user->is_purchase = '0';
            }
        } else {
            $user->is_purchase = '0';
        }
        return view('web.services.test', compact('category', 'sportPackagedata', 'lifePackagedata', 'nutritionPackagedata', 'freepackagedata', 'user'));
    }
    public function serviceDetails($slug)
    {
        // if (auth()->user()->is_active_freetrial != "1" && auth()->user()->is_complete_freetrial != "1") {
        //     return redirect()->back()->withError("Please Activate Free Trial!");
        // }
        $packagedata = Servicepackages::where('status', '1')->where('slug', $slug)->first();
        if (!empty($packagedata)) {
            $category = Servicecategories::where('status', '1')->get();
            return view('web.services.service-details', compact('category', 'packagedata',));
        }
        return redirect(route('services'))->withError("Data Not Found!");
    }

    public function updateOrder(Request $request)
    {
        // $arr = explode(',',$request->input('ids'));
        $arr = $request->input('ids');
        // if($request->has('ids')){
        foreach ($arr as $sortOrder => $id) {
            $cartdata = User_cart_items::where('cart_id', $request->item_id)->where('category_id', $id)->first();
            $cartdata->category_year_srno = $sortOrder + 1;
            $cartdata->save();
        }
        return ['success' => true, 'message' => 'Updated', 'data' => $arr];
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
        } else if ($age > '18') {
            $person_type = "adult";
            return response()->json(['statusCode' => 200, 'person_type' => $person_type, 'age' => $age]);
        } else {
            return response()->json(['statusCode' => 999, 'person_type' => '', 'age' => '']);
        }
    }

    public function getUserDob(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user) {
            return response()->json(['statusCode' => 200, 'message' => "Data Available.", 'data' => $user]);
        } else {
            return response()->json(['statusCode' => 999, 'data' => "Data Not Available.", 'data' => '']);
        }
    }

    public function buynow(Request $request)
    {
        // dd($request->all());exit;
        $request->validate([
            'type' => 'required',
            'user_id' => 'required|numeric',
            'package_id' => 'required|numeric',
            'price' => 'required',
            'click_type' => 'required',
        ], [
            // 'category_data.required' => 'Please select any sport.',
        ]);
        $user = auth()->user();
        if ($request->type == "sport") {
            // $check_existing_order = User_orders::where('user_id',$user->id)->where('payment_status','complete')->where('package_id',$request->package_id)->orWhere('parent_package_id',$request->package_id)->first();

            $check_existing_order = User_orders::where('user_id', $user->id)
                ->where('payment_status', 'complete')
                ->where(function ($query) use ($request) {
                    $query->where('package_id', '=', $request->package_id);
                    $query->orWhere('parent_package_id', '=', $request->package_id);
                })
                ->first();
            if (!empty($check_existing_order)) {
                $order_package_items = User_order_items::where('user_id', $user->id)->where('order_primary_id', $check_existing_order->id)->orderBy("category_year_srno", "desc")->get();
                if (!empty($order_package_items[0])) {
                    if (date('Y-m-d') < date('Y-m-d', strtotime($order_package_items[0]['end_date']))) {
                        return redirect()->back()->withError("Already purchased!");
                    }
                } else {
                    return redirect()->back()->withError("Already purchased!");
                }
            }
        }

        $click_type = $request->click_type;
        $data = Servicepackages::where('id', $request->package_id)->first();
        if (!empty($data)) {
            if (!empty($request->category_data)) {
                $categoryids = $request->category_data;
            } else {
                $categoryids[] = array("id" => '1', "value" => '1');
            }
            if ($request->type == "sport" || $request->type == "addon_sport") {
                // $categoryids = $request->category_data;

                if (count($categoryids) > 1) {
                    $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                    if (empty($servicepackages_data)) {
                        return redirect()->back()->withError("Can not choose mulitple sport at this time!");
                    }
                }
            }

            if ($click_type == "buynow") {
                $pervious_cartdata = User_carts::where('click_type', "buynow")->where('user_id', $request->user_id)->get();
                if (!empty($pervious_cartdata[0])) {
                    foreach ($pervious_cartdata as $key => $value) {
                        $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                    }
                    $deletecartdata = User_carts::where('click_type', "buynow")->where('user_id', $request->user_id)->delete();
                }
            }
            if ($click_type == "cart") {
                $pervious_cartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->get();
                // $pervious_cartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->where('package_id', $request->package_id)->get();
                if (!empty($pervious_cartdata[0])) {
                    foreach ($pervious_cartdata as $key => $value) {
                        $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                    }
                    $deletecartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->delete();
                    // $deletecartdata = User_carts::where('click_type', "cart")->where('user_id', $request->user_id)->where('package_id', $request->package_id)->delete();
                }
            }

            $input = $request->only('type', 'user_id', 'price');
            if ($request->type == "sport") {
                $input['package_id'] = $request->package_id;
                $input['parent_package_id'] = $request->package_id;
            } else {
                $input['package_id'] = $request->package_id;
                $input['parent_package_id'] = $request->parent_package_id;
            }
            $input['click_type'] = $click_type;
            $cartdata = User_carts::create($input);
            $categorydata = [];
            if ($request->type == "sport" || $request->type == "addon_sport") {
                // $categoryids = $request->category_data;
                // if (!empty($request->category_data[0])) {
                //     print_r("1--");
                //     $categoryids = $request->category_data;
                // } else {
                //     print_r("2--");
                //     $categoryids[] = array("id" => '1', "value" => '1');
                // }
                $i = 1;
                foreach ($categoryids as $key => $value) {
                    $key1 = $key + 1;
                    $input1['cart_id'] = $cartdata->id;
                    $input1['package_id'] = $request->package_id;
                    $input1['category_id'] = $value['id'];
                    $input1['category_year_srno'] = $i;
                    if ($i > 1) {
                        $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                        if (!empty($servicepackages_data)) {
                            $input1['sport_price'] = $servicepackages_data->price;
                        } else {
                            return redirect()->back()->withError("Can not choose mulitple sport at this time!");
                        }
                    } else {
                        $input1['sport_price'] = '0';
                    }

                    $data1 = User_cart_items::create($input1);
                    $category = Servicecategories::where('id', $value['id'])->first();
                    array_push($categorydata, $category);
                    $i++;
                }
            }
            $data->categorydata = $categorydata;
            if ($click_type == "buynow") {
                return redirect('buy');
            } else {
                return redirect('cart');
            }
        }
        return redirect()->back()->withError("Package Data Not Found!");
    }

    public function addsport(Request $request)
    {
        $user = Auth::user();
        $cartdata = User_carts::where('id', $request->cart_id)->where('user_id', $user->id)->first();
        $categoryids = $request->category_id;
        if (count($categoryids) > 1) {
            $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
            if (empty($servicepackages_data)) {
                return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
            }
        }
        if (!empty($cartdata)) {
            $cartitemdata = User_cart_items::where('cart_id', $request->cart_id)->where('package_id', $request->package_id)->get();
            $itemdata = User_cart_items::where('cart_id', $request->cart_id)->where('package_id', $request->package_id)->delete();
            $i = 1;
            foreach ($categoryids as $key => $value) {
                $key1 = $key + 1;
                $input1['cart_id'] = $request->cart_id;
                $input1['package_id'] = $request->package_id;
                $input1['category_id'] = $value;
                $input1['category_year_srno'] = $i;
                if ($i > 1) {
                    $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "sport")->first();
                    if (!empty($servicepackages_data)) {
                        $input1['sport_price'] = $servicepackages_data->price;
                    } else {
                        return response()->json(['statusCode' => 999, 'message' => 'Can not choose mulitple sport at this time!']);
                    }
                } else {
                    $input1['sport_price'] = '0';
                }
                $data1 = User_cart_items::create($input1);
                $i++;
            }
            return response()->json(['statusCode' => 200, 'message' => 'Sport Added Successfully.', 'data' => $data1]);
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Addition Failed.']);
        }
    }

    public function cart(Request $request)
    {
        $type = "sport";
        // $type = $request->type;
        $user_id = auth()->user()->id;
        $order_id = "SPL" . rand(100000, 999999) . time();
        $languages = Languages::where('status', '1')->get();
        // $user_list = User::where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'parent_id', 'role_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'dob', 'gender', 'image')->get();
        $user_list = User::where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'name')->get();
        $state_data = States::select('id', 'name')->orderBy('name', "asc")->get();
        $city_data = Cities::select('id', 'name')->orderBy('name', "asc")->get();
        $service_category = Servicecategories::where('status', '1')->get();
        $phonecode_data = Phonecodes::select('id', 'phone_code', 'country_name')->orderBy('country_name', "asc")->get();
        $data = User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', "cart")->orderBy('created_at', "desc")->get();
        if ($data->count() > 0) {
            $cart_count = User_carts::where('user_id', $user_id)->where('click_type', "cart")->count();
            $user_data = User::where('id', $user_id)->first();
            $settings = Settings::where('id', "1")->where('type', "gst")->first();
            $total_price = '0';
            $addonperson = [];
            foreach ($data as $key => $value) {
                $total_price = $total_price + $value->price;
                $items = User_cart_items::where('cart_id', $value->id)->orderBy('category_year_srno', 'asc')->get();
                $categorydata = [];
                $categoryids = [];
                foreach ($items as $key1 => $value1) {
                    $category = Servicecategories::where('id', $value1->category_id)->first();

                    $category->sport_price = $value1->sport_price;
                    $total_price = $total_price + $category->sport_price;

                    array_push($categorydata, $category);
                    array_push($categoryids, $value1->category_id);
                }
                $value->categorydata = $categorydata;
                $value->categoryids = $categoryids;
                $value->items = $items;
                $value->packagedata->remaining_adult_count = "0";
                $value->packagedata->remaining_kid_count = "0";
                $existsaddon = Addon_persons::where('cart_id', $value->id)->where('user_id', $user_id)->orderBy("created_at", "asc")->get();
                foreach ($existsaddon as $key2 => $value2) {
                    $total_price = $total_price + $value2->person_price;
                }
                @$update_addon = Addon_persons::where('cart_id', $value->id)->where('user_id', $user_id)->orderBy("created_at", "asc")->update(['order_id' => $order_id]);
                $value->addonperson = $existsaddon;
            }

            $discount_amount = 0;
            if ($user_data->refer_by != null && $user_data->is_use_refer == 0) {
                $referby_user = User::where('referral_code', $user_data->refer_by)->first();
                if (!empty($referby_user)) {
                    $refer_discount = Settings::where('type', 'refer_discount')->first();
                    $discount_amount = round(($total_price * $refer_discount->value / 100), 2);
                }
            }
            $total_price_after_discount = $total_price - $discount_amount;
            $gst_amount = ($total_price_after_discount * $settings->value) / 100;
            $final_amount = $total_price_after_discount + $gst_amount;
            $update_cart = User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', "cart")->orderBy('created_at', "desc")->update(['order_id' => $order_id]);

            $amountdetails = array('total_price' => round($total_price, 2), 'gst_percentage' => $settings->value, 'gst_amount' => round($gst_amount, 2), 'final_amount' => round($final_amount, 2), 'discount_amount' => $discount_amount, 'total_price_after_discount' => $total_price_after_discount, 'cart_count' => $cart_count, 'order_id' => $order_id);
            return view('web.services.cart', compact('amountdetails', 'data', 'languages', 'addonperson', 'state_data', 'city_data', 'phonecode_data', 'service_category', 'user_list'));
        }
        $amountdetails = [];
        $data = [];

        return view('web.services.cart', compact('amountdetails', 'data', 'languages', 'state_data', 'city_data', 'phonecode_data', 'service_category', 'user_list'));
    }

    public function removeFromCart(Request $request)
    {
        $data = User_carts::where('id', $request->item_id)->where('click_type', $request->click_type)->where('user_id', $request->user_id)->first();
        if (!empty($data)) {
            $data = User_carts::where('id', $request->item_id)->where('click_type', $request->click_type)->where('user_id', $request->user_id)->delete();
            $data1 = User_cart_items::where('cart_id', $request->item_id)->delete();
            $cart_count = User_carts::where('user_id', $request->user_id)->where('click_type', $request->click_type)->count();
            return response()->json(['statusCode' => 200, 'message' => 'Item removed from cart successfully.', 'cart_count' => $cart_count, 'data' => $data]);
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Item Not Found.']);
        }
    }

    public function buy(Request $request)
    {
      
        // $type = "sport";
        // $type = $request->type;
        $user_id = auth()->user()->id;
        $order_id = "SPL" . rand(100000, 999999) . time();
        $languages = Languages::where('status', '1')->get();
        // $user_list = User::where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'parent_id', 'role_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'dob', 'gender', 'image')->get();
        $user_list = User::where('id', '!=', $user_id)->where('status', '1')->where('parent_id', null)->where('role_id', '!=', '1')->orderBy("name", "asc")->select('id', 'name')->get();
        $state_data = States::select('id', 'name')->orderBy('name', "asc")->get();
        $city_data = Cities::select('id', 'name')->orderBy('name', "asc")->get();
        $service_category = Servicecategories::where('status', '1')->get();
        $phonecode_data = Phonecodes::select('id', 'phone_code', 'country_name')->orderBy('country_name', "asc")->get();
        $data = User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', "buynow")->orderBy('created_at', "desc")->get();
        if ($data->count() > 0) {
            $type = $data[0]['type'];
            $cart_count = User_carts::where('user_id', $user_id)->where('click_type', "buynow")->count();
            $user_data = User::where('id', $user_id)->first();
            $settings = Settings::where('id', "1")->where('type', "gst")->first();
            $total_price = '0';
            $addonperson = [];
            foreach ($data as $key => $value) {
                $total_price = $total_price + $value->price;
                $items = User_cart_items::where('cart_id', $value->id)->orderBy('category_year_srno', 'asc')->get();
                $categorydata = [];
                $categoryids = [];
                foreach ($items as $key1 => $value1) {
                    $category = Servicecategories::where('id', $value1->category_id)->first();

                    $category->sport_price = $value1->sport_price;
                    $total_price = $total_price + $category->sport_price;

                    array_push($categorydata, $category);
                    array_push($categoryids, $value1->category_id);
                }
                $value->categorydata = $categorydata;
                $value->categoryids = $categoryids;
                $value->items = $items;

                $existsaddon = Addon_persons::where('cart_id', $value->id)->where('user_id', $user_id)->orderBy("created_at", "asc")->get();
                foreach ($existsaddon as $key2 => $value2) {
                    $total_price = $total_price + $value2->person_price;
                }
                @$update_addon = Addon_persons::where('cart_id', $value->id)->where('user_id', $user_id)->orderBy("created_at", "asc")->update(['order_id' => $order_id]);
                $value->addonperson = $existsaddon;
            }
            $discount_amount = 0;
            if ($user_data->refer_by != null && $user_data->is_use_refer == 0) {
                $referby_user = User::where('referral_code', $user_data->refer_by)->first();
                if (!empty($referby_user)) {
                    $refer_discount = Settings::where('type', 'refer_discount')->first();
                    $discount_amount = round(($total_price * $refer_discount->value / 100), 2);
                }
            }

            $total_price_after_discount = $total_price - $discount_amount;
            $gst_amount = ($total_price_after_discount * $settings->value) / 100;
            $final_amount = $total_price_after_discount + $gst_amount;
            $update_cart = User_carts::with('packagedata')->where('user_id', $user_id)->where('click_type', "buynow")->orderBy('created_at', "desc")->update(['order_id' => $order_id]);

            $amountdetails = array('total_price' => round($total_price, 2), 'gst_percentage' => $settings->value, 'gst_amount' => round($gst_amount, 2), 'final_amount' => round($final_amount, 2), 'discount_amount' => $discount_amount, 'total_price_after_discount' => $total_price_after_discount, 'cart_count' => $cart_count, 'order_id' => $order_id);
            return view('web.services.buynow', compact('amountdetails', 'data', 'languages', 'addonperson', 'state_data', 'city_data', 'phonecode_data', 'type', 'service_category', 'user_list'));
        }
        $amountdetails = [];
        $data = [];

        return view('web.services.buynow', compact('amountdetails', 'data', 'languages', 'state_data', 'city_data', 'phonecode_data', 'user_list'));
    }

    public function addonsport(Request $request)
    {

        if (auth()->user()->is_active_freetrial != "1" && auth()->user()->is_complete_freetrial != "1") {
            return redirect()->back()->withError("Please Activate Free Trial!");
        }
        if ($request->adddon_type == "addon_person") {

            $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
            if (empty($servicepackages_data)) {
                return redirect()->back()->withError("Can not add more person at this time!");
            }
            $pervious_cartdata = User_carts::where('click_type', "buynow")->where('user_id', $request->user_id)->get();
            if (!empty($pervious_cartdata[0])) {
                foreach ($pervious_cartdata as $key => $value) {
                    $itemdata = User_cart_items::where('cart_id', $value->id)->delete();
                }
                $deletecartdata = User_carts::where('click_type', "buynow")->where('user_id', $request->user_id)->delete();
            }
            $input = $request->only('type', 'user_id');
            $input['price'] = $servicepackages_data->price;
            $input['package_id'] = $servicepackages_data->id;
            $input['parent_package_id'] = $request->package_id;
            $input['click_type'] = "buynow";
            $input['type'] = "addon_person";
            $cartdata = User_carts::create($input);

            return redirect('buy');
        } else {
            $package_id = $request->package_id;
            $packagedata = Servicepackages::where('status', '1')->where('parent_id', $package_id)->where('addon_price_type', "sport")->first();
            if (!empty($packagedata)) {
                $user_id = $request->user_id;
                $type = $request->adddon_type;
                $price = $packagedata->price;
                $parent_package_id = $request->package_id;
                $package_id = $packagedata->id;
                $category = Servicecategories::where('status', '1')->get();
                return view('web.services.addon-service-details', compact('category', 'packagedata', 'type', 'price', 'user_id', 'package_id', 'type', 'parent_package_id'));
            } else {
                return redirect()->back()->withError("Can not add more sports at this time!");
            }
        }
    }

    public function addonPerson(Request $request)
    {
        // $existsaddon = Addon_persons::where('user_id',$request->user_id)->where('package_id',$request->package_id)->get();

        if ($request->member_type == "existing") {
            $existing_userdata = User::where("id", $request->existing_userid)->first();
            $input1 = $request->only('order_id', 'addon_type', 'user_id', 'parent_package_id', 'package_id', 'relation', 'cart_id', 'member_type', 'existing_userid');

            $email = $existing_userdata->email;
            $phone = $existing_userdata->phone;
            $is_exist_in_addon = Addon_persons::where('person_email', $email)->orWhere('person_phone', $phone)->where('status', '1')->where('cart_id', null)->first();
            if (!empty($is_exist_in_addon)) {
                $is_exist_addon_email = Addon_persons::where('person_email', $email)->where('status', '1')->where('cart_id', null)->first();
                if (!empty($is_exist_addon_email)) {
                    return response()->json(['statusCode' => 999, 'message' => 'Addon Email already Registered.']);
                } else {
                    return response()->json(['statusCode' => 999, 'message' => 'Addon Mobile already Registered.']);
                }
            }

            $input1['person_first_name'] = $existing_userdata->first_name;
            $input1['person_last_name'] = $existing_userdata->last_name;
            $input1['person_email'] = $existing_userdata->email;
            $input1['person_phone'] = $existing_userdata->phone;
            $input1['gender'] = $existing_userdata->gender;
            $input1['password'] = $existing_userdata->password;
            $input1['dob'] = date("Y-m-d", strtotime($existing_userdata->dob));
        } else {
            $email = $request->person_email;
            $phone = $request->person_phone;

            $input1 = $request->only('order_id', 'addon_type', 'user_id', 'parent_package_id', 'package_id', 'person_first_name', 'person_last_name', 'person_email', 'person_phone', 'gender', 'city', 'state', 'weight', 'weight_type', 'height_type', 'height_feet', 'height_inch', 'language_id', 'relation', 'cart_id', 'member_type');
            $input1['dob'] = date("Y-m-d", strtotime($request->dob));
            $input1['password_text'] = $request->password;
            $input1['password'] = Hash::make($request->password);
            $is_exist_in_addon = Addon_persons::where('person_email', $email)->orWhere('person_phone', $phone)->where('status', '1')->where('cart_id', null)->first();
            if (!empty($is_exist_in_addon)) {
                $is_exist_addon_email = Addon_persons::where('person_email', $email)->where('status', '1')->where('cart_id', null)->first();
                if (!empty($is_exist_addon_email)) {
                    return response()->json(['statusCode' => 999, 'message' => 'Addon Email already Registered.']);
                } else {
                    return response()->json(['statusCode' => 999, 'message' => 'Addon Mobile already Registered.']);
                }
            }

            $is_exist_in_user = User::where('email', $email)->orWhere('phone', $phone)->first();
            if (!empty($is_exist_in_user)) {
                $is_exist_email = User::where('email', $email)->first();
                if (!empty($is_exist_email)) {
                    return response()->json(['statusCode' => 999, 'message' => 'User Email already Registered.']);
                } else {
                    return response()->json(['statusCode' => 999, 'message' => 'User Mobile already Registered.']);
                }
            }
        }

        // $is_exist_in_addon = Addon_persons::where('person_email', $request->person_email)->orWhere('person_email', $request->person_phone)->where('status','1')->where('cart_id',NULL)->first();
        // if (!empty($is_exist_in_addon)) {
        //     $is_exist_addon_email = Addon_persons::where('person_email', $request->person_email)->where('status','1')->where('cart_id',NULL)->first();
        //     if (!empty($is_exist_addon_email)) {
        //         return response()->json(['statusCode' => 999, 'message' => 'Addon Email already Registered.']);
        //     }else{
        //         return response()->json(['statusCode' => 999, 'message' => 'Addon Mobile already Registered.']);
        //     }
        // }

        // $is_exist_in_user = User::where('email', $request->person_email)->orWhere('phone', $request->person_phone)->first();
        // if (!empty($is_exist_in_user)) {
        //     $is_exist_email = User::where('email', $request->person_email)->first();
        //     if (!empty($is_exist_email)) {
        //         return response()->json(['statusCode' => 999, 'message' => 'User Email already Registered.']);
        //     }else{
        //         return response()->json(['statusCode' => 999, 'message' => 'User Mobile already Registered.']);
        //     }
        // }

        $existsaddon = Addon_persons::where('user_id', $request->user_id)->where('package_id', $request->package_id)
            ->where(function ($query) use ($request) {
                $query->where('cart_id', '=', null)
                    ->where('status', '1');
            })->orWhere(function ($query) use ($request) {
                $query->where('cart_id', $request->cart_id)
                    ->where('status', '0');
            })->get();

        // $input1 = $request->only('order_id','addon_type','user_id','parent_package_id','package_id','person_first_name','person_last_name', 'person_email', 'person_phone','gender','city','state','weight','height_feet','height_inch','language_id','relation','height_type','weight_type','cart_id' );

        if (!empty($existsaddon[0])) {
            $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();

            $input1['person_price'] = @$servicepackages_data->price;
            if ($request->type == "sport") {
                $packagedata = Servicepackages::where('id', $request->package_id)->first();
            } else {
                $packagedata = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
                if (empty($packagedata)) {
                    return response()->json(['statusCode' => 999, 'message' => 'Can not add more person at this time!']);
                }
            }

            // $packagedata =  Servicepackages::where('id', $request->package_id)->first();
            $package_adultcount = $packagedata->addon_adult_count;
            $exists_adultcount = $existsaddon->where('addon_type', "adult")->count();
            $package_kidcount = $packagedata->addon_kid_count;
            $exists_kidcount = $existsaddon->where('addon_type', "kid")->count();
            if ($request->addon_type == "adult") {
                if ($exists_adultcount >= $package_adultcount) {
                    if ($request->type == "sport") {
                        $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
                        if (empty($servicepackages_data)) {
                            return response()->json(['statusCode' => 999, 'message' => 'Can not add more person at this time!']);
                        }
                        $input1['person_price'] = @$servicepackages_data->price;
                    } else {
                        $input1['person_price'] = $packagedata->price;
                    }
                } else {
                    $input1['person_price'] = 0;
                }
            }
            if ($request->addon_type == "kid") {
                if ($exists_kidcount >= $package_kidcount) {
                    if ($request->type == "sport") {
                        $servicepackages_data = Servicepackages::where('parent_id', $request->package_id)->where('addon_price_type', "person")->first();
                        if (empty($servicepackages_data)) {
                            return response()->json(['statusCode' => 999, 'message' => 'Can not add more person at this time!']);
                        }
                        $input1['person_price'] = @$servicepackages_data->price;
                    } else {
                        $input1['person_price'] = $packagedata->price;
                    }
                } else {
                    $input1['person_price'] = 0;
                }
            }
        } else {
            $input1['person_price'] = 0;
        }

        $input1['status'] = '0';
        $data = Addon_persons::create($input1);
        if ($data) {
            // $addon_data = Addon_persons::where('user_id',$request->user_id)->where('package_id',$request->package_id)
            //                 ->where(function ($query) use($request) {
            //                     $query->where('status', '1');
            //                 })->orWhere(function($query) use($request){
            //                     $query->where('order_id', $request->order_id)
            //                         ->where('status', '0');
            //                 })->orderBy("created_at","desc")->get();

            $addon_data = Addon_persons::where('cart_id', $request->cart_id)->where('user_id', $request->user_id)->where('package_id', $request->package_id)->orderBy("created_at", "asc")->get();
            return response()->json(['statusCode' => 200, 'message' => 'Added Successfully.', 'data' => $addon_data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Data Not Added Successfully!']);
    }
    public function removePerson(Request $request)
    {
        $data = Addon_persons::where('id', $request->id)->where('user_id', $request->user_id)->first();
        $cart_id = $data->cart_id;
        if (!empty($data)) {
            $data->delete();

            $data1 = Addon_persons::where('cart_id', $cart_id)->where('user_id', auth()->user()->id)->get();
            $exists_adultcount = $data1->where('addon_type', "adult")->count();
            $exists_kidcount = $data1->where('addon_type', "kid")->count();
            $adult_count = 0;
            $kid_count = 0;
            foreach ($data1 as $key => $value) {

                $packagedata = Servicepackages::where('id', $value->package_id)->first();
                $package_adultcount = $packagedata->addon_adult_count;
                $package_kidcount = $packagedata->addon_kid_count;

                if ($value->addon_type == "adult") {
                    if ($adult_count < $package_adultcount) {
                        $input1['person_price'] = 0;
                    } else if ($exists_adultcount >= $package_adultcount) {
                        $servicepackages_data = Servicepackages::where('parent_id', $value->package_id)->where('addon_price_type', "person")->first();
                        $input1['person_price'] = $servicepackages_data->price;
                    }
                    $adult_count++;
                }
                if ($value->addon_type == "kid") {
                    if ($kid_count < $package_kidcount) {
                        $input1['person_price'] = 0;
                    } else if ($exists_kidcount >= $package_kidcount) {
                        $servicepackages_data = Servicepackages::where('parent_id', $value->package_id)->where('addon_price_type', "person")->first();
                        $input1['person_price'] = $servicepackages_data->price;
                    }
                    $kid_count++;
                }

                $value->update($input1);
            }

            $addon_data = Addon_persons::where('cart_id', $request->cart_id)->where('user_id', $request->user_id)->where('package_id', $request->package_id)->orderBy("created_at", "asc")->get();

            return response()->json(['statusCode' => 200, 'message' => 'Person removed successfully.', 'data' => $addon_data]);
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        }
    }

    public function orderPlace(Request $request)
    {
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
        $packagedata = Servicepackages::where('id', @$request->store[0]['package_id'])->first();
        $input = $request->only('user_id', 'first_name', 'last_name', 'package_id', 'parent_package_id', 'email', 'phone', 'total_price', 'gst_percentage', 'gst_amount', 'final_amount', 'discount_amount', 'click_type');
        // $input = $request->only('user_id','first_name','last_name', 'email', 'phone', 'package_id', 'total_price', 'gst_percentage', 'gst_amount', 'final_amount','discount_amount');
        $input['order_id'] = $request->order_id;
        $input['status'] = "1";
        $input['name'] = @$request->first_name . ' ' . @$request->last_name;
        $input['type'] = $request->type;
        $input['payment_status'] = "pending";
        $input['start_date'] = date('Y-m-d H:i:s');
        $input['package_id'] = @$request->store[0]['package_id'];
        // $input['end_date'] = date('Y-m-d H:i:s', strtotime('+'.@$packagedata->package_duration.' years'));
        $data = User_orders::create($input);
        if ($data) {
            $store = $request->store;
            if (!empty($store[0])) {
                foreach ($store as $key3 => $value3) {
                    if ($value3['type'] == "sport" || $value3['type'] == "addon_sport") {
                        $cartdata = User_carts::with('packagedata')->where('user_id', $request->user_id)->where('package_id', $value3['package_id'])->get();
                        foreach ($cartdata as $key2 => $value2) {
                            // $categoryids = $request->category_data;
                            $categoryids = User_cart_items::where('cart_id', $value2->id)->orderBy('category_year_srno', 'asc')->get();
                            foreach ($categoryids as $key => $value) {
                                $input1['user_id'] = $request->user_id;
                                $input1['order_primary_id'] = $data->id;
                                $input1['order_id'] = $data->order_id;
                                $input1['package_id'] = $value2->package_id;
                                $input1['parent_package_id'] = $value2->parent_package_id;
                                $input1['category_id'] = $value['category_id'];
                                $input1['category_year_srno'] = $value['category_year_srno'];
                                $input1['sport_price'] = $value['sport_price'];
                                $key1 = $key + 1;

                                if (@$packagedata->duration_type == "month") {
                                    $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($key);
                                    $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addMonths($packagedata->package_duration);
                                } else {
                                    $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                                    $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                                }

                                $user = User::where('id', $request->user_id)->first();
                                if ($user->is_active_freetrial == 1 && $user->is_complete_freetrial == 0 && $user->freetrial_duration != NULL) {
                                    $remaindate = Carbon::parse($user->freetrial_duration);
                                    $now = Carbon::now();

                                    $diff_data = $remaindate->diffInDays($now);

                                    $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', @$input1['end_date'])->addDays($diff_data);
                                }

                                // $input1['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key);
                                // $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->addYear($key1);
                                // $input1['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $orderdata->created_at)->addYear($key1)->subDays(1);
                                if ($value['value'] == 1) {
                                    $input1['status'] = '1';
                                } else {
                                    $input1['status'] = '0';
                                }
                                $data1 = User_order_items::create($input1);
                            }
                        }
                    }
                    // else{
                    //     $input1 = $request->only('user_id','package_id','person_first_name','person_last_name', 'person_email', 'person_phone', 'dob', 'gender','city','state','weight','height_feet','height_inch','language_id','relation' );
                    //     $input1['order_id'] = $data->order_id;
                    //     $addon_persons =  Addon_persons::create($input1);
                    // }
                }
            }

            $payment_link = route("razorpay-payment", array('orderid' => $data->order_id));
            // return response()->json(['statusCode' => 200, 'message' => 'Payment Link.','data' => $payment_link]);
            return redirect($payment_link);
        }
        return redirect()->back()->withError("Please, Try Again!");
    }

    public function myPlans()
    {
        $result = $this->getUserPackage();
        return view('web.my-plans', compact('result'));
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
        $check = array('user_id' => $user_id, 'email' => $email);
        $data = User_newsletters::updateOrCreate($check, $input);
        if (!empty($data)) {
            return redirect()->back()->withSuccess("Data Submit Successfully.");
        } else {
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
            $day_arr = [$nextday, $second_nextday, $third_nextday];
            $day_name = [$nextday_name, $second_nextday_name, $third_nextday_name];
        } else {
            $day_arr = [$today, $nextday, $second_nextday];
            $day_name = [$today_name, $nextday_name, $second_nextday_name];
        }
        // $day_arr = [$today,$nextday,$second_nextday];
        // $day_name = [$today_name,$nextday_name,$second_nextday_name];
        // $data =  Live_videos::where('status','1')->where('end_date_time','>=',$currentdate_time)->whereBetween('start_date_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $data = [];
        $user = auth()->user();
        $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->count();

        if ($user->is_active_freetrial == '0' && $order_data < 1) {
            return view('web.livevideo.live-videos', compact('day_name', 'data'));
        }
        foreach ($day_arr as $key1 => $value1) {
            if ($user->is_active_freetrial == '1' && $user->is_complete_freetrial == '0') {
                $item_data = Live_videos::where('is_allow_free_trial', '1')->where('status', '1')->where('end_date_time', '>=', $currentdate_time)->whereDate('start_date_time', $value1)->get();
            } else {
                $item_data = Live_videos::where('status', '1')->where('end_date_time', '>=', $currentdate_time)->whereDate('start_date_time', $value1)->get();
            }
            if (!empty($item_data[0])) {
                foreach ($item_data as $key => $value) {
                    if ($value->start_date_time <= $currentdate_time) {
                        $value->is_play = "1";
                    } else {
                        $value->is_play = "0";
                    }
                    $date = Carbon::parse($value->start_date_time);
                    $now = Carbon::now();
                    $value->difference = $date->diffInSeconds($now);
                    $value->dayname = $date->format('l');
                    $value->start_date_time = date("H:i:s", strtotime($value->start_date_time));
                    $value->end_date_time = date("H:i:s", strtotime($value->end_date_time));
                }
            }
            $data[0][$key1] = $item_data;
            // $data[0][strval($value1->format("l"))] = $item_data;
        }
        if (!empty($data[0])) {
            // echo "<PRE>"; print_r([$data,$day_name]);die;
            return view('web.livevideo.live-videos', compact('day_name', 'data'));
        }
    }
    public function liveSessionDetails(Request $request, $id)
    {
        $currentdate_time = date("Y-m-d H:i:s");
        // $data =  Live_videos::where('id', $id)->first();
        $data = Live_videos::where('id', $id)->where('status', '1')->where('end_date_time', '>=', $currentdate_time)->first();
        if (!empty($data)) {
            $user = auth()->user();
            if ($data->start_date_time <= $currentdate_time) {

                $data->is_play = "1";
                if ($user->is_active_freetrial == '1' && $user->is_complete_freetrial == '1') {
                    $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->first();
                    if (!empty($order_data)) {
                        $get_enddate_date = User_order_items::where('order_primary_id', $order_data->id)->orderBy("category_year_srno", "desc")->get();
                        if (date('Y-m-d', strtotime($get_enddate_date[0]['end_date'])) < date('Y-m-d')) {
                            $data->is_play = "0";
                        }
                    } else {
                        $data->is_play = "0";
                    }
                }





                // print_r($data->is_play);exit;
            } else {
                $data->is_play = "0";
            }

            // if ($user->is_active_freetrial == '1' && $user->is_complete_freetrial == '0') {
            //     $data->is_play = "1";
            // }
            $date = Carbon::parse($data->start_date_time);
            $now = Carbon::now();
            $data->difference = $date->diffInSeconds($now);
            $data->dayname = $date->format('l');
            $data->start_date = date("l, M d, Y", strtotime($data->start_date_time));
            $data->start_date_time = date("H:i:s", strtotime($data->start_date_time));
            $data->end_date_time = date("H:i:s", strtotime($data->end_date_time));

            $getpackage_data = $this->getUserPackage();

            if (!empty($getpackage_data[0])) {
                $data->package_name = $getpackage_data[0]['package'][0]['package_data']['title'];
                $data->is_purchase = '1';
            } elseif ($user->is_active_freetrial == '1') {
                $data->package_name = "Free Trial";
                $data->is_purchase = '0';
            } else {
                $data->package_name = "No Plan Active";
                $data->is_purchase = '0';
            }


            // $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->whereDate('start_date', '<=', date('Y-m-d'))->count();
            // if (!empty($order_data)) {
            //     if ($order_data >= 1) {
            //         $user->is_purchase = '1';
            //     } else {
            //         $user->is_purchase = '0';
            //     }
            // } else {
            //     $user->is_purchase = '0';
            // }




            return view('web.livevideo.live-video-details', compact('data', 'user'));
        }
        return redirect()->route("live-sessions")->withError("Video is no longer available!");
    }
    public function liveVideoUser(Request $request)
    {
        $video_id = $request->video_id;
        $user_id = auth()->user()->id;
        $data = Live_videos::where('id', $video_id)->first();
        if (!empty($data)) {
            $data->view_count = $data->view_count + 1;
            $data->save();
            // $input = $request->only('video_id','user_id');
            $input['video_id'] = $video_id;
            $input['user_id'] = $user_id;
            $check = array('user_id' => $user_id, 'video_id' => $video_id);
            $data1 = Live_video_users::updateOrCreate($check, $input);
            return response()->json(['statusCode' => 200, 'message' => ' Added successfully.', 'data' => $data1]);
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
        }
    }
    public function sportsCurriculum()
    {
        $data = Sports_curriculums::where('status', '1')->get();
        foreach ($data as $key => $value) {
            if ($value->type == "sports") {
                $category = Servicecategories::where('id', $value->category)->first();
                $value->category_title = $category->title;
            } else {
                if ($value->category == "sporty_kid_7") {
                    $value->category_title = "Sports Kid (4 to 7)";
                } else {
                    $value->category_title = "Sports Kid (7 to 9)";
                }
            }
        }
        return view('web.sports-curriculum', compact('data'));
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
            'password' => 'required|confirmed|min:8',
        ]);
        $user = Auth::user();
        $check = Hash::check($request->current_password, $user->password);
        // print_r($check);exit;
        // if ($check == 1) {
        //      return redirect()->back()->withError('The new password does not same as old password.');
        // }
        if ($check) {
            if ($request->current_password != $request->password) {
                $input['password_text'] = $request->password;
                $input['password'] = Hash::make($request->password);
                $user = auth()->user()->update($input);
                if ($user) {
                    $user_data = User::where('email', $request->email)->first();
                    Auth::logout();
                    return redirect(route('login'))->withSuccess('Password Update Successfully. Please Login Again');
                } else {
                    return redirect()->back()->withError('Updation Failed!');
                }
            } else {
                return redirect()->back()->withError('The new password does not same as old password!');
            }
        } else {
            return redirect()->back()->withError('The current password does not match.');
        }
    }

    // public function getUserActivePlan(){
    //     $user = Auth::user();
    //     $order_data =  User_orders::where('user_id',$user->id)->where('payment_status',"complete")->orderBy('created_at','desc')->get();
    //     $result=array();
    //     if (!empty($order_data[0])) {
    //         foreach ($order_data as $key => $value) {
    //             $result[$key]=$value;
    //             $order_items = User_order_items::select('package_id')->where('order_primary_id',$value->id)->distinct()->get();
    //             $package=array();

    //             if (!empty($order_items[0])) {
    //                 foreach ($order_items as $key1 => $value1) {
    //                     $index = $value1->package_id;
    //                     $order_package_items = User_order_items::where('order_primary_id',$value->id)->where('package_id',$index)->orderBy("category_year_srno","desc")->get();
    //                     $package_detail = Servicepackages::where('id',$value1->package_id)->first();

    //                     $addon_package_detail = Servicepackages::where('parent_id',$value1->package_id)->first();
    //                     $value1->package_data =  $package_detail;
    //                     if (!empty($addon_package_detail)) {
    //                         $value1->addon_package_data =  $addon_package_detail;
    //                         if ($value1->package_data->addon == '1') {
    //                             if ($addon_package_detail->addon_price_type == "sport") {
    //                                 $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
    //                                 $value1->addon_package_data->addon_price_person = 0;
    //                             }else{
    //                                 $value1->addon_package_data->addon_price_sport = 0;
    //                                 $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
    //                             }
    //                         }
    //                     }else{
    //                         $value1->addon_package_data =  NULL;
    //                     }
    //                     $package[$key1]=$value1;
    //                     $value1->expiry_date =  @$order_package_items[0]['end_date'];

    //                     $items=array();
    //                     foreach($order_package_items as $key2=>$value2)
    //                     {
    //                         if (date("Y-m-d",strtotime($value2->start_date)) <= date('Y-m-d') && date("Y-m-d",strtotime($value2->end_date) >= date('Y-m-d'))) {
    //                             $items[$key2]=$value2;
    //                         }
    //                     }
    //                     $package[$key1]['item']=$items;

    //                     $addon_personData = Addon_persons::where('order_id',$value->order_id)->where('package_id',$index)->get();

    //                     $package[$key1]['addon_person_data']=$addon_personData;

    //                     $category_detail = array();
    //                     foreach ($package[$key1]['item'] as $key3 => $value3) {
    //                         $category_detail = Servicecategories::where('id',$value3->category_id)->first();
    //                         $value3->category_detail =  $category_detail;
    //                     }
    //                 }
    //             }else{
    //                 if ($value->type == "addon_person" || $value->type == "addon_sport") {
    //                     $package_detail = Servicepackages::where('id',$value->package_id)->first();
    //                     $package[0]['package_data']=$package_detail;
    //                 }
    //             }

    //              $result[$key]['package']=$package;
    //         }
    //     }

    //     return $result;
    // }

    public function getUserPackage()
    {
        $user = Auth::user();
        $order_data = User_orders::where('user_id', $user->id)->where('payment_status', "complete")->orderBy('created_at', 'desc')->get();
        $result = array();
        if (!empty($order_data[0])) {
            foreach ($order_data as $key => $value) {
                $result[$key] = $value;
                $order_items = User_order_items::select('package_id')->where('order_primary_id', $value->id)->distinct()->get();
                $package = array();

                if (!empty($order_items[0])) {
                    foreach ($order_items as $key1 => $value1) {
                        $index = $value1->package_id;
                        $order_package_items = User_order_items::where('order_primary_id', $value->id)->where('package_id', $index)->orderBy("category_year_srno", "desc")->get();
                        $get_start_date = User_order_items::where('order_primary_id', $value->id)->where('package_id', $index)->orderBy("category_year_srno", "asc")->get();

                        @$package_detail = Servicepackages::where('id', $value1->package_id)->first();

                        @$addon_package_detail = Servicepackages::where('parent_id', $value1->package_id)->first();
                        $value1->package_data = $package_detail;
                        if (!empty($addon_package_detail)) {
                            $value1->addon_package_data = $addon_package_detail;
                            if ($value1->package_data->addon == '1') {
                                if ($addon_package_detail->addon_price_type == "sport") {
                                    $value1->addon_package_data->addon_price_sport = $addon_package_detail->price;
                                    $value1->addon_package_data->addon_price_person = 0;
                                } else {
                                    $value1->addon_package_data->addon_price_sport = 0;
                                    $value1->addon_package_data->addon_price_person = $addon_package_detail->price;
                                }
                            }
                        } else {
                            $value1->addon_package_data = null;
                        }
                        $package[$key1] = $value1;
                        $value1->expiry_date = @$order_package_items[0]['end_date'];
                        $value1->start_date = @$get_start_date[0]['start_date'];

                        $items = array();
                        foreach ($order_package_items as $key2 => $value2) {
                            $items[$key2] = $value2;
                        }
                        $package[$key1]['item'] = $items;

                        $addon_personData = Addon_persons::where('order_id', $value->order_id)->where('package_id', $index)->get();

                        $package[$key1]['addon_person_data'] = $addon_personData;

                        $category_detail = array();
                        foreach ($package[$key1]['item'] as $key3 => $value3) {
                            $category_detail = Servicecategories::where('id', $value3->category_id)->first();
                            $value3->category_detail = $category_detail;
                        }
                    }
                } else {
                    if ($value->type == "addon_person" || $value->type == "addon_sport") {
                        $package_detail = Servicepackages::where('id', $value->package_id)->first();
                        $package[0]['package_data'] = $package_detail;
                    }
                }

                $result[$key]['package'] = $package;
            }
        }

        return $result;
    }
    public function paymentResponse()
    {
        return view('payment-response');
    }
    //==========================

    public function newsFeeds()
    {
        $blogs = News_feeds::where('status', '1')->orderBy('created_at', "desc")->get();
        foreach ($blogs as $key => $value) {
            $likedata = News_feed_likes::where('news_feed_id', $value->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($likedata)) {
                $value->is_like = 1;
            } else {
                $value->is_like = 0;
            }
        }
        return view('web.news-feed.index', compact('blogs'));
    }
    public function newsFeedDetails($slug)
    {
        $blogdetail = News_feeds::where('slug', $slug)->first();
        if (!empty($blogdetail)) {
            // $shareBlog = \Share::page(
            //     url('nutritionblog-details', ['slug' => $slug]),
            //     $blogdetail->title,
            // )->facebook()->twitter()->linkedin()->whatsapp();
            // ->telegram()
            // ->reddit();
            $view_count = $blogdetail->view_count + 1;
            $blogdetail->update(['view_count' => $view_count]);
            $likedata = News_feed_likes::where('news_feed_id', $blogdetail->id)->where('user_id', auth()->user()->id)->first();
            if (!empty($likedata)) {
                $blogdetail->is_like = 1;
            } else {
                $blogdetail->is_like = 0;
            }
            $commentlist = News_feed_comments::with('userdata')->where('news_feed_id', $blogdetail->id)->orderBy('id', 'desc')->get();
            foreach ($commentlist as $key => $value) {
                $date = Carbon::parse($value->created_at);
                $now = Carbon::now();
                $value->timediff = $date->diff($now);
                if ($value->timediff->y > 0) {
                    $value->timediff = $date->diff($now)->format('%y year');
                } elseif ($value->timediff->m > 0) {
                    $value->timediff = $date->diff($now)->format('%m month');
                } elseif ($value->timediff->d > 0) {
                    $value->timediff = $date->diff($now)->format('%d days');
                } elseif ($value->timediff->h > 0) {
                    $value->timediff = $date->diff($now)->format('%h hour');
                } elseif ($value->timediff->i > 0) {
                    $value->timediff = $date->diff($now)->format('%i minute');
                } else {
                    $value->timediff = $date->diff($now)->format('%s second');
                }
            }
            // print_r($commentlist);exit;
            return view('web.news-feed.details', compact('blogdetail', 'commentlist'));
        }
        return redirect()->back()->withError('No Data Found!');
    }

    public function newsFeedsLike(Request $request)
    {
        $data = News_feeds::where('id', $request->news_feed_id)->first();
        if (!empty($data)) {
            $likedata = News_feed_likes::where('news_feed_id', $request->news_feed_id)->where('user_id', auth()->user()->id)->first();
            if (empty($likedata)) {
                $input = $request->only('news_feed_id');
                $input['user_id'] = auth()->user()->id;
                $data1 = News_feed_likes::create($input);
                if (!empty($data1)) {
                    $likecount = $data->like_count + 1;
                    $data->update(['like_count' => $likecount]);
                    return response()->json(['statusCode' => 200, 'message' => 'Liked.', 'data' => $data1]);
                }
                return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
            } else {
                $likedata->delete();
                $likecount = $data->like_count - 1;
                $data->update(['like_count' => $likecount]);
                return response()->json(['statusCode' => 300, 'message' => 'Removed From Liked.', 'data' => $likedata]);
            }
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Nutrition blog Not Found.']);
        }
    }

    public function addNewsFeedComment(Request $request)
    {
        $input = $request->only('news_feed_id', 'message');
        $input['user_id'] = auth()->user()->id;
        $input['status'] = '1';
        $data = News_feed_comments::create($input);
        if (!empty($data)) {
            // $data =  Nutrition_blog_comments::with('userdata','recipedata.recipe_categorydata')->where('id',$data->id)->first();
            return response()->json(['statusCode' => 200, 'message' => 'Comment Added Successfully.', 'data' => $data]);
        }
        return response()->json(['statusCode' => 999, 'message' => 'Not Added.']);
    }

    public function commentEdit(Request $request)
    {

        $user_id = auth()->user()->id;
        if ($request->type == "newsfeed") {
            $data = News_feed_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
            // if (!empty($data)) {
            //     return response()->json(['statusCode' => 200, 'message' => 'Update Successfully.', 'data' => $data]);
            // }else{
            //     return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);        
            // }
            if (!empty($data)) {
                $data = News_feed_comments::where('id', $request->comment_id)->where('user_id', $user_id)->update(['message' => $request->message]);
                return redirect()->back()->withSuccess("Data Submit Successfully.");
            } else {
                return redirect()->back()->withError("Please, Try Again!");
            }
        } elseif ($request->type == "blog") {
            $data = Nutrition_blog_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
            // if (!empty($data)) {
            //     return response()->json(['statusCode' => 200, 'message' => 'Update Successfully.', 'data' => $data]);
            // } else {
            //     return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            // }

            if (!empty($data)) {
                $data = Nutrition_blog_comments::where('id', $request->comment_id)->where('user_id', $user_id)->update(['message' => $request->message]);
                return redirect()->back()->withSuccess("Data Submit Successfully.");
            } else {
                return redirect()->back()->withError("Please, Try Again!");
            }
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Invalid Type.']);
        }
    }

    public function commentDelete(Request $request)
    {

        $user_id = auth()->user()->id;
        if ($request->type == "newsfeed") {
            $data = News_feed_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
            if (!empty($data)) {
                $data->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Remove Successfully.', 'data' => $data]);
            } else {
                return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            }
        } elseif ($request->type == "blog") {
            $data = Nutrition_blog_comments::where('id', $request->comment_id)->where('user_id', $user_id)->first();
            if (!empty($data)) {
                $data->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Remove Successfully.', 'data' => $data]);
            } else {
                return response()->json(['statusCode' => 999, 'message' => 'Data Not Found.']);
            }
        } else {
            return response()->json(['statusCode' => 999, 'message' => 'Invalid Type.']);
        }
    }

    public function notificationDelete(Request $request)
    {
        if ($request->type == "all") {
            $data = Notifications::where('user_id', auth()->user()->id)->get();
            if (!empty($data[0])) {
                $data = Notifications::where('user_id', auth()->user()->id)->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Notification Remove Successfully.', 'data' => []]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Notification not found.']);
        } else {
            $data = Notifications::where('id', $request->notification_id)->where('user_id', auth()->user()->id)->first();
            if (!empty($data)) {
                $data = Notifications::where('id', $request->notification_id)->where('user_id', auth()->user()->id)->delete();
                return response()->json(['statusCode' => 200, 'message' => 'Notification Remove Successfully.', 'data' => $data]);
            }
            return response()->json(['statusCode' => 999, 'message' => 'Notification not found.']);
        }
    }
}
