<?php

namespace App\Http\Controllers;

use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Mail_box;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageClassController extends Controller
{

    public function index()
    {
        $kelas = ClassTable::where("id", Auth::user()->kelas_id)->first();
        if (request()->has('pages')) {
            if (request('pages') === "laporan") {
                return redirect()->route('get-laporan', $kelas->kode_kelas);
            }
        }
        return redirect()->route('home.show',  $kelas->kode_kelas);
    }
    public function manageStudent()
    {
        if (request()->has("user") && request()->has("jabatan")) {
            $datas = null;
            $keyword = request("user");
            if (request("jabatan") === "all_jabatan") {
                $datas = User::where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%")
                        ->orWhere('no_hp', 'LIKE', "%$keyword%");
                })->get();
            } else {
                $datas = User::where('isBendahara', request("jabatan"))
                    ->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%")
                            ->orWhere('email', 'LIKE', "%$keyword%")
                            ->orWhere('no_hp', 'LIKE', "%$keyword%");
                    })->get();
            }
            return view('dashboard.pages.manage_student.index', compact('datas'));
        }
        $datas = User::where('kelas_id', Auth::user()->id)->where('status_verifikasi_kelas', 1)->get();
        return view('dashboard.pages.manage_student.index', compact('datas'));
    }
    public function verificationStudent()
    {
        return view('dashboard.pages.manage_student_verification.index');
    }
    public function kickSiswa(Request $request)
    {
        $user = User::where('id', $request->siswa_id)->first();
        $bendahara = User::where('id', $request->bendahara_id)->first();
        // dd($request->all());
        User::where('id', $request->siswa_id)->update([
            "kelas_id" => null,
            "status_verifikasi_kelas" => 0
        ]);
        History_activities::create([
            "user_id" => $request->bendahara_id,
            "kelas_id" => $bendahara->kelas_id,
            "isBendahara" => true,
            "description" => "Bendahara " . $bendahara->name . " telah mengeluarkan " . $user->name . ' dari kelas dengan alasan "' . $request->alasan . '"'
        ]);
        Mail_box::create([
            "title" => "Anda dikeluarkan dari kelas",
            "for_user_id" => $user->id,
            "messager_name" => "Kelas-Ku Bot",
            "isBendahara" => "system",
            "description" => "Anda telah di keluarkan dari kelas. Dikarenakan : <span class='font-weight-bold'> $request->alasan </span>"
        ]);
        return redirect('/home/manage-user');
    }

    public function getLaporan($kode_kelas)
    {
        $user = null;
        if (request()->has('laporan')) {
            if (request('laporan') === 'pemasukan') {
                $user = User::where('kelas_id', Auth::user()->kelas_id)->where('status_verifikasi_kelas', 1)->get();
            } else if (request('laporan') === 'pengeluaran') {
                $user = User::where('kelas_id', Auth::user()->kelas_id)->where('status_verifikasi_kelas', 1)->where("isBendahara", 1)->get();
            }
        } else {
            $user = User::where('kelas_id', Auth::user()->kelas_id)->where('status_verifikasi_kelas', 1);
            if (Auth::user()->isBendahara === 1) {
                $user = $user->get();
            } else {
                $user = $user->where('isBendahara', 1)->get();
            }
        }
        return view('dashboard.pages.report.index', compact('user'));
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    public function show($id)
    {
        $idToInt = intval($id);
        $kelas = ClassTable::where("kode_kelas", $idToInt)->first();
        if ($kelas === null) {
            if (Auth::user()->kelas_id === null || Auth::user()->kelas_id === 0) {
                return redirect('/welcome');
            } else {
                return redirect('/home');
            }
        }
        $dataPengeluaran = Pengeluaran::where('kelas_id', $kelas->id)->get();
        $datas = [
            "jumlah_saldo" => $kelas->saldo_digital + $kelas->saldo_fisik,
            "saldo_fisik" => $kelas->saldo_fisik,
            "saldo_digital" => $kelas->saldo_digital,
            "jumlah_pengeluaran" => $dataPengeluaran->sum('jumlah_pengeluaran'),
            "jumlah_siswa" => User::where("kelas_id", $kelas->id)->where("status_verifikasi_kelas", 1)->count(),
            "riwayat_pemasukan" => Pemasukan::where("kelas_id", $kelas->id)->whereDate("created_at", Carbon::today())->get(),
            "jumlah_maksimal_siswa" => $kelas->jumlah_maksimal_siswa,
            "kode_kelas" => $id
        ];
        return view("dashboard.pages.class.index", compact('datas'));
    }
    public function edit($id)
    {
        $data = null;
        if (Auth::user()->kelas_id !== $id) {
            $data = ClassTable::where("id", Auth::user()->kelas_id)->first();
        } else {
            $data = ClassTable::where("id", $id)->first();
        }
        $user = User::where("id", $data->owner_room_id)->first();
        $data->owner_name = $user->name;
        return view('dashboard.pages.class.edit', compact('data'));
    }
    public function update($id, Request $request)
    {
        $validate = $request->validate([
            "nama_kelas" => "required",
            "jumlah_maksimal_siswa" => "required|integer",
            "harga_kas" => "required|integer",
            "deskripsi" => "required",
        ]);
        ClassTable::where("id", $id)->update([
            "nama_kelas" => $validate["nama_kelas"],
            "jumlah_maksimal_siswa" => $validate["jumlah_maksimal_siswa"],
            "deskripsi" => $validate["deskripsi"],
            "harga_kas" => $validate["harga_kas"],
        ]);
        return redirect("/home/$id/edit");
    }
    public function resetKodeKelas($kode_kelas)
    {
        $kode_kelas_cek = random_int(1000, 9999);;
        while (ClassTable::where('kode_kelas', $kode_kelas_cek)->first() !== null) {
            $kode_kelas_cek = random_int(1000, 9999);
        }
        ClassTable::where('kode_kelas', $kode_kelas)->update([
            'kode_kelas' => $kode_kelas_cek
        ]);
        $kelas = ClassTable::where('kode_kelas', $kode_kelas_cek)->first();
        return redirect("/home/$kelas->id/edit");
    }
    public function editProfile(Request $request)
    {
        try {
            $validate = $request->validate([
                "profile_kelas" => "image",
                "kelas_id" => "required|integer",
            ]);
            if ($request->hasFile('profile_kelas')) {
                $kelas = ClassTable::where("id", $request->kelas_id)->first();

                Storage::delete($kelas->profile_kelas);
                $validate['profile_kelas'] = $request->file('profile_kelas')->store('public/image');
                $profile_kelas = $validate['profile_kelas'];

                // Lakukan operasi lain sesuai kebutuhan (misalnya, menyimpan nama file ke database)
                $kelas->update(['profile_kelas' => $profile_kelas]);
            }
            return redirect("/home/$request->kelas_id/edit");
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    // /**
    //  * Remove the resource from storage.
    //  */
    // public function destroy(): never
    // {
    //     abort(404);
    // }
}
