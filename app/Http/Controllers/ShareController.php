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
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use PDF;
use Session;
use URL;

class ShareController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
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
            $user_id= auth()->user()->id ?? '1';
            $likedata = Nutrition_blog_likes::where('blog_id', $blogdetail->id)->where('user_id', $user_id)->first();
            if (!empty($likedata)) {
                $blogdetail->is_like = 1;
            } else {
                $blogdetail->is_like = 0;
            }
            $commentlist = Nutrition_blog_comments::with('userdata')->where('blog_id', $blogdetail->id)->orderBy('id', 'desc')->get();
            // $commentlist =  Nutrition_blog_comments::with('userdata')->where('blog_id', $blogdetail->id)->orderBy('id','desc')->take(2)->get();
            foreach ($commentlist as $key => $value) {
                $date = Carbon::parse($value->created_at);
                $now = Carbon::now();
                $value->timediff = $date->diff($now);
                
                if ($value->timediff->y > 0) {
                    $value->timediff = $date->diff($now)->format('%y year');
                }elseif ($value->timediff->m > 0) {
                    $value->timediff = $date->diff($now)->format('%m month');
                }elseif ($value->timediff->d > 0) {
                    $value->timediff = $date->diff($now)->format('%d days');
                }elseif ($value->timediff->h > 0) {
                    $value->timediff = $date->diff($now)->format('%h hour');
                }elseif ($value->timediff->i > 0) {
                    $value->timediff = $date->diff($now)->format('%i minute');
                }else{
                    $value->timediff = $date->diff($now)->format('%s second');
                }
            }
            return view('web.nutritions.nutritionblog-details', compact('blogdetail', 'commentlist', 'shareBlog'));
        }
        return redirect()->back()->withError('No Data Found!');
    }

    public function recipeDetails()
    {
        $url = URL::full();
        $explode = explode("?id=", $url);
        $id = $explode[1];
        $user_id=auth()->user()->id ?? '1';
        $recipedata = Nutrition_recipes::where('id', $id)->first();
        if (!empty($recipedata)) {
            $shareRecipe = \Share::page(
                url('recipe-details/?id=' . $id),
                $recipedata->title,
            )->facebook()->twitter()->linkedin()->whatsapp();
            $viewcount = $recipedata->view_count + 1;
            $updateviewcount = Nutrition_recipes::where('id', $recipedata->id)->update(['view_count' => $viewcount]);
            $recipedata = Nutrition_recipes::where('id', $recipedata->id)->first();
            $likedata = Recipe_likes::where('recipe_id', $recipedata->id)->where('user_id', $user_id)->first();
            if (!empty($likedata)) {
                $recipedata->is_like = 1;
            } else {
                $recipedata->is_like = 0;
            }
            $is_in_diary = User_diaries::where('recipe_id', $recipedata->id)->where('user_id', $user_id)->first();
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
}