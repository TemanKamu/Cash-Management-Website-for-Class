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
use Illuminate\Support\Facades\Redirect;

class PemasukanController extends Controller
{
    private function getDifferenceInDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $differenceInDays = $start->diffInDays($end);
        return $differenceInDays;
    }
    public function index()
    {
        $datas = null;
        $kelas = ClassTable::where("id", Auth::user()->kelas_id)->first();
        if (request()->has("user") && request()->has("kelas_id") && request()->has("date_at") && request()->has("date_to") && request()->has("status_pembayaran")) {
            // $datas = request("user") === "all_user" ? Pemasukan::where("kelas_id", request('kelas_id')) : Pemasukan::where("kelas_id", request('kelas_id'))->where("user_id", request("user"));
            // Cek request apakah yang diminta salah satu user atau semua ?
            if (request("user") === "all_user") {
                $datas = Pemasukan::where("kelas_id", request('kelas_id'));
            } else {
                $user = User::where("uuid", request("user"))->first();
                $datas = Pemasukan::where("kelas_id", request('kelas_id'))->where("user_id", $user->id);
            }
            // Cek request metode pembayaran yang diminta cash, transfer atau semua ?
            $datas = request("metode_pembayaran") === "cash" ? $datas->where("metode_pembayaran", "cash") : (request("metode_pembayaran") === "transfer" ? $datas->where("metode_pembayaran", "transfer") : $datas);

            // encode status_pembayaran value
            $status_pembayaran = urldecode(request("status_pembayaran"));
            // Cek request apakah status pembayaran berhasil,pending,belum bayar atau all ?
            $datas = $status_pembayaran === "sudah bayar" ? $datas->where("status", "sudah bayar") : ($status_pembayaran === "belum bayar" ? $datas->where("status", "belum bayar") : (request("status_pembayaran") === "pending" ? $datas->where("status", "pending") : $datas));
            if (request()->filled("date_at") && request()->filled("date_to")) {
                $datas = $datas->whereBetween("created_at", [request("date_at"), request("date_to")]);
                $datas = $datas->orderBy("created_at", "asc")->get();
                $datas->userData = User::where("kelas_id", Auth::user()->kelas_id)->get();
                $datas->hargaKas = ClassTable::find(Auth::user()->kelas_id)->harga_kas;
                $datas->kelas = $kelas;
                return view("dashboard.pages.report.pemasukan.index", compact("datas"));
            } else {
                $datas = $datas->orderBy("created_at", "asc")->get();
                $datas->userData = User::where("kelas_id", Auth::user()->kelas_id);
                $datas->hargaKas = ClassTable::find(Auth::user()->kelas_id)->harga_kas;
                $datas->kelas = $kelas;
                return view("dashboard.pages.report.pemasukan.index", compact("datas"));
            }
        }

        if ($datas === null) {
            $datas = Pemasukan::where("kelas_id", Auth::user()->kelas_id)->whereDate("created_at", Carbon::today())->get();
            $datas->userData = User::where("kelas_id", Auth::user()->kelas_id)->get();
            $datas->hargaKas = ClassTable::find(Auth::user()->kelas_id)->harga_kas;
            $datas->kelas = $kelas;
            return view("dashboard.pages.report.pemasukan.index", compact("datas"));
        }
    }
    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        return view("dashboard.pages.report.pemasukan.create");
    }
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            // dd($request->all());
            $validated = $request->validate([
                "user_id" => "required|integer",
                "kelas_id" => "required|integer",
                "jumlah_pemasukan" => "required|integer",
            ]);
            $numberOfDays = $this->getDifferenceInDays($request->name_date_at, $request->name_date_to);

            $jumlah_pemasukan_pesan = $validated["jumlah_pemasukan"] * $numberOfDays;
            for ($i = 0; $i <= $numberOfDays; $i++) {
                $currentDate = Carbon::parse($request->name_date_at)->addDays($i);
                $pemasukan_data = Pemasukan::where("user_id", $validated["user_id"])
                    ->where("kelas_id", $validated["kelas_id"])
                    ->whereDate("created_at", $currentDate->toDateString())->first();
                $kelas = ClassTable::where("id", $validated["kelas_id"])->first();
                $pemasukanCondition = $jumlah_pemasukan_pesan === 0 ? $validated["jumlah_pemasukan"] : $jumlah_pemasukan_pesan;
                if ($pemasukan_data === null) {
                    Pemasukan::create([
                        "user_id" => $validated["user_id"],
                        "kelas_id" => $validated["kelas_id"],
                        "metode_pembayaran" => "cash",
                        "jumlah_pemasukan" => $validated["jumlah_pemasukan"],
                        "created_at" => $currentDate,
                        "updated_at" => $currentDate
                    ]);
                    History_activities::create([
                        "user_id" => $user->id,
                        "kelas_id" => $user->kelas_id,
                        "description" => "Bendahara " . $user->name . " Menambahkan pemasukan sebanyak " . $pemasukanCondition,
                        "isBendahara" => true
                    ]);
                    $kelas->update([
                        "saldo_fisik" => $kelas->saldo_fisik + $validated["jumlah_pemasukan"],
                    ]);
                } else if ($pemasukan_data->status === "belum bayar" && $pemasukan_data->metode_pembayaran === "cash") {
                    $pemasukan_data->update([
                        "user_id" => $validated["user_id"],
                        "kelas_id" => $validated["kelas_id"],
                        "metode_pembayaran" => "cash",
                        "jumlah_pemasukan" => $validated["jumlah_pemasukan"],
                        "status" => "sudah bayar",
                        "created_at" => $currentDate,
                        "updated_at" => $currentDate
                    ]);
                    History_activities::create([
                        "user_id" => $user->id,
                        "kelas_id" => $user->kelas_id,
                        "description" => "Bendahara " . $user->name . " Menambahkan pemasukan sebanyak " .  $pemasukanCondition,
                        "isBendahara" => true
                    ]);
                    $kelas->update([
                        "saldo_fisik" => $kelas->saldo_fisik + $validated["jumlah_pemasukan"],
                    ]);
                }
            }

            return redirect("/pemasukan")->with("success", "Berhasil menambahkan pemasukan!");
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function switch(Request $request, $id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $kelas = ClassTable::where("id", $request->kelas_id)->first();
        if ($request->status === "sudah bayar") {
            $pemasukan->update([
                "metode_pembayaran" => null,
                "status" => "belum bayar",
                "jumlah_pemasukan" => 0
            ]);
            $kelas->update([
                "saldo_fisik" => $kelas->saldo_fisik - $kelas->harga_kas
            ]);
            return Redirect::back();
        } else {
            $pemasukan->update([
                "metode_pembayaran" => "cash",
                "status" => "sudah bayar",
                "jumlah_pemasukan" => $kelas->harga_kas
            ]);
            $kelas->update([
                "saldo_fisik" => $kelas->saldo_fisik + $kelas->harga_kas
            ]);
            return Redirect::back();
        }
    }
    public function show(Pemasukan $pemasukan)
    {
        try {
            $data = Pemasukan::where("id", $pemasukan->id)->get();
            return view("dashboard.pages.report.pemasukan.show", compact("data"));
        } catch (Exception $e) {
            return redirect("dashboard.pages.report.pemasukan.index")->with("failed", "Gagal menampilkan pemasukan!");
        }
    }
    public function edit(Pemasukan $pemasukan)
    {
        $data = Pemasukan::where("id", $pemasukan->id)->get();
        return view("dashboard.pages.report.pemasukan.index", compact("data"));
    }
    public function update(Request $request, Pemasukan $pemasukan)
    {
        $user = Auth::user();
        $validated = $request->validate([
            "user_id" => "required|integer",
            "kelas_id" => "required|integer",
            "jumlah_pemasukan" => "required|integer",
        ]);
        $pemasukanUpdate = Pemasukan::where("id", $pemasukan->id)->update($validated);
        $kelas = ClassTable::where("id", $validated["kelas_id"])->first();
        $kelas->update([
            "saldo_fisik" => $kelas->saldo_fisik + $validated["jumlah_pemasukan"],
            "total_saldo" => $kelas->total_saldo + $validated["jumlah_pemasukan"]
        ]);

        History_activities::create([
            "user_id" => $user->id,
            "kelas_id" => $user->kelas_Id,
            "description" => "Bendahara" . $user->name . " mengubah pemasukan pada tanggal " . $pemasukanUpdate->created_at . "  pemasukan sebanyak " . $validated["jumlah_pemasukan"],
            "isBendahara" => true
        ]);
        return view("dashboard.pages.report.pemasukan.index")->with("success", "Berhasil mengubah pemasukan!");
    }
    public function updatePemasukanUserDate(Request $request)
    {
        $pemasukan = Pemasukan::findOrFail($request->id);
        $pemasukanDateFillable = Pemasukan::whereDate("created_at", $request->date)->first();
        $tanggal = $pemasukan->created_at;
        $user = User::where("uuid", $request->uuid)->first();
        $kelas = ClassTable::findOrFail($request->kelas_id);
        if ($pemasukanDateFillable === null) {
            $pemasukan->update([
                "created_at" => $request->date,
                "updated_at" => $request->date
            ]);
            Pemasukan::create([
                "user_id" => $user->id,
                "kelas_id" => $request->kelas_id,
                "metode_pembayaran" => null,
                "jumlah_pemasukan" => 0,
                "status" => "belum bayar",
                "created_at" => $tanggal,
            ]);
            return Redirect::back()->with("success", "Berhasil update data");
        } elseif ($pemasukanDateFillable) {
            $pemasukan->update([
                "metode_pembayaran" => null,
                "jumlah_pemasukan" => 0,
                "status" => "belum bayar"
            ]);
            if ($pemasukanDateFillable->status === "belum bayar") {
                $pemasukanDateFillable->update([
                    "metode_pembayaran" => "cash",
                    "jumlah_pemasukan" => $kelas->harga_kas,
                    "status" => "sudah bayar"
                ]);
            }

            return Redirect::back()->with("success", "Berhasil update data");
        }
    }
    public function getPemasukanByUser($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $datas = Pemasukan::where('user_id', $user->id)->where('kelas_id', $user->kelas_id)->get();
        return view('dashboard.pages.pemasukan-by-user.index', compact('datas'));
    }
    public function ingatkanPembayaran($id, Request $request)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $kelas = ClassTable::where("id", $pemasukan->kelas_id)->first();
        Mail_box::create([
            'title' => "Peringatan Pembayaran kas tanggal " . $pemasukan->created_at->formatLocalized('%e %B %Y'),
            "for_user_id" => $pemasukan->user_id,
            "isBendahara" => "true",
            "messager_name" => $request->messager_name,
            "description" => '<div class="container mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Pengingat Pembayaran Kas</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Halo ' . $pemasukan->user->name . ',</h4>
                        <p class="mb-0">Ini adalah pengingat lembut bahwa pembayaran bulanan untuk kas kelas akan jatuh tempo pada akhir minggu ini, tepatnya pada hari Jumat, tanggal ' . $pemasukan->created_at->formatLocalized('%e %B %Y') . '. Pastikan untuk membayar iuran kas Anda tepat waktu untuk menjaga kelancaran operasional kelas.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Detail Pembayaran:</h5>
                            <ul>
                                <li><strong>Jumlah:</strong> ' . number_format($kelas->harga_kas) . ',-</li>
                                <li><strong>Tangal:</strong> ' . $pemasukan->created_at->formatLocalized('%e %B %Y') . '</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Penting untuk Diperhatikan:</h5>
                            <ul>
                                <li>Harap segera lakukan pembayaran online / ke bendahara kelas jika Anda belum melakukannya.</li>
                                <li>Jika Anda mengalami kendala atau pertanyaan terkait pembayaran, jangan ragu untuk menghubungi bendahara.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p>Terima kasih atas perhatiannya, dan semoga kita dapat terus menjaga kebersamaan dan kemajuan kelas kita!</p>
                    <p>Salam hangat,<br>' . $pemasukan->user->name . '</p>
                </div>
            </div>
        </div>
        '
        ]);
        return back()->with("success", "User telah diperingatkan!");
    }
    public function destroy($id)
    {
        try {
            $pemasukan = Pemasukan::findOrFail($id);
            if ($pemasukan->metode_pembayaran === "transfer") {
                return redirect("/pemasukan")->with("error", "Pemasukan dengan metode pembayaran Transfer tidak bisa dihapus");
            } else {
                $pemasukan->delete();
                return redirect("/pengeluaran")->with("success", "Data berhasil dihapus !");
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}
