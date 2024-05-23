<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        try {
            $kelas = ClassTable::where("kode_kelas", $id)->first();

            $totalPemasukanPerBulan = [];
            for ($bulan = 1; $bulan <= date('n'); $bulan++) {
                $tahun = date('Y');
                $bulanFormat = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                $totalPemasukan = Pemasukan::where(DB::raw('MONTH(created_at)'), $bulan)
                    ->where("kelas_id", $kelas->id)
                    ->where("status", "sudah bayar")
                    ->where(DB::raw('YEAR(created_at)'), $tahun)
                    ->sum('jumlah_pemasukan');
                $totalPemasukanPerBulan[] = $totalPemasukan;
            }
            $totalPengeluaranPerBulan = [];
            for ($bulan = 1; $bulan <= date('n'); $bulan++) {
                $tahun = date('Y');
                $bulanFormat = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                $totalPengeluaran = Pengeluaran::where(DB::raw('MONTH(created_at)'), $bulan)
                    ->where("kelas_id", $kelas->id)
                    ->where("status", "berhasil")
                    ->where(DB::raw('YEAR(created_at)'), $tahun)
                    ->sum('jumlah_pengeluaran');
                $totalPengeluaranPerBulan[] = $totalPengeluaran;
            }

            // Donut chart
            // Ambil data pemasukan dan pengeluaran dari database (misalnya)
            $totalPemasukan = Pemasukan::where("kelas_id", $kelas->id)->whereYear('created_at', now()->year)->sum('jumlah_pemasukan');
            $totalPengeluaran = Pengeluaran::where("kelas_id", $kelas->id)->whereYear('created_at', now()->year)->sum('jumlah_pengeluaran');

            // Hitung persentase pemasukan dan pengeluaran
            $total = $totalPemasukan + $totalPengeluaran;
            $persentasePemasukan = ($totalPemasukan / $total) * 100;
            $persentasePengeluaran = ($totalPengeluaran / $total) * 100;

            // Format data output
            $output = [
                round($persentasePemasukan, 2), // Pemasukan
                round($persentasePengeluaran, 2), // Pengeluaran
            ];
            $datas = [
                "totalPemasukanPerBulan" => $totalPemasukanPerBulan,
                "totalPengeluaranPerBulan" => $totalPengeluaranPerBulan,
                "donut_data" => $output
            ];
            return response()->json($datas);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
