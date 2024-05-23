<?php

namespace App\Http\Controllers;

use App\Models\Mail_box;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiUserController extends Controller
{
    public function index()
    {
        if (request()->has("email")) {
            $datas = User::where("email", request("email"))->where("kelas_id", Auth::user()->kelas_id)->where("status_verifikasi_kelas", 0)->orWhere("status_verifikasi_kelas", "")->get();
            return view("dashboard.pages.manage_student_verification.index", compact("datas"));
        }
        $datas = User::where("kelas_id", Auth::user()->kelas_id)->where("status_verifikasi_kelas", 0)->get();
        return view("dashboard.pages.manage_student_verification.index", compact("datas"));
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            "kode_kelas" => "required",
            "kelas_id" => "required",
        ]);
        $userData = User::find($user->id);
        if ($userData->kelas_id === null && $userData->status_verifikasi_user->status === false) {
            $user->update([
                "kelas_id" => $validated["kelas_id"],
            ]);
            Mail_box::create([
                "title" => "Pendaftaran Kelas",
                "for_user_id" => $user->id,
                "messager_name" => "Kelas-Ku Bot",
                "isBendahara" => "system",
                "description" => "Pendaftaran Kelas Anda sedang di proses bendahara, silahkan menunggu"
            ]);
            return redirect(route('dashboard.pages.verifikasi_user.index'))->with("success", "Berhasil mendaftar kelas! Silahkan menunggu verifikasi bendahara");
        } else {
            return redirect(route('dashboard.pages.verifikasi_user.index'))->with("error", "Anda sudah terdaftar di kelas lain.");
        }
    }

    public function update($id)
    {
        try {
            $user = User::find($id);
            User::where('id', $id)->update([
                "status_verifikasi_kelas" => 1
            ]);
            Mail_box::create([
                "title" => "Pendaftaran Kelas",
                "for_user_id" => $user->id,
                "messager_name" => "Kelas-Ku Bot",
                "isBendahara" => "system",
                "description" => "Selamat, Pendaftaran Kelas Anda Diterima"
            ]);
            return redirect('verification-user')->with("success", "Siswa $user->name Berhasil di verifikasi!");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            // dd($user->kelas_id);
            User::where("id", $user->id)->update([
                "kelas_id" => null,
            ]);
            Mail_box::create([
                "title" => "Pendaftaran Kelas",
                "for_user_id" => $user->id,
                "messager_name" => "Kelas-Ku Bot",
                "isBendahara" => "system",
                "description" => "Maaf, Pendaftaran Kelas Anda Ditolak"
            ]);
            return redirect('/verification-user')->with("success", "Data Berhasil di hapus!");
        } catch (Exception $e) {
            return redirect(route('dashboard.pages.class'))->with("failed", "Data Gagal di hapus!");
        }
    }
}
