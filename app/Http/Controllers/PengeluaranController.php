<?php

namespace App\Http\Controllers;

use App\Models\ClassTable;
use App\Models\Pengeluaran;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{

    public function index()
    {
        try {
            $datas = null;
            if (request()->has("user") && request()->has("jenis_pengeluaran") && request()->has("status")) {
                // dd(request()->all());
                if (request("user") === "all_user") {
                    $datas = Pengeluaran::where("kelas_id", request('kelas_id'));
                } else {
                    $user = User::where("uuid", request("user"))->first();
                    $datas = Pengeluaran::where("kelas_id", request('kelas_id'))->where("user_id", $user->id);
                }

                // Cek request metode pembayaran yang diminta cash, transfer atau semua ?
                $datas = request("jenis_pengeluaran") === "cash" ? $datas->where("jenis_pengeluaran", "cash") : (request("jenis_pengeluaran") === "transfer" ? $datas->where("jenis_pengeluaran", "transfer") : $datas);

                // Cek status
                $datas = request("status") === "all_status" ? $datas : $datas->where("status", request("status"));
                if (request()->filled("date_at") && request()->filled("date_to")) {
                    $datas = $datas->whereBetween("created_at", [request("date_at"), request("date_to")])->get();
                    $datas->userData = User::where("kelas_id", Auth::user()->kelas_id)->get();
                    return view("dashboard.pages.report.pengeluaran.index", compact("datas"));
                } else {
                    $datas = $datas->get();
                    $datas->userData = User::where("kelas_id", Auth::user()->kelas_id)->get();
                    return view("dashboard.pages.report.pengeluaran.index", compact("datas"));
                }
            }
            if ($datas === null) {
                $datas = Pengeluaran::with('user')->orderBy("created_at", "desc")->get();
                $datas->userData = User::where("kelas_id", Auth::user()->id)->get();

                return view("dashboard.pages.report.pengeluaran.index", compact("datas"));
            }
        } catch (Exception $e) {
            dd($e);
            // return redirect("/home")->with("failed", "Gagal menampilkan pengeluaran, Coba lagi!");
        }
    }
    public function create()
    {
        return view("dashboard.pages.report.pengeluaran.create");
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $user = User::where("uuid", $request->user)->first();
            $validate = $request->validate([
                "user" => "required|uuid",
                "kelas_id" => "required|integer",
                "deskripsi" => "required",
                "jumlah_pengeluaran" => "required|integer",
                "date" => "required|date",
            ]);
            $kelas = ClassTable::where("id", $validate["kelas_id"])->first();
            if ($kelas->saldo_fisik < $validate["jumlah_pengeluaran"]) {
                return redirect("/pengeluaran")->with('failed', "Saldo cash tidak mencukupi");
            } else {

                Pengeluaran::create([
                    "user_id" => $user->id,
                    "kelas_id" => $validate["kelas_id"],
                    "deskripsi" => $validate["deskripsi"],
                    "jumlah_pengeluaran" => $validate["jumlah_pengeluaran"],
                    "status" => "berhasil",
                    "created_at" => $validate["date"],
                    "updated_at" => $validate["date"],
                ]);
                ClassTable::where("id", $validate["kelas_id"])
                    ->update([
                        "saldo_fisik" => $kelas->saldo_fisik - $validate["jumlah_pengeluaran"]
                    ]);

                return redirect("/pengeluaran")->with("success", "Berhasil menambahkan pengeluaran!");
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::where("id", $id)->first();
        $kelas = ClassTable::where("id", $request->kelas_id)->first();
        if ($request->jumlah_pengeluaran > $kelas->saldo_fisik) {
            return redirect("/pengeluaran")->with('failed', "Saldo cash tidak mencukupi");
        }
        $updatePengeluaran = $request->jumlah_pengeluaran - $pengeluaran->jumlah_pengeluaran;
        $pengeluaran->update([
            "jumlah_pengeluaran" => $request->jumlah_pengeluaran,
            "deskripsi" => $request->deskripsi,
            "created_at" => $request->date,
        ]);
        $kelas->update([
            "saldo_fisik" => $updatePengeluaran < 0 ? $kelas->saldo_fisik + $updatePengeluaran : $kelas->saldo_fisik - $updatePengeluaran
        ]);
        return redirect("/pengeluaran")->with("success", "Berhasil mengubah pengeluaran!");
    }



    /**
     * Remove the resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::where("id", $id)->first();
        $jumlah_pengeluaran = $pengeluaran->jumlah_pengeluaran;
        $kelas = ClassTable::where("id", $pengeluaran->kelas_id)->first();

        $pengeluaran->delete();
        $kelas->update([
            "saldo_fisik" => $kelas->saldo_fisik + $jumlah_pengeluaran
        ]);
        return redirect("/pengeluaran")->with("success", "Berhasil menghapus pengeluaran!");
    }
}
