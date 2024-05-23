<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClassTable;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function checkUser(Request $request)
    {
        try {
            $kelas = ClassTable::where("kode_kelas", intval($request->kode_kelas))->first();
            $user = User::where("kelas_id", $kelas->id)->where('email', $request->email)->first();
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(null);
        }
    }
    public function getData(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'laporan' => "required",
                "kode_kelas" => "required",
                "user" => "required",
                "status" => "required",
                "metode_pembayaran" => "required",
                "date_at" => "required",
                "date_to" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $datas = null;
            $user = User::where('uuid', $request->user)->first();
            $kelas = ClassTable::where("kode_kelas", $request->kode_kelas)->first();
            if ($request->laporan === "pemasukan") {
                $datas = $request->user === "all_user" ? Pemasukan::where("kelas_id", $kelas->id) : Pemasukan::where("user_id", $user->id)->where("kelas_id", $kelas->id);
                $datas = $request->status === "all_status" ? $datas : $datas->where("status", $request->status);
                $datas = $request->metode_pembayaran === "all_metode" ? $datas : $datas->where("metode_pembayaran", $request->metode_pembayaran);
                $datas = DB::table('pemasukan')
                    ->join('users', 'pemasukan.user_id', '=', 'users.id')
                    ->whereBetween('pemasukan.created_at', [$request->date_at, $request->date_to])
                    ->select('users.name as user_name', 'pemasukan.metode_pembayaran', 'pemasukan.status', 'pemasukan.jumlah_pemasukan', 'pemasukan.created_at');
                // Pilih kolom yang ingin Anda sertakan
                $datas = $datas->get();
            } else if ($request->laporan === "pengeluaran") {
                $datas = $request->user === "all_user" ? Pengeluaran::where("kode_kelas", $request->kode_kelas) : Pengeluaran::where("user_id", $user->id)->where("kelas_id", $kelas->id);
                $datas = $request->status === "all_status" ? $datas : $datas->where("status", $request->status);
                $datas = $request->metode_pembayaran === "all_metode" ? $datas : $datas->where("jenis_pengeluaran", $request->metode_pembayaran);
                $datas = DB::table('pengeluaran')
                    ->join('users', 'pengeluaran.user_id', '=', 'users.id')
                    ->whereBetween('pengeluaran.created_at', [$request->date_at, $request->date_to])
                    ->select('users.name as user_name', 'pengeluaran.jenis_pengeluaran', 'pengeluaran.status', 'pengeluaran.jumlah_pengeluaran', 'pengeluaran.created_at');
                $datas = $datas->get();
            }
            return response()->json($datas, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
