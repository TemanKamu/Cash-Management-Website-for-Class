<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    //
    public function googleRedirect()
    {
        return Socialite::driver("google")->redirect();
    }
    public function googleCallback()
    {
        $user = Socialite::driver("google")->user();

        $userModel = User::where('email', $user->email)->first();
        if (!$userModel) {
            return back()->with('error', 'User not found, Please register first');
        }
        (Auth::login($userModel));
        return redirect('/class');
    }
}
