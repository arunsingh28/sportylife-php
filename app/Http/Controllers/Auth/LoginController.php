<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;
use App\Models\User;
use App\Models\Languages;
use App\Models\Cities;
use App\Models\States;
use App\Models\Phonecodes;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\ApiHelper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function getUserAge(Request $request)
    { 
        $dob = $request->dob;
        $date = Carbon::parse($dob);
        $now = Carbon::now();
        $age = $date->diff($now)->format('%y');
        if ($age) {
            return response()->json(['statusCode' => 200, 'age' => $age]);
        }
        return response()->json(['statusCode' => 999, 'age' => '']);
    }
    public function loginpage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        Auth::logout();
        $credentials = $request->only('email', 'password');
        $password = $request->password;
        $email = $request->email;
        $remember_me = $request->has('remember_me') ? true : false; 
        if (Auth::attempt(['email' => $email,'user_type' => 'user', 'password' => $password],$remember_me)) {
            if (Auth::user()->role_id != 1) {
                $user  = Auth::user();
                if ($user->is_verify == '0') {
                    $otp = rand(100000,999999);

                    $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone);
                    $sendemail = ApiHelper::sendEmailOtp($otp, $user->email);

                    $input1['otp'] = $otp;
                    $user1 =  User::where('id', $user->id)->update($input1);
                    Auth::logout();
                    return redirect(route('verify-otp', ['email' => $user->email,'type' => 'register']))->withSuccess('OTP successfully send on your Email.');
                }
                return redirect()->intended('index');
            }else{
                Auth::logout();
                return redirect('/login')->withError('You are not allowed.');
            }
        }elseif (Auth::attempt(['phone' => $email,'user_type' => 'user', 'password' => $password],$remember_me)) {
            if (Auth::user()->role_id != 1) {
                $user  = Auth::user();
                if ($user->is_verify == '0') {
                    $otp = rand(100000,999999);

                    $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone);
                    $sendemail = ApiHelper::sendEmailOtp($otp, $user->email);

                    $input1['otp'] = $otp;
                    $user1 =  User::where('id', $user->id)->update($input1);
                    Auth::logout();
                    return redirect(route('verify-otp', ['email' => $user->email,'type' => 'register']))->withSuccess('OTP successfully send on your Email.');
                }
                return redirect()->intended('index');
            }else{
                Auth::logout();
                return redirect('/login')->withError('You are not allowed.');
            }
        }else{
            return redirect("login")->withError('Opps! You have entered invalid credentials');
        }
    }

   
    
   
    public function signuppage()
    {
        $languages =  Languages::where('status','1')->get();
        $state_data =  States::select('id','name')->orderBy('name',"asc")->get();
        $city_data =  Cities::select('id','name')->orderBy('name',"asc")->get();
        $phonecode_data =  Phonecodes::select('id','phone_code','country_name')->orderBy('country_name',"asc")->get();
        return view('auth.register',compact('languages','state_data','city_data','phonecode_data'));
    }
    
    public function signup(Request $request)
    {
        
        $request->validate([
            'first_name' => ' required',
            // 'last_name' => ' required',
            // 'email' => 'required|email|unique:users,email',
            'email' => 'required|email',
            // 'phone' => 'numeric|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone',
            'phone' => 'numeric|regex:/^([0-9\s\-\+\(\)]*)$/',
            'dob' => 'required',
            'gender' => 'required',
            // 'city' => 'nullable',
            // 'state' => 'nullable',
            'language_id' => 'nullable',
            'password' => 'required|confirmed',
            'google_id' => 'nullable',
            'yahoo_id' => 'nullable',
            'weight' => 'nullable|numeric|regex:/^[0-9]+$/',
            'height_feet' => 'nullable|numeric|regex:/^[0-9]+$/',
            'height_inch' => 'nullable|numeric|regex:/^[0-9]+$/',
            'refer_by' => 'nullable',
            'device_token' => 'nullable',
        ]);
        $exist_user = User::where('user_type', "user")->where('email', $request->email)->orWhere('phone', $request->phone)->first();
        if (!empty($exist_user)) {
            if ($exist_user->is_verify == '1') {
                $exist_email = User::where('user_type', "user")->where('email', $request->email)->first();
                if (!empty($exist_email)) {
                    return redirect("signup")->withError('Email already Registered.');
                }else{
                    return redirect("signup")->withError('Mobile already Registered.');
                }
                // return redirect("signup")->withError('User already Registered.');
            }
        }
        $input = $request->only('first_name', 'last_name', 'email', 'phone','country_code', 'gender','city','state','weight','weight_type','height_type','height_feet','height_inch','refer_by','school_name','school_address','school_unique_id','zipcode','language_id' );
        $input['name'] = @$request->first_name.' '.@$request->last_name;
        if ($input['gender'] == "female") {
            $input['image'] = "uploads/images/dummy_female.png";
        }else{
            $input['image'] = "uploads/images/dummy_male.png";
        }
        $input['referral_code'] = "SPL".rand(100000,999999);
        $input['dob'] = date("Y-m-d",strtotime($request->dob));
        if ($request->google_id) {
            $input['google_id'] = $request->google_id;
            $input['is_social'] = '1';
        }
        if ($request->yahoo_id) {
            $input['yahoo_id'] = $request->yahoo_id;
            $input['is_social'] = '1';
        }
        $input['role_id'] = '2';
        $input['is_verify'] = '0';
        $input['user_type'] = 'user';
        $input['device_token'] = $request->device_token;
        $input['password_text'] = $request->password;
        $input['password'] = Hash::make($request->password);

        if (!empty($exist_user)) {
            $user =  $exist_user->update($input);
            $user = User::where('user_type', "user")->where('email', $request->email)->orWhere('phone', $request->phone)->first();
        }else{
            $user =  User::create($input);
        }
        // $user =  User::create($input);
        if ($user) {
            $otp = rand(100000,999999);

            $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone);
            $sendemail = ApiHelper::sendEmailOtp($otp, $user->email);
            
            $input1['otp'] = $otp;
            $user1 =  User::where('id', $user->id)->update($input1);
            $user['otp'] = $otp;
            // $user['access_token'] = $user->createToken('authToken')->accessToken;
            // return redirect('/index')->withSuccess('Registered Successfully.');
            return redirect(route('verify-otp', ['email' => $user->email, 'type' => 'register']))->withSuccess('OTP successfully send on your Email and Mobile.');
        }
        return redirect("signup")->withError('Registration Failed.');
    }

    public function verifyOtpPage($email, Request $request)
    { 
        $type = $request->get('type');
        return view('auth.verify-otp', compact('email', 'type'));
    }
    
    
    public function verifyOtp(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'otp' => 'required',
            'type' => 'required',
        ]);
        $otp = implode('',$request->otp);
        $user =  User::where('user_type', "user")->where('email', $request->email)->where('otp', $otp)->first();
        if ($user) {
            $input['otp'] = NULL;
            $input['is_verify'] = '1';
            $user =  User::where('user_type', "user")->where('email', $request->email)->update($input);
            $user_data =  User::where('user_type', "user")->where('email',$request->email)->first();
            if ($request->type == "register") {
                Auth::login($user_data, true);
                return redirect('/index')->withSuccess('You are registered successfully.');
            }else{
                return redirect(route('change-password', ['email' => $request->email]))->withSuccess('OTP Verified Successfully.');
            }
        }
        return redirect(route('verify-otp', ['email' => $request->email]))->withError('Invalid OTP.');
    }

    public function forgotPasswordPage()
    { 
        return view('auth.forgot-password');
    }
    
    public function forgotPassword(Request $request)
    { 
        $request->validate([
            'email' => 'required',
        ]);
        $user =  User::where('user_type', "user")->where('email', $request->email)->first();
        if ($user) {
            $otp = rand(100000,999999);
            
            $sendmobileotp = ApiHelper::sendMobileOtp($otp, $user->phone); 
            $sendemail = ApiHelper::sendEmailOtp($otp, $user->email);
            $input1['otp'] = $otp;
            $user1 =  User::where('user_type', "user")->where('email', $user->email)->update($input1);
            return redirect(route('verify-otp', ['email' => $user->email, 'type' => 'forgotpassword']))->withSuccess('OTP successfully send on your Email and Mobile.');
        }
        return redirect(route('forgot-password'))->withError('Invalid E-Mail.');
    }

    

    public function changePasswordPage($email, Request $request)
    { 
        return view('auth.change-password',compact('email'));
    }

    public function changePassword(Request $request)
    { 
        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        $user =  User::where('user_type', "user")->where('email', $request->email)->first();
        if ($user) {
            $input['password_text'] = $request->password;
            $input['password'] = Hash::make($request->password);
            $user =  User::where('user_type', "user")->where('email', $request->email)->update($input);
            return redirect(route('login'))->withSuccess('Password Change Successfully.');
        }
        return redirect(route('forgot-password'))->withError('User Not Found!.');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect(route('login').'#');
        }
        print_r($user);exit;
        // only allow people with @company.com to login
        // if(explode("@", $user->email)[1] !== 'company.com'){
        //     return redirect()->to('/');
        // }
        $find = User::where('user_type', "user")->where('email', $user->email)->first();
        if($find) {
            if($provider == 'google') {
                $update = ['google_id' => $user->id,'name' => $user->name,'first_name' => $user->user['given_name'],'last_name' => $user->user['family_name'],'image' => $user->avatar_original];
            } elseif($provider == 'yahoo') {
                $update = ['yahoo_id' => $user->id];    
            }
            User::where('id', $find->id)->update($update);
            Auth::login($find);
        } else {
            $new = new User;
            $new->name = $user->name;
            $new->first_name = $user->user['given_name'];
            $new->last_name = $user->user['family_name'];
            $new->email = $user->email;
            $new->is_social = '1';
            $new->role_id = '2';
            $new->is_verify = '0';
            $new->user_type = 'user';
            if($provider == 'google') {
                $new->google_id = $user->id;
            } elseif($provider == 'yahoo') {
                $new->yahoo_id = $user->id;
            }
            //$new->avatar = $user->avatar;
            $new->image = $user->avatar_original;
            $new->save();
            Auth::login($new);
        }
        return redirect(route('home'));
        // if(auth()->user()->screen == 1) {
        // }
    }
    
    public function logout()
    {
        $user = Auth::user();
        if ($user->role_id == '1') {
            $input1['is_verify'] = '0';
            $user1 = User::where('id', $user->id)->update($input1);
        }
        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
