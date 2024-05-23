<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return redirect()->route('setting-user.edit', $user->uuid);
    }

    public function store()
    {
    }
    public function create()
    {
    }
    public function show()
    {
    }
    public function edit($uuid)
    {
        $data = User::where("uuid", $uuid)->first();

        return view("dashboard.pages.setting.index", compact("data"));
    }
    public function editProfile(Request $request)
    {
        try {
            $validate = $request->validate([
                "profile_kelas" => "image",
                "user_id" => "required|integer",
            ]);
            $user = User::where("id", $request->user_id)->first();
            if ($request->hasFile('profile_user')) {
                if ($user->profile_user !== null) {
                    Storage::delete($user->profile_user);
                }
                $validate['profile_user'] = $request->file('profile_user')->store('public/image');
                $profile_user = $validate['profile_user'];

                // Lakukan operasi lain sesuai kebutuhan (misalnya, menyimpan nama file ke database)
                User::where("id", $user->id)->update(['profile_user' => $profile_user]);
            }
            return redirect()->route('setting-user.edit', $user->uuid);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function update($uuid, Request $request)
    {
        $validation = $request->validate([
            "name" => "required",
            "email" => "required|unique:users|email",
            "no_hp" => "required",
        ]);
        $user = User::where("uuid", $uuid)->first();
        if ($user->uuid === Auth::user()->uuid) {
            return redirect('/setting-user');
        }
        $user->update($validation);
        return redirect("/setting-user/$user->uuid/edit");
    }
    public function destroy()
    {
    }
}
