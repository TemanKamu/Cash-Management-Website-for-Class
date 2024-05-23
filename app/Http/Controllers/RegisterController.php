<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {

        return view("landing_page.pages.register");
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => "required",
            "email" => "required|unique:users|email",
            "password" => "required|min:6|confirmed",
            "no_hp" => "required",
            "profile_user" => "required",
        ]);
        $profile_user = null;
        if ($request->file("profile_user")) {
            $validate['profile_user'] = $request->file('profile_user')->store('public/image');
            $profile_user = $validate['profile_user'];
        }
        $validation["password"] = Hash::make($validation["password"]);
        User::create([
            "name" => $validation["name"],
            "email" => $validation["email"],
            "password" => $validation["password"],
            "no_hp" => $validation["no_hp"],
            "profile_user" => $profile_user,
        ]);

        return redirect("/login");
    }
}
