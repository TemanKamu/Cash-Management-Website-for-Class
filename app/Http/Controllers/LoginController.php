<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return redirect("/");
        }
        return view("landing_page.pages.login");
    }
    public function store(Request $request)
    {
        $validation = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        if (Auth::attempt($validation)) {
            $request->session()->regenerate();
            if (Auth::user()->kelas_id !== null && Auth::user()->status_verifikasi_kelas) {
                return redirect("/home");
            } elseif (Auth::user()->kelas_id === null && Auth::user()->status_verifikasi_kelas === 0) {
                return redirect("/welcome");
            } else {
                return redirect("/");
            }
        }
        return back()->with('loginError', 'Gagal login');
    }
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}
