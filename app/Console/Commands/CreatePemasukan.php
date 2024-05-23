<?php

namespace App\Console\Commands;

use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Pemasukan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreatePemasukan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-pemasukan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $kelas = ClassTable::all();
            $wita_now = Carbon::now()->timezone('Asia/Makassar');
            if ($kelas !== null) {
                foreach ($kelas as $dataKelas) {
                    $user = User::where("kelas_id", $dataKelas->id)->get();
                    foreach ($user as $dataUser) {
                        $pemasukanOnFuture = Pemasukan::where('user_id', $dataUser->id)->where('kelas_id', $dataKelas->id)
                            ->whereDate('created_at', $wita_now->toDateString())
                            ->first();
                        if ($pemasukanOnFuture === null) {
                            // Log::error("user belum memiliki pemasukan");
                            Pemasukan::create([
                                "user_id" => $dataUser->id,
                                "kelas_id" => $dataKelas->id,
                                "metode_pembayaran" => null,
                                "jumlah_pemasukan" => 0,
                                "status" => "belum bayar",
                                "created_at" => $wita_now->toDateString(),
                                "updated_at" => $wita_now->toDateString(),
                            ]);
                         
                        }
                    }
                }
            } else {
                Log::info('Kelas masih kosong');
            }
        } catch (\Exception $e) {
            Log::error('Error occurred in scheduler: ' . $e->getMessage());
            // Anda juga bisa tambahkan tindakan lain seperti notifikasi atau rollback transaksi jika diperlukan
        }
    }
}
