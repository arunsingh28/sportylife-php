<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\RazorPayController;
use App\Models\Settings;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'loginpage'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('signup', [LoginController::class, 'signuppage'])->name('signup');
Route::post('signup', [LoginController::class, 'signup']);
Route::get('verify-otp/{email}', [LoginController::class, 'verifyOtpPage'])->name('verify-otp');
Route::post('verify-otp', [LoginController::class, 'verifyOtp']);
Route::get('forgot-password', [LoginController::class, 'forgotPasswordPage'])->name('forgot-password');
Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
Route::get('change-password/{email}', [LoginController::class, 'changePasswordPage'])->name('change-password');
Route::post('change-password', [LoginController::class, 'changePassword']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('getUserAge', [LoginController::class, 'getUserAge']);
Route::get('checkuserlogin', [HomeController::class, 'checkuserlogin']);

Route::get('razorpay-payment', [ApiController::class, 'razorpayPaymentPage'])->name("razorpay-payment");
Route::post('razorpay-payment', [ApiController::class, 'razorpayPayment'])->name('razorpay.payment.razorpayPayment');
Route::get('payment-response', [HomeController::class, 'paymentResponse']);

Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider'])->name('auth.provider');
Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('auth.callback');
// Route::post('/sessiondata', [HomeController::class, 'sessiondata']);
Route::get('generate-pdf', [ApiController::class, 'generatePDF'])->name('generate-pdf');

Route::get('terms-conditions', function () {
    $data = Settings::where('type', "terms_conditions_content")->first();
    return view('web.terms-conditions', compact('data'));
});
Route::get('privacy-policy', function () {
    $data = Settings::where('type', "privacy_policy_content")->first();
    return view('web.privacy-policy', compact('data'));
});
Route::get('support', function () {
    return view('web.support');
});

Route::get('refund-cancellation ', function () {
    return view('web.refund_cancelation');
});
Route::get('shipping-delivery', function () {
    return view('web.shipping_delivery');
});
Route::get('nutritionblog-details', [ShareController::class, 'nutritionBlogDetails']);
Route::get('recipe-details', [ShareController::class, 'recipeDetails']);

Route::get('razorpay', [RazorPayController::class, 'paymentPage'])->name("razorpay-view");
Route::get('razorpay-payment-data', [RazorPayController::class, 'paymentUrl'])->name("razorpay-payment-url");
Route::post('razorpay', [RazorPayController::class, 'createPayment'])->name('razorpay.createPayment');
Route::any('razorpay-callback', [RazorPayController::class, 'razorpayPaymentcallback'])->name('razorpay.callback');

Auth::routes();
Route::middleware(['checkUser'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('index');
    Route::get('/home', [HomeController::class, 'index']);
    // Route::post('/sessiondatadestroy', [HomeController::class, 'sessiondatadestroy']);
    Route::get('workout-videos', [HomeController::class, 'workoutVideos'])->name('workout-videos');
    Route::post('getVideos', [HomeController::class, 'getVideos']);
    Route::get('nutrition', [HomeController::class, 'nutrition'])->name('nutrition');
    Route::get('recipes', [HomeController::class, 'recipes'])->name('recipes');
    Route::get('recipes/{category}', [HomeController::class, 'allRecipes']);
    Route::get('nutrition-blogs', [HomeController::class, 'nutritionBlogs'])->name('web-nutrition-blogs');
    Route::get('diary', [HomeController::class, 'diary'])->name('diary');
    Route::post('getMealsbyFrequency', [HomeController::class, 'getMealsbyFrequency']);
    Route::get('diet-chart', [HomeController::class, 'dietChart'])->name('diet-chart');
    Route::get('frc', [HomeController::class, 'frc'])->name('frc');
    Route::get('settings', [HomeController::class, 'settings'])->name('web.settings');
    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('web.contact-us');
    Route::post('contact-us', [HomeController::class, 'contactUsPost']);
    Route::get('faq', [HomeController::class, 'faq'])->name('web.faq');
    Route::get('invite-friends', [HomeController::class, 'inviteFriends'])->name('invite-friends');
    Route::get('my-diary', [HomeController::class, 'myDiary'])->name('my-diary');
    // Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
    // Route::get('terms-conditions', [HomeController::class, 'termsConditions'])->name('terms-conditions');
    Route::get('notifications', [HomeController::class, 'notifications'])->name('web.notifications');
    Route::get('search', [HomeController::class, 'search'])->name('search');
    Route::get('free-trial', [HomeController::class, 'freeTrial'])->name('free-trial');
    Route::get('invite-history', [HomeController::class, 'inviteHistory'])->name('web.invite-history');
    Route::get('about-us', [HomeController::class, 'aboutUs'])->name('web.about-us');
    Route::post('blogLike', [HomeController::class, 'blogLike']);
    Route::post('blogShare', [HomeController::class, 'blogShare']);
    Route::post('addblogComment', [HomeController::class, 'addblogComment']);
    Route::post('recipeLike', [HomeController::class, 'recipeLike']);
    Route::post('recipeShare', [HomeController::class, 'recipeShare']);
    Route::post('addrecipeComment', [HomeController::class, 'addrecipeComment']);

    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('profile-edit/{type}', [HomeController::class, 'profileEdit']);
    Route::post('profile-edit', [HomeController::class, 'profileEditPost'])->name('profile-edit');
    Route::get('comming-soon', [HomeController::class, 'commingsoon'])->name('comming-soon');
    Route::post('meals-complete', [HomeController::class, 'mealsComplete'])->name('meals-complete');
    Route::get('userWaterLevel/{type}', [HomeController::class, 'userWaterLevel']);
    Route::get('services', [HomeController::class, 'services'])->name('services');
    Route::get('test', [HomeController::class, 'test'])->name('test');
    Route::get('service-details/{slug}', [HomeController::class, 'serviceDetails']);
    Route::post('startFreeTrial', [HomeController::class, 'startFreeTrial']);

    Route::get('cart', [HomeController::class, 'cart'])->name('cart');
    Route::get('buy', [HomeController::class, 'buy'])->name('buy');
    Route::post('buynow', [HomeController::class, 'buynow']);
    Route::post('addsport', [HomeController::class, 'addsport']);
    Route::post('removeFromCart', [HomeController::class, 'removeFromCart']);
    Route::post('update-order', [HomeController::class, 'updateOrder']);
    Route::post('orderPlace', [HomeController::class, 'orderPlace']);
    Route::post('addonPerson', [HomeController::class, 'addonPerson']);
    Route::post('checkPersonType', [HomeController::class, 'checkPersonType']);
    Route::post('getUserDob', [HomeController::class, 'getUserDob']);
    Route::post('removePerson', [HomeController::class, 'removePerson']);
    Route::get('family-members', [HomeController::class, 'familyMembers'])->name('family-members');

    Route::get('my-plans', [HomeController::class, 'myPlans'])->name('my-plans');
    Route::post('addon-sport', [HomeController::class, 'addonsport']);
    Route::get('live-sessions', [HomeController::class, 'liveSessions'])->name('live-sessions');
    Route::get('live-sessions-details/{id}', [HomeController::class, 'liveSessionDetails']);
    Route::post('liveVideoUser', [HomeController::class, 'liveVideoUser']);
    Route::get('sports-curriculum', [HomeController::class, 'sportsCurriculum'])->name('web.sports-curriculum');
    Route::post('getSearchData', [HomeController::class, 'getSearchData']);
    Route::post('saveSearchData', [HomeController::class, 'saveSearchData']);
    Route::get('clearSerchHistory', [HomeController::class, 'clearSerchHistory']);
    Route::get('updatepasswordPage', [HomeController::class, 'updatepasswordPage']);
    Route::get('update-password', [HomeController::class, 'updatepasswordPage'])->name('web.update-password');
    Route::post('update-password', [HomeController::class, 'updatepasswordPost']);
    Route::post('newsletters', [HomeController::class, 'newsletters'])->name('newsletters');

    Route::get('news-feeds', [HomeController::class, 'newsFeeds'])->name('news-feeds');
    Route::get('news-feed-details/{slug}', [HomeController::class, 'newsFeedDetails']);
    Route::post('news-feeds-like', [HomeController::class, 'newsFeedsLike']);
    Route::post('addNewsFeedsComment', [HomeController::class, 'addNewsFeedComment']);
    Route::post('faqUpdateResponseweb', [HomeController::class, 'faqUpdateResponseweb']);

    Route::post('commentEdit', [HomeController::class, 'commentEdit'])->name('commentEdit');
    Route::post('commentDelete', [HomeController::class, 'commentDelete']);

    Route::post('notificationDelete', [HomeController::class, 'notificationDelete']);
});

Route::group(['prefix' => '/admin'], function () {
    Route::get('/', [UserController::class, 'loginPage']);
    Route::get('login', [UserController::class, 'loginPage'])->name('admin.login');
    Route::get('verify-otp', [UserController::class, 'verifyOTPPage'])->name('admin.verify-otp');
    Route::post('verify-otp', [UserController::class, 'verifyOTP']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::middleware(['checkAdmin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        //sliders
        Route::get('sliders', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('sliders');
        Route::get('slider-add', [App\Http\Controllers\Admin\SliderController::class, 'add'])->name('slider-add');
        Route::post('slider-add', [App\Http\Controllers\Admin\SliderController::class, 'post']);
        Route::get('slider-edit/{id}', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('slider-edit');
        Route::get('slider-view/{id}', [App\Http\Controllers\Admin\SliderController::class, 'view'])->name('slider-view');
        Route::post('slider-update', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('slider-update');
        Route::get('slider-delete/{id}', [App\Http\Controllers\Admin\SliderController::class, 'delete']);
        Route::get('changeSliderStatus', [App\Http\Controllers\Admin\SliderController::class, 'changeSliderStatus']);

        //roles
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles');
        Route::get('role-add', [App\Http\Controllers\Admin\RoleController::class, 'add'])->name('role-add');
        Route::post('role-add', [App\Http\Controllers\Admin\RoleController::class, 'post']);
        Route::get('role-edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('role-edit');
        Route::post('role-update', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('role-update');
        Route::get('role-delete/{id}', [App\Http\Controllers\Admin\RoleController::class, 'delete']);

        //Nutrition Blog
        Route::get('nutrition-blogs', [App\Http\Controllers\Admin\NutritionBlogController::class, 'index'])->name('nutrition-blogs');
        Route::get('nutrition-blog-add', [App\Http\Controllers\Admin\NutritionBlogController::class, 'add'])->name('nutrition-blog-add');
        Route::post('nutrition-blog-add', [App\Http\Controllers\Admin\NutritionBlogController::class, 'post']);
        Route::get('nutrition-blog-edit/{id}', [App\Http\Controllers\Admin\NutritionBlogController::class, 'edit'])->name('nutrition-blog-edit');
        Route::post('nutrition-blog-update', [App\Http\Controllers\Admin\NutritionBlogController::class, 'update'])->name('nutrition-blog-update');
        Route::get('nutrition-blog-delete/{id}', [App\Http\Controllers\Admin\NutritionBlogController::class, 'delete']);
        Route::get('changeNutritionBlogStatus', [App\Http\Controllers\Admin\NutritionBlogController::class, 'changeStatus']);
        //users
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::get('user-edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user-edit');
        Route::post('user-update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('user-update');
        Route::get('user-view/{id}', [App\Http\Controllers\Admin\UserController::class, 'view'])->name('user-view');
        Route::get('user-delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete']);
        Route::get('changeUserStatus', [App\Http\Controllers\Admin\UserController::class, 'changeUserStatus']);
        Route::get('user-search', [App\Http\Controllers\Admin\UserController::class, 'searchPage'])->name('user-search');
        Route::post('user-search', [App\Http\Controllers\Admin\UserController::class, 'search']);
        Route::get('change-password', [App\Http\Controllers\Admin\UserController::class, 'changePasswordPage'])->name('admin.change-password');
        Route::post('change-password', [App\Http\Controllers\Admin\UserController::class, 'changePassword']);
        Route::get('user-progress-chart/{id}', [App\Http\Controllers\Admin\UserController::class, 'userProgressChart']);
        Route::get('user-export', [App\Http\Controllers\Admin\UserController::class, 'downloadExport'])->name('user-export');

        //pages
        Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::get('setting-edit/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'edit'])->name('setting-edit');
        Route::post('setting-update', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('setting-update');
        //Invite History
        Route::get('invite-history', [App\Http\Controllers\Admin\SettingsController::class, 'inviteHistory'])->name('invite-history');
        //faqs
        Route::get('faqs', [App\Http\Controllers\Admin\FaqController::class, 'index'])->name('faqs');
        Route::get('faq-add', [App\Http\Controllers\Admin\FaqController::class, 'add'])->name('faq-add');
        Route::post('faq-add', [App\Http\Controllers\Admin\FaqController::class, 'post']);
        Route::get('faq-edit/{id}', [App\Http\Controllers\Admin\FaqController::class, 'edit'])->name('faq-edit');
        Route::get('faq-view/{id}', [App\Http\Controllers\Admin\FaqController::class, 'view'])->name('faq-view');
        Route::post('faq-update', [App\Http\Controllers\Admin\FaqController::class, 'update'])->name('faq-update');
        Route::get('faq-delete/{id}', [App\Http\Controllers\Admin\FaqController::class, 'delete']);
        Route::get('changeFAQStatus', [App\Http\Controllers\Admin\FaqController::class, 'changeFAQStatus']);

        //faqs Category
        Route::get('faq-category', [App\Http\Controllers\Admin\FaqController::class, 'category'])->name('faq-category');
        Route::get('faq-category-add', [App\Http\Controllers\Admin\FaqController::class, 'categoryAdd'])->name('faq-category-add');
        Route::post('faq-category-add', [App\Http\Controllers\Admin\FaqController::class, 'categoryPost']);
        Route::get('faq-category-edit/{id}', [App\Http\Controllers\Admin\FaqController::class, 'categoryEdit'])->name('faq-category-edit');
        Route::get('faq-category-view/{id}', [App\Http\Controllers\Admin\FaqController::class, 'categoryView'])->name('faq-category-view');
        Route::post('faq-category-update', [App\Http\Controllers\Admin\FaqController::class, 'categoryUpdate'])->name('faq-category-update');
        Route::get('faq-category-delete/{id}', [App\Http\Controllers\Admin\FaqController::class, 'categoryDelete']);
        Route::get('changeFAQCategoryStatus', [App\Http\Controllers\Admin\FaqController::class, 'changeFAQCategoryStatus']);

        //Workout Video
        Route::get('workout-video', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'index'])->name('workoutvideos');
        Route::get('workout-video-add', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'add'])->name('workout-video-add');
        Route::post('workout-video-add', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'post']);
        Route::get('workout-video-edit/{id}', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'edit'])->name('workout-video-edit');
        Route::post('workout-video-update', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'update'])->name('workout-video-update');
        Route::get('workout-video-delete/{id}', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'delete']);
        Route::get('changeWorkoutStatus', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'changeWorkoutStatus']);

        //live Video
        Route::get('live-videos', [App\Http\Controllers\Admin\LivevideoController::class, 'index'])->name('live-videos');
        Route::get('live-video-add', [App\Http\Controllers\Admin\LivevideoController::class, 'add'])->name('live-video-add');
        Route::post('live-video-add', [App\Http\Controllers\Admin\LivevideoController::class, 'post']);
        Route::get('live-video-edit/{id}', [App\Http\Controllers\Admin\LivevideoController::class, 'edit'])->name('live-video-edit');
        Route::post('live-video-update', [App\Http\Controllers\Admin\LivevideoController::class, 'update'])->name('live-video-update');
        Route::get('live-video-delete/{id}', [App\Http\Controllers\Admin\LivevideoController::class, 'delete']);
        Route::get('changeLiveVideoStatus', [App\Http\Controllers\Admin\LivevideoController::class, 'changeLiveVideoStatus']);

        //workout Category
        Route::get('workout-category', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'category'])->name('workout-category');
        Route::get('workout-category-add', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'categoryAdd'])->name('workout-category-add');
        Route::post('workout-category-add', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'categoryPost']);
        Route::get('workout-category-edit/{id}', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'categoryEdit'])->name('workout-category-edit');
        Route::post('workout-category-update', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'categoryUpdate'])->name('workout-category-update');
        Route::get('workout-category-delete/{id}', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'categoryDelete']);
        Route::get('changeWorkoutCategoryStatus', [App\Http\Controllers\Admin\WorkoutvideoController::class, 'changeWorkoutCategoryStatus']);

        //contactus
        Route::get('contact-us', [App\Http\Controllers\Admin\ContactusController::class, 'index'])->name('contact-us');
        Route::get('contact-us-reply/{id}', [App\Http\Controllers\Admin\ContactusController::class, 'reply'])->name('contact-us-reply');
        Route::get('contact-us-view/{id}', [App\Http\Controllers\Admin\ContactusController::class, 'view'])->name('contact-us-view');
        Route::post('contact-us-update', [App\Http\Controllers\Admin\ContactusController::class, 'update'])->name('contact-us-update');
        Route::get('contact-us-delete/{id}', [App\Http\Controllers\Admin\ContactusController::class, 'delete']);

        //Notification
        Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
        Route::get('notifications-add', [App\Http\Controllers\Admin\NotificationController::class, 'add'])->name('notifications-add');
        Route::post('notifications-add', [App\Http\Controllers\Admin\NotificationController::class, 'post']);
        Route::get('notifications-delete/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'delete']);

        //Nutrition Recipe
        Route::get('nutrition-recipes', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'index'])->name('nutrition-recipes');
        Route::get('nutrition-recipe-add', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'add'])->name('nutrition-recipe-add');
        Route::post('nutrition-recipe-add', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'post']);
        Route::get('nutrition-recipe-edit/{id}', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'edit'])->name('nutrition-recipe-edit');
        Route::post('nutrition-recipe-update', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'update'])->name('nutrition-recipe-update');
        Route::get('nutrition-recipe-delete/{id}', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'delete']);
        Route::get('changeNutritionRecipeStatus', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'changeStatus']);
        Route::post('getrecipeMeal', [App\Http\Controllers\Admin\NutritionRecipeController::class, 'getrecipeMeal']);

        //Nutrition Diet
        Route::get('nutrition-diet', [App\Http\Controllers\Admin\NutritionDietController::class, 'index'])->name('nutrition-diet');
        Route::get('nutrition-diet-add', [App\Http\Controllers\Admin\NutritionDietController::class, 'add'])->name('nutrition-diet-add');
        Route::post('nutrition-diet-add', [App\Http\Controllers\Admin\NutritionDietController::class, 'post']);
        Route::get('nutrition-diet-edit/{id}', [App\Http\Controllers\Admin\NutritionDietController::class, 'edit'])->name('nutrition-diet-edit');
        Route::post('nutrition-diet-update', [App\Http\Controllers\Admin\NutritionDietController::class, 'update'])->name('nutrition-diet-update');
        Route::get('nutrition-diet-delete/{id}', [App\Http\Controllers\Admin\NutritionDietController::class, 'delete']);
        Route::post('getMeal', [App\Http\Controllers\Admin\NutritionDietController::class, 'getMeal']);
        Route::get('nutrition-diet-share/{id}', [App\Http\Controllers\Admin\NutritionDietController::class, 'share'])->name('nutrition-diet-share');

        //Service Categories
        Route::get('service-categories', [App\Http\Controllers\Admin\ServiceCategoryController::class, 'index'])->name('service-categories');
        Route::get('change-service-categories-status', [App\Http\Controllers\Admin\ServiceCategoryController::class, 'changeStatus']);
        Route::get('service-category-edit/{id}', [App\Http\Controllers\Admin\ServiceCategoryController::class, 'edit'])->name('service-category-edit');
        Route::post('service-category-update', [App\Http\Controllers\Admin\ServiceCategoryController::class, 'update'])->name('service-category-update');

        //Service Packages
        Route::get('service-packages', [App\Http\Controllers\Admin\ServicePackageController::class, 'index'])->name('service-packages');
        Route::get('service-packages/{id}', [App\Http\Controllers\Admin\ServicePackageController::class, 'show'])->name('service-packages-show');
        Route::get('service-packages-add', [App\Http\Controllers\Admin\ServicePackageController::class, 'add'])->name('service-packages-add');
        Route::post('service-packages-add', [App\Http\Controllers\Admin\ServicePackageController::class, 'post']);
        Route::get('service-packages-edit/{id}', [App\Http\Controllers\Admin\ServicePackageController::class, 'edit'])->name('service-packages-edit');
        Route::get('service-packages-delete/{id}', [App\Http\Controllers\Admin\ServicePackageController::class, 'delete']);
        Route::get('change-service-packages-status', [App\Http\Controllers\Admin\ServicePackageController::class, 'changeStatus']);
        Route::get('updateFinalAmount', [App\Http\Controllers\Admin\ServicePackageController::class, 'updateFinalAmount']);
        Route::get('change-service-packages-grayout', [App\Http\Controllers\Admin\ServicePackageController::class, 'changeStatusGrayout']);
        Route::get('changeStatusSportShow', [App\Http\Controllers\Admin\ServicePackageController::class, 'changeStatusSportShow']);


        //Service Packages IOS
        Route::get('service-packages-ios', [App\Http\Controllers\Admin\ServicePackageIOSController::class, 'index'])->name('service-packages-ios');
        Route::get('service-packages-ios/{id}', [App\Http\Controllers\Admin\ServicePackageIOSController::class, 'show'])->name('service-packages-show-ios');
        Route::get('change-service-packages-ios-status', [App\Http\Controllers\Admin\ServicePackageIOSController::class, 'changeStatus']);
        Route::get('service-packages-ios-edit/{id}', [App\Http\Controllers\Admin\ServicePackageIOSController::class, 'edit'])->name('service-packages-ios-edit');
        Route::post('service-packages-ios-update', [App\Http\Controllers\Admin\ServicePackageIOSController::class, 'update'])->name('service-packages-ios-update');





        //Nutrition Diet Frequency
        Route::get('nutri-diet-frequency', [App\Http\Controllers\Admin\NutriDietFrequencyController::class, 'index'])->name('nutri-diet-frequency');
        Route::get('nutri-diet-frequency-add', [App\Http\Controllers\Admin\NutriDietFrequencyController::class, 'add'])->name('nutri-diet-frequency-add');
        Route::post('nutri-diet-frequency-add', [App\Http\Controllers\Admin\NutriDietFrequencyController::class, 'post']);
        Route::get('nutri-diet-frequency-edit/{id}', [App\Http\Controllers\Admin\NutriDietFrequencyController::class, 'edit'])->name('nutri-diet-frequency-edit');
        Route::get('nutri-diet-frequency-delete/{id}', [App\Http\Controllers\Admin\NutriDietFrequencyController::class, 'delete']);
        Route::get('change-nutri-diet-frequency-status', [App\Http\Controllers\Admin\NutriDietFrequencyController::class, 'changeStatus']);

        //Nutrition Recipe Categories
        Route::get('nutri-recipe-categories', [App\Http\Controllers\Admin\NutriRecipeCategoryController::class, 'index'])->name('nutri-recipe-categories');
        Route::get('nutri-recipe-categories-add', [App\Http\Controllers\Admin\NutriRecipeCategoryController::class, 'add'])->name('nutri-recipe-categories-add');
        Route::post('nutri-recipe-categories-add', [App\Http\Controllers\Admin\NutriRecipeCategoryController::class, 'post']);
        Route::get('nutri-recipe-categories-edit/{id}', [App\Http\Controllers\Admin\NutriRecipeCategoryController::class, 'edit'])->name('nutri-recipe-categories-edit');
        Route::get('nutri-recipe-categories-delete/{id}', [App\Http\Controllers\Admin\NutriRecipeCategoryController::class, 'delete']);
        Route::get('change-nutri-recipe-categories-status', [App\Http\Controllers\Admin\NutriRecipeCategoryController::class, 'changeStatus']);

        //User Packages
        Route::get('user-packages/{id}', [App\Http\Controllers\Admin\UserPackageController::class, 'show'])->name('user-packages');
        Route::get('user-family-members/{id}', [App\Http\Controllers\Admin\UserPackageController::class, 'view'])->name('user-family-members');
        Route::get('delete-user-packages/{id}/{user_id}', [App\Http\Controllers\Admin\UserPackageController::class, 'deleteUserPackage']);



        //User Packages
        Route::get('meals', [App\Http\Controllers\Admin\MealController::class, 'index'])->name('meals');
        Route::get('meals-add', [App\Http\Controllers\Admin\MealController::class, 'add'])->name('meals-add');
        Route::post('meals-add', [App\Http\Controllers\Admin\MealController::class, 'post']);
        Route::get('meals-edit/{id}', [App\Http\Controllers\Admin\MealController::class, 'edit'])->name('meals-edit');
        Route::get('meals-delete/{id}', [App\Http\Controllers\Admin\MealController::class, 'delete']);
        Route::get('change-meals-status', [App\Http\Controllers\Admin\MealController::class, 'changeStatus']);
        Route::post('getrecipeDetails', [App\Http\Controllers\Admin\MealController::class, 'getrecipeDetails']);

        Route::get('users-frc', [App\Http\Controllers\Admin\FRCController::class, 'index'])->name('users-frc');
        Route::get('users-frc-view/{id}', [App\Http\Controllers\Admin\FRCController::class, 'view'])->name('users-frc-view');
        Route::get('users-frc-share/{id}', [App\Http\Controllers\Admin\FRCController::class, 'share']);
        Route::get('frcemailview', [App\Http\Controllers\Admin\FRCController::class, 'frcemailview'])->name('frcemailview');
        Route::get('testHtml', [App\Http\Controllers\Admin\FRCController::class, 'testHtml']);
        Route::post('attachmentupload', [App\Http\Controllers\Admin\FRCController::class, 'attachmentupload']);
        Route::post('removeattachment', [App\Http\Controllers\Admin\FRCController::class, 'removeattachment']);

        //Sports Curriculum
        Route::get('sports-curriculum', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'index'])->name('sports-curriculum');
        Route::get('sports-curriculum-add', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'add'])->name('sports-curriculum-add');
        Route::post('sports-curriculum-add', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'post']);
        Route::get('sports-curriculum-edit/{id}', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'edit'])->name('sports-curriculum-edit');
        Route::post('sports-curriculum-update', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'update'])->name('sports-curriculum-update');
        Route::get('sports-curriculum-delete/{id}', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'delete']);
        Route::get('changeSportsurriculumStatus', [App\Http\Controllers\Admin\SportsCurriculumController::class, 'changeSportsurriculumStatus']);

        //User Packages
        Route::get('ingredients', [App\Http\Controllers\Admin\IngredientsController::class, 'index'])->name('ingredients');
        Route::get('ingredients-add', [App\Http\Controllers\Admin\IngredientsController::class, 'add'])->name('ingredients-add');
        Route::post('ingredients-add', [App\Http\Controllers\Admin\IngredientsController::class, 'post']);
        Route::get('ingredients-edit/{id}', [App\Http\Controllers\Admin\IngredientsController::class, 'edit'])->name('ingredients-edit');
        Route::get('ingredients-delete/{id}', [App\Http\Controllers\Admin\IngredientsController::class, 'delete']);
        Route::get('change-ingredients-status', [App\Http\Controllers\Admin\IngredientsController::class, 'changeStatus']);

        //Home Category
        Route::get('home-category', [App\Http\Controllers\Admin\HomeCategoryController::class, 'index'])->name('home-category');
        Route::get('home-category-edit/{id}', [App\Http\Controllers\Admin\HomeCategoryController::class, 'edit'])->name('home-category-edit');
        Route::post('home-category-update', [App\Http\Controllers\Admin\HomeCategoryController::class, 'update'])->name('home-category-update');
        Route::get('changehomeCategoryStatus', [App\Http\Controllers\Admin\HomeCategoryController::class, 'changehomeCategoryStatus']);

        //Nutrition Quote
        Route::get('nutrition-quote', [App\Http\Controllers\Admin\NutritionQuoteController::class, 'index'])->name('nutrition-quote');
        Route::get('nutrition-quote-add', [App\Http\Controllers\Admin\NutritionQuoteController::class, 'add'])->name('nutrition-quote-add');
        Route::post('nutrition-quote-add', [App\Http\Controllers\Admin\NutritionQuoteController::class, 'post']);
        Route::get('nutrition-quote-edit/{id}', [App\Http\Controllers\Admin\NutritionQuoteController::class, 'edit'])->name('nutrition-quote-edit');
        Route::get('nutrition-quote-delete/{id}', [App\Http\Controllers\Admin\NutritionQuoteController::class, 'delete']);
        Route::get('change-nutrition-quote-status', [App\Http\Controllers\Admin\NutritionQuoteController::class, 'changeStatus']);

        //Nutrition Diet Frequency
        Route::get('role-base-user', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'index'])->name('role-base-user');
        Route::get('role-base-user-add', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'add'])->name('role-base-user-add');
        Route::post('role-base-user-add', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'post']);
        Route::get('role-base-user-edit/{id}', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'edit'])->name('role-base-user-edit');
        Route::post('role-base-user-update', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'update'])->name('role-base-user-update');
        Route::get('role-base-user-delete/{id}', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'delete']);
        Route::get('change-role-base-user-status', [App\Http\Controllers\Admin\RoleBaseUserController::class, 'changeStatus']);

        //NewsFeed
        Route::get('news-feed', [App\Http\Controllers\Admin\NewsFeedController::class, 'index'])->name('news-feed');
        Route::get('news-feed-add', [App\Http\Controllers\Admin\NewsFeedController::class, 'add'])->name('news-feed-add');
        Route::post('news-feed-add', [App\Http\Controllers\Admin\NewsFeedController::class, 'post']);
        Route::get('news-feed-edit/{id}', [App\Http\Controllers\Admin\NewsFeedController::class, 'edit'])->name('news-feed-edit');
        Route::post('news-feed-update', [App\Http\Controllers\Admin\NewsFeedController::class, 'update'])->name('news-feed-update');
        Route::get('news-feed-delete/{id}', [App\Http\Controllers\Admin\NewsFeedController::class, 'delete']);
        Route::get('change-news-feed-status', [App\Http\Controllers\Admin\NewsFeedController::class, 'changeStatus']);

        //Header Footer
        Route::get('header-footer', [App\Http\Controllers\Admin\HeaderFooterController::class, 'index'])->name('header-footer');
        Route::get('header-footer-edit/{id}', [App\Http\Controllers\Admin\HeaderFooterController::class, 'edit'])->name('header-footer-edit');
        Route::post('header-footer-update', [App\Http\Controllers\Admin\HeaderFooterController::class, 'update'])->name('header-footer-update');
        Route::get('changeheaderFooterStatus', [App\Http\Controllers\Admin\HeaderFooterController::class, 'changeheaderFooterStatus']);

        Route::get('about-us', [App\Http\Controllers\Admin\SettingsController::class, 'aboutusPage'])->name('about-us');
        Route::post('about-us-update', [App\Http\Controllers\Admin\SettingsController::class, 'aboutusPageUpdate'])->name('about-us-update');
        Route::post('removeMemberAboutus', [App\Http\Controllers\Admin\SettingsController::class, 'removeMemberAboutus']);
    });
});
Route::group(['prefix' => '/subadmin'], function () {
    Route::middleware(['checkAdmin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard']);
    });
});
