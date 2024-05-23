<?php

namespace App\Http\Controllers;

use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Mail_box;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\search;

class ClassController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manage_class.index');
    }
    public function create()
    {
        return view("dashboard.pages.manage_class.create");
    }
    public function store(Request $request)
    {

        $user = Auth::user();
        if ($user->kelas_id) {
            return redirect("/welcome/join")->with("error", "Kamu sudah terdaftar di kelas lain!");
        }
        $kode_kelas_cek = random_int(1000, 9999);
        $kode_kelas = null;
        if (ClassTable::where('kode_kelas', $kode_kelas_cek)->first() === null) {
            $kode_kelas = random_int(1000, 9999);
        }
        $profile_kelas = null;
        $validate = $request->validate([
            "nama_kelas" => "required",
            "deskripsi" => "required",
            // "tipe_kas" => "required",
            "harga_kas" => "required|integer",
            "profile_kelas" => "required|file|max:4096|mimes:jpg,jpeg,png",
            "jumlah_maksimal_siswa" => "required|integer",
            "payout_password" => "required",
        ]);
        if ($request->file("profile_kelas")) {
            $validate['profile_kelas'] = $request->file('profile_kelas')->store('public/image');
            $profile_kelas = $validate['profile_kelas'];
        }
        $validate['payout_password'] = Hash::make($validate['payout_password']);

        $data = ClassTable::create([
            "kode_kelas" => $kode_kelas,
            "nama_kelas" => $validate["nama_kelas"],
            "deskripsi" => $validate["deskripsi"],
            "profile_kelas" => $profile_kelas,
            // "tipe_kas" => $validate["tipe_kas"],
            "harga_kas" => $validate["harga_kas"],
            "jumlah_maksimal_siswa" => $validate["jumlah_maksimal_siswa"],
            "payout_password" => $validate["payout_password"],
            "owner_room_id" => $user->id,
        ]);
        User::where("id", $user->id)->update([
            "kelas_id" => $data->id,
            "isBendahara" => true,
            "status_verifikasi_kelas" => true
        ]);
        return redirect('/welcome');
    }


    public function show()
    {
        if (request()->has('search')) {
            if (request('search') == null) {
                return redirect("/welcome/join")->with("error_internal", "Harap isi kolom pencarian!");
            }
            $datas = ClassTable::where('kode_kelas', 'like', '%' . request('search') . '%')->first();
            if ($datas === null) {
                return redirect("/welcome/join")->with("error", "Kelas tidak ditemukan!");
            } else {
                $user = User::where('id', $datas->owner_room_id)->first();
                $datas->owner_room_name = $user->name;
                return redirect('/welcome/join')->with(compact("datas"))->with("success", "Data ditemukan!");
            }
        }

        return view('dashboard.pages.manage_class.join');
    }

    public function edit(ClassTable $classTable)
    {
        return view("dashboard.pages.class.update", compact("classTable"));
    }
    public function update(Request $request, ClassTable $classTable)
    {
        $validate = $request->validate([
            "nama_kelas" => "required",
            "profile_kelas" => "required|files|max:4096|mimes:jpg,jpeg,png",
            "kas_per_hari" => "required|integer",
            "deskripsi" => "required",
            "jumlah_maksimal" => "required|integer",
        ]);
        if ($request->hasFile('profile_kelas')) {
            Storage::delete($classTable->image);
            $validate['image'] = $request->file('profile_kelas')->store('public/image');
        }
        ClassTable::where("id", $classTable)->update($request->all());
        return redirect("dashboard.pages.class.index")->with("success", "Data berhasil di update!");
    }
    public function join(Request $request, $id)
    {
        $user =  User::where('id', $request->user_id)->first();
        $kelas = ClassTable::where("id", $id)->first();
        $countUser = User::where("kelas_id", $id)->count();
        if ($user->kelas_id) {
            return redirect("/welcome/join")->with("error", "Kamu sudah terdaftar di kelas lain!");
        } else if ($kelas->jumlah_maksimal === $countUser) {
            return redirect("/welcome/join")->with("error", "Kelas sudah penuh!");
        } else {
            User::where('id', $request->user_id)->update([
                "kelas_id" => $kelas->id,
            ]);
            Mail_box::create([
                "title" => "Pendaftaran Kelas",
                "for_user_id" => $request->user_id,
                "messager_name" => "Kelas-Ku Bot",
                "isBendahara" => "system",
                "description" => "Pendaftaran Kelas Anda sedang di proses bendahara, Silahkan menunggu"
            ]);
            return redirect('/welcome');
        }
    }
}
