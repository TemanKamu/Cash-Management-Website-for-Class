<?php

namespace App\Http\Controllers;

use App\Models\Channel_payout;
use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Payout;
use App\Models\Pengeluaran;
use Xendit\Xendit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Payout\PayoutApi;
use Xendit\Payout\CreatePayoutRequest;

class PayoutController extends Controller
{
    var $apiInstance = null;
    public function __construct()
    {
        Configuration::setXenditKey("xnd_development_ViM88Iq1PxUJ8VPPdMrcZSoGPUT6ODW0uOZzcNKTaMbSVYmGaKqXmeBtwu8v15");
        $this->apiInstance = new PayoutApi();
    }
    public function goToInvoice(Request $request)
    {
        $data = $request->all();
        $kelas = ClassTable::where("id", $request->kelas_id)->first();
        if (Hash::check($request->payout_password, $kelas->payout_password)) {
            if(intval($request->amount) > $kelas->saldo_digital){
                return back()->with("nominal", true);
            }
            $data["kelas"] = ClassTable::where("id", Auth::user()->kelas_id)->first();
            return view("dashboard.another_page.payoutSuccess", compact("data"));
        } else {
            return back()->with("password", true);
        }
    }
    public function store(Request $request)
    {
        try {
            $external_id = "TEST-" . (string) Str::uuid();
            $create_payout_request = new CreatePayoutRequest([
                'reference_id' => $external_id,
                'amount' => intval($request->amount),
                'channel_code' => $request->channel_code,
                'channel_properties' => [
                    'account_number' => $request->account_number,
                    'account_holder_name' => $request->account_name,
                ],
                'description' => $request->description,
                'currency' => 'IDR',
            ]);
            $channel = Channel_payout::where("code_channel", $request->channel_code)->first();
            $result = $this->apiInstance->createPayout($external_id, null, $create_payout_request);
            $kelas = ClassTable::where("id", $request->kelas_id)->first();
            $payout = Payout::where("kelas_id", $request->kelas_id)->where("status", '!=', 'settled')->orWhere("status", '!=', "paid")->select("amount")->get();
            $jumlah_pengeluaran = 0;
            foreach ($payout as $item) {
                $jumlah_pengeluaran += $item->amount;
            };
            if ($jumlah_pengeluaran > $kelas->saldo_digital) {
                return redirect("/home")->with("error", "Jumlah pengeluaran dengan status pending melebihi saldo digital");
            } elseif ($jumlah_pengeluaran + intval($request->amount) > $kelas->saldo_digital) {
                return redirect("/home")->with("error", "Jumlah pengeluaran melebihi saldo digital");
            }
            $pengeluaran = Pengeluaran::create([
                "user_id" => $request->user_id,
                "kelas_id" => $request->kelas_id,
                "jenis_pengeluaran" => "transfer",
                "deskripsi" => $request->description,
                "jumlah_pengeluaran" => $request->amount,
                "status" => "pending"
            ]);
            Payout::create([
                'user_id' => $request->user_id,
                'kelas_id' => $request->kelas_id,
                'channel_payout_id' => $channel->id,
                'pengeluaran_id' => $pengeluaran->id,
                'external_id' => $external_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'status' => "pending"
            ]);
            History_activities::create([
                'user_id' => $request->user_id,
                "kelas_id" => $request->kelas_id,
                "isBendahara" => 1,
                "description" => "Saldo digital telah di cairkan sebanyak " . $request->amount,
            ]);
            // return view("dashboard.another_page.payoutSuccess");
            return redirect("/home");
        } catch (\Xendit\XenditSdkException $e) {
            echo 'Exception when calling PayoutApi->createPayout: ', $e->getMessage(), PHP_EOL;
            echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
        }
    }


    public function notification(Request $request)
    {
        try {
            $result = $this->apiInstance->getPayoutById($request->id, null);
            // Get data

            $payout = Payout::where('external_id', $request->reference_id)->firstOrFail();
            $kelas = ClassTable::where('id', $payout->user->kelas_id)->firstOrFail();
            if ($payout->status == 'SUCCEEDED') {
                $kelas->update([
                    "saldo_digital" => $kelas->saldo_digital - $payout->amount
                ]);
                // Update status
                $payout->status = strtolower($result['status']);
                $payout->save();
            }
            return response()->json($result);
        } catch (\Xendit\XenditSdkException $e) {
            echo 'Exception when calling PayoutApi->createPayout: ', $e->getMessage(), PHP_EOL;
            echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
        }
    }
}
