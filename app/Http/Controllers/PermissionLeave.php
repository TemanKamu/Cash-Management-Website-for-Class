<?php

namespace App\Http\Controllers;

use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Mail_box;
use App\Models\User;
use App\Models\UserLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionLeave extends Controller
{

    public function index()
    {
        $datas = UserLeave::where("kelas_id", Auth::user()->kelas_id)->get();
        return view("dashboard.pages.userLeave.index", compact("datas"));
    }
    public function store(Request $request)
    {
        
        $validate = $request->validate([
            "user_id" => "required|integer",
            "kelas_id" => "required|integer",
            "description" => "required",
        ]);
        UserLeave::create($validate);
        History_activities::create([
            "user_id" => $request->user_id,
            "kelas_id" => $request->kelas_id,
            "isBendahara" => 1,
            "description" => "User " . User::where("id", $request->user_id)->first()->name . " Meminta Izin Keluar Kelas"
        ]);
        return back()->with("success", "Pengajuan keluar kelas Berhasil");
    }

    public function notAllowed($id, Request $request)
    {
        $permission = UserLeave::findOrFail($id);
        $user = User::where("id", $permission->user_id)->first();
        Mail_box::create([
            "title" => "Pengajuan Izin Keluar Kelas",
            "for_user_id" => $user->id,
            "messager_name" => $request->bendaharaName,
            "description" => $request->alasan,
            "isBendahara" => "true"
        ]);
        $permission->delete();
        return back()->with("success", "User tidak diizinkan keluar kelas");
    }
    public function batalKeluar($id){
        $permission = UserLeave::findOrFail($id);
        $permission->delete();
        
        return redirect('/home');
    }
    public function destroy($id)
    {
        $permission = UserLeave::findOrFail($id);
        $user = User::where("id", $permission->user_id)->first();
        $kelas = ClassTable::where("id", $user->kelas_id)->first();
        if ($kelas->owner_room_id === $user->id) {
            return back()->with("failed", "Kamu tidak diizinkan keluar kelas karena kamu owner kelas " . $kelas->nama_kelas);
        }
        User::where("id", $user->id)->update([
            "status_verifikasi_kelas" => 0,
            "kelas_id" => null,
            "isBendahara" => 0
        ]);
        History_activities::create([
            "user_id" => $user->id,
            "kelas_id" => $user->kelas_id,
            "isBendahara" => 1,
            "description" => "User " . $user->name . " Telah diizinkan keluar kelas"

        ]);
        Mail_box::create([
            "title" => "Pengajuan Izin Keluar Kelas",
            "for_user_id" => $user->id,
            "messager_name" => "Kelas-Ku Bot",
            "isBendahara" => "system",
            "description" => "Kamu  telah diizinkan keluar kelas " . $kelas->nama_kelas
        ]);
        $permission->delete();


        return redirect('/keluar')->with("success", "User telah diizinkan keluar kelas ");
    }
}
