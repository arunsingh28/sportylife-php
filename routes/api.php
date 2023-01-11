<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('checkSocialSignup', [ApiController::class, 'checkSocialSignup']);
Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('forgotPassword', [ApiController::class, 'forgotPassword']);
Route::post('verifyOtp', [ApiController::class, 'verifyOtp']);
Route::post('changePassword', [ApiController::class, 'changePassword']);
Route::get('languageList', [ApiController::class, 'languageList']);
Route::post('getCityState', [ApiController::class, 'getCityState']); 
//razorpay payment start
Route::any('razorpay-callback', [ApiController::class, 'razorpayPaymentcallback']);
Route::any('razorpay-callback-ios', [ApiController::class, 'razorpayPaymentcallbackIOS']);
Route::any('razorpay-payment-data', [ApiController::class, 'razorpayPaymenturl'])->name('razorpay-payment-data');
//razorpay payment end

Route::post('pages', [ApiController::class, 'pages']);
//cronjoburl
Route::get('checkFreetrialExpiry', [ApiController::class, 'checkFreetrialExpiry']);
Route::get('sendLiveSessionNotification', [ApiController::class, 'sendLiveSessionNotification']);
// Route::get('sendTimelyLiveSessionNotificationForAdultTest', [ApiController::class, 'sendTimelyLiveSessionNotificationForAdultTest']);
// Route::get('sendWaterIntakeNotification', [ApiController::class, 'sendWaterIntakeNotification']);
// Route::get('sendTimelyLiveSessionNotificationForAdult', [ApiController::class, 'sendTimelyLiveSessionNotificationForAdult']);
// Route::get('sendTimelyLiveSessionNotificationForKid', [ApiController::class, 'sendTimelyLiveSessionNotificationForKid']);
//cronjoburl

Route::get('updatePackagePayment', [ApiController::class, 'updatePackagePayment']);


Route::get('unauthorized', function () {
    return response()->json(['statusCode' => 401, 'message' => 'Unauthorized.']);
})->name('api.unauthorized');
Route::middleware('auth:api')->group( function () {
    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('home', [ApiController::class, 'home']);
    Route::get('userDetails', [ApiController::class, 'userDetails']);
    Route::post('profileUpdate', [ApiController::class, 'profileUpdate']);
    Route::post('contactUs', [ApiController::class, 'contactUs']);
   
    Route::get('inviteHistory', [ApiController::class, 'inviteHistory']);
    Route::get('faqList', [ApiController::class, 'faqList']);
    Route::get('notificationList', [ApiController::class, 'notificationList']);
    Route::post('removeNotification', [ApiController::class, 'removeNotification']);
    // workoutVideos start 
    Route::get('workoutVideos', [ApiController::class, 'workoutVideos']);
    Route::get('getRecordedVideo', [ApiController::class, 'getRecordedVideo']);
    // workoutVideos end 
    // services start 
    Route::get('categoryList', [ApiController::class, 'categoryList']);
    Route::get('serviceCategoryList', [ApiController::class, 'serviceCategoryList']);
    Route::get('servicePackageList', [ApiController::class, 'servicePackageList']);
    Route::get('servicePackageListIOS', [ApiController::class, 'servicePackageListIOS']);
    Route::post('orderPlaceIOS', [ApiController::class, 'orderPlaceIOS']);
    Route::post('servicePackageDetail', [ApiController::class, 'servicePackageDetail']);
    Route::post('addtoCart', [ApiController::class, 'addtoCart']);
    Route::post('freeTrial', [ApiController::class, 'freeTrial']);

    Route::post('buynow', [ApiController::class, 'buynow']);
    Route::get('userCartList', [ApiController::class, 'userCartList']);
    Route::post('removefromCart', [ApiController::class, 'removefromCart']);
    Route::post('addSport', [ApiController::class, 'addSport']);
    Route::post('addonPerson', [ApiController::class, 'addonPerson']);
    Route::post('orderPlace', [ApiController::class, 'orderPlace']);
    Route::post('removePerson', [ApiController::class, 'removePerson']);
    Route::post('getCartEmpty', [ApiController::class, 'getCartEmpty']);
    // services end
    // nutrition start
    Route::get('nutritionCategoryList', [ApiController::class, 'nutritionCategoryList']);
    Route::post('nutritionRecipeList', [ApiController::class, 'nutritionRecipeList']);
    Route::post('nutritionRecipeListbyCategory', [ApiController::class, 'nutritionRecipeListbyCategory']);
    Route::post('nutritionRecipeDetails', [ApiController::class, 'nutritionRecipeDetails']);
    Route::post('addRemoveDiary', [ApiController::class, 'addRemoveDiary']);
    Route::post('addRecipeComment', [ApiController::class, 'addRecipeComment']);
    Route::post('recipeCommentList', [ApiController::class, 'recipeCommentList']);
    // Route::post('removeFromDiary', [ApiController::class, 'removeFromDiary']);
    // Route::post('likeRecipe', [ApiController::class, 'likeRecipe']);
    Route::post('shareRecipe', [ApiController::class, 'shareRecipe']);
    Route::get('nutritionBlogsList', [ApiController::class, 'nutritionBlogsList']);
    Route::post('nutritionBlogsDetails', [ApiController::class, 'nutritionBlogsDetails']);
    Route::post('likeNutritionBlog', [ApiController::class, 'likeNutritionBlog']);
    Route::post('shareNutritionBlog', [ApiController::class, 'shareNutritionBlog']);
    Route::post('addNutritionBlogComment', [ApiController::class, 'addNutritionBlogComment']);
    Route::post('nutritionBlogCommentList', [ApiController::class, 'nutritionBlogCommentList']);
    Route::get('dietChart', [ApiController::class, 'dietChart']);
    Route::get('mealsCategoryList', [ApiController::class, 'mealsCategoryList']);
    Route::post('mealsList', [ApiController::class, 'mealsList']);
    Route::post('mealsDetails', [ApiController::class, 'mealsDetails']);
    Route::post('mealsCompleted', [ApiController::class, 'mealsCompleted']);
    Route::get('mealsHistory', [ApiController::class, 'mealsHistory']);
    Route::get('myDiary', [ApiController::class, 'myDiary']);
    // nutrition end
    Route::get('frc', [ApiController::class, 'frc']);
    Route::post('userWaterLevel', [ApiController::class, 'userWaterLevel']);
    Route::get('liveVideo', [ApiController::class, 'liveVideo']);
    Route::post('liveVideoDetails', [ApiController::class, 'liveVideoDetails']);
    Route::post('liveVideoUser', [ApiController::class, 'liveVideoUser']); 
    Route::post('search', [ApiController::class, 'search']); 
    Route::post('clearSerchHistory', [ApiController::class, 'clearSerchHistory']); 
    
    Route::get('liveVideoTest', [ApiController::class, 'liveVideoTest']); 
    Route::post('updatePassword', [ApiController::class, 'updatePassword']); 
    Route::get('sportsCurriculum', [ApiController::class, 'sportsCurriculum']); 
    Route::post('searchUser', [ApiController::class, 'searchUser']); 
    Route::get('newsFeed', [ApiController::class, 'newsFeed']); 
    Route::post('likeNewsFeed', [ApiController::class, 'likeNewsFeed']); 
    Route::post('addNewsFeedComment', [ApiController::class, 'addNewsFeedComment']);
    Route::post('newsFeedCommentList', [ApiController::class, 'newsFeedCommentList']);
    Route::post('newsFeedDetails', [ApiController::class, 'newsFeedDetails']);
    Route::post('faqUpdateResponse', [ApiController::class, 'faqUpdateResponse']);
    
    Route::post('commentEdit', [ApiController::class, 'commentEdit']);
    Route::post('commentDelete', [ApiController::class, 'commentDelete']);
    Route::post('deleteUser', [ApiController::class, 'deleteUser']);
    

    
});