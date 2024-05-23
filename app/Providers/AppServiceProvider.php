<?php

namespace App\Providers;

use App\Models\Mail_box;
use App\Models\Payment;
use App\Models\Pemasukan;
use App\Models\UserLeave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Gunakan wildcard * untuk menyematkan data ke setiap view yang memasukkan navbar
        View::composer('dashboard.partials.navbar', function ($view) {


            $user = Auth::user();
            $mailData = Mail_box::where("for_user_id", $user->id)->get();
            $message = null;
            $data = null;
            $bayarKas = Pemasukan::where("id", Auth::user()->id)->whereDate("created_at", Carbon::today())->where("status", "sudah bayar")->first();
            $humanReadableDate = null;
            if ($mailData->isEmpty()) {
                $data =  [
                    "bayar_kas" => $bayarKas ? true : false,
                    "status" => "off",
                    "message" => "No message",
                    "time" => "",
                ];
            } else {
                $mails = Mail_box::where("for_user_id", Auth::user()->id)->take(3)->latest()->get();
                $message = null;
                // Jika pesan ditemukan, gunakan created_at dari pesan tersebut
                if ($mails) {
                    $mailOnMap = $mails->map(function ($mail) {
                        // Parse created_at dan ubah formatnya
                        $createdAt = Carbon::parse($mail->created_at);
                        $mail->human_readable_date = $createdAt->diffForHumans();
                        unset($mail->created_at);

                        return $mail;
                    });

                    $message = $mailOnMap;
                } else {
                    $humanReadableDate = "";
                    $message = null;
                }

                // Kemas data yang akan disematkan ke navbar
                $data = [
                    "bayar_kas" => $bayarKas ? true : false,
                    "status" => $mailData ? "on" : "off",
                    "message" => $message,
                ];
            }

            $view->with('navbarData', $data);
        });

        View::composer('dashboard.layout.index', function ($view) {
            $pemasukan = Pemasukan::where("user_id", Auth::user()->id)->where("kelas_id", Auth::user()->kelas_id)->whereDate("created_at", Carbon::today())->where("status", "sudah bayar")->first();
            $data = null;
            if ($pemasukan && $pemasukan->metode_pembayaran == "transfer") {
                $data = Payment::where("user_id", Auth::user()->id)->where("pemasukan_id", $pemasukan->id)->first();
            } else if ($pemasukan && $pemasukan->metode_pembayaran == "cash") {
                $data = $pemasukan;
            }
            $view->with('pemasukanData', $data);
        });
        View::composer('dashboard.partials.sidebar', function ($view) {
            $data = UserLeave::where("user_id", Auth::user()->id)->first();
            $view->with('leaveData', $data);
        });
    }
}
