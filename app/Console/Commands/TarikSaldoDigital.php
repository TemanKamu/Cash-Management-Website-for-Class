<?php

namespace App\Console\Commands;

use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Mail_box;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TarikSaldoDigital extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tarik-saldo-digital';

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
            foreach ($kelas as $dataKelas) {
                $user = User::where('kelas_id', $dataKelas->id)->get();
                $potong_saldo = 12000;
                $saldo = $dataKelas->saldo_digital;

                if (!$saldo < 100000) {
                    ClassTable::where("id", $dataKelas->id)->update([
                        "saldo_digital" => $saldo - $potong_saldo
                    ]);
                    foreach ($user as $dataUser) {
                        Mail_box::create([
                            "user_id" => $dataUser->id,
                            "description" => "Saldo kelas " . $dataKelas->name . " telah dikurangi sebesar Rp " . number_format($potong_saldo) . " Oleh sistem"
                        ]);
                    }
                    History_activities::create([
                        "system_message" => 1,
                        "user_id" => 0,
                        "kelas_id" => $dataKelas->id,
                        "isBendahara" => 0,
                        "description" => "Saldo kelas " . $dataKelas->nama_kelas . " telah dikurangi sebesar Rp " . number_format($potong_saldo) . " Oleh sistem"

                    ]);
                } else {
                    Log::info('Saldo kelas ' . $dataKelas->id . ' kurang dari 100.000');
                }
            }
        } catch (Exception $e) {
            Log::error('Error occurred in scheduler: ' . $e->getMessage());
        }
    }
}
