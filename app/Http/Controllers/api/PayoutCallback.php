<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Payout;
use App\Models\Pengeluaran;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xendit\Configuration;
use Illuminate\Support\Str;
use Xendit\Payout\PayoutApi;
use Xendit\Payout\CreatePayoutRequest;



class PayoutCallback extends Controller
{
    //
    var $apiInstance = null;
    // var $user = null;
    public function __construct()
    {
        Configuration::setXenditKey("xnd_development_ViM88Iq1PxUJ8VPPdMrcZSoGPUT6ODW0uOZzcNKTaMbSVYmGaKqXmeBtwu8v15");
        $this->apiInstance = new PayoutApi();
        // $this->user = Auth::user();
    }

    public function notification(Request $request)
    {
        try {
            $result = $this->apiInstance->getPayouts($request->data["reference_id"], null);
            // Get data
            $payout = Payout::where('external_id', $request->data["reference_id"])->firstOrFail();
            $pengeluaran = Pengeluaran::where('id', $payout->pengeluaran_id)->firstOrFail();
            $kelas = ClassTable::where('id', $payout->user->kelas_id)->firstOrFail();
            if ($result["data"][0]["status"] == 'SETTLED' || $result["data"][0]["status"] == 'SUCCEEDED') {
                if ($pengeluaran->status !== "berhasil" && $payout->status !== "succeeded" || $payout->status !== "settled") {
                    $payout->status = strtolower($result["data"][0]["status"]);
                    $payout->save();
                    $pengeluaran->update([
                        "status" => "berhasil"
                    ]);
                    $kelas->update([
                        "saldo_digital" => $kelas->saldo_digital - $payout->amount
                    ]);
                }
            }
            return response()->json('success');
        } catch (\Xendit\XenditSdkException $e) {
            echo 'Exception when calling PayoutApi->createPayout: ', $e->getMessage(), PHP_EOL;
            echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
        }
    }
}
