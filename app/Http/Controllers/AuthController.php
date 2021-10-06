<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\User;
use Session;

class AuthController extends Controller
{
    public function showRegistration() {
        if (Auth::check()) {
            return Redirect::to('/');
        }

        if (Request()->has('ref')) {
            $referralToken = Request()->query('ref');
            if (session()->pull('referrer') != $referralToken) {
                $this->incrementReferalViewsCount($referralToken);
            }
            session(['referrer' => $referralToken]);
        }
        return view('registration-form');
    }

    public function showLogin() {
        if (Auth::check()) {
            return Redirect::to('/');
        }
        return view('login');
    }

    public function doLogout() {
        Session::flush();
        Auth::logout(); // logging out user
        return Redirect::to('login'); // redirection to login screen
    }

    public function doLogin() {
        // checking all field
        Request()->validate(
            [
                'email'             => 'required|email|',
                'password'          => 'required|alpha_num'
            ]
        );
        $userdata = array(
            "email"             => Request()->email,
            "password"          => Request()->password
        );
        // attempt to do the login
        if (Auth::attempt($userdata))  {
            if (auth()->user()->is_admin == 1) {
                return Redirect::to('/');
            } else {
                return Redirect::to('dashboard');
            }
        } else {
            // validation not successful, send back to form
            return Redirect::to('login')->with("failed", "Alert! Failed to login. Please check email or password");
        }
    }

    public function register() {

        // Form validate
        Request()->validate([
                'name'              => 'required|string|max:20',
                'email'             => 'required|email|unique:users,email',
                'password'          => 'required|alpha_num|min:8',
                'confirm_password'  => 'required|same:password',
                'profile_image_url' => 'required|mimes:jpeg,jpg,png|max:5120'
            ]
        );

        $referrer = User::where('referral_token',session()->pull('referrer'))->first();
        $referralToken = "";
        $dataArray = array(
            "name"              => Request()->name,
            "email"             => Request()->email,
            "referrer_id"       => $referrer ? $referrer->id : null,
            "password"          => Hash::make(Request()->password),
            "referral_token"    => $this->generateReferralToken()
        );

        $user = User::create($dataArray);

        if(!is_null($user)) {
            if (Request()->hasFile('profile_image_url')) {
                $profileImage = Request()->file('profile_image_url')->getClientOriginalName();
                Request()->file('profile_image_url')->storeAs('profile_images',$user->id.'/'.$profileImage,'');
                $user->update(['profile_image_url'=>$profileImage]);
            }
            Auth::login($user);
            return Redirect::to('/');
        } else {
            return back()->with("failed", "Alert! Failed to register");
        }
    }

    public function generateReferralToken()
    {
        $my_rand_strng = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"), -5);

        return $my_rand_strng."".time();
    }
    public function incrementReferalViewsCount($referralToken)
    {
        try {
            DB::table('users')->where('referral_token',$referralToken)->increment('referral_views');
        } catch (\Throwable $th) {
            return null;
        }
        return 1;
    }
}
