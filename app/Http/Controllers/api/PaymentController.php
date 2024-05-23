<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Payment;
use App\Models\Pemasukan;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    //
    var $apiInstance = null;
    // var $user = null;
    public function __construct()
    {
        Configuration::setXenditKey("xnd_development_ViM88Iq1PxUJ8VPPdMrcZSoGPUT6ODW0uOZzcNKTaMbSVYmGaKqXmeBtwu8v15");
        $this->apiInstance = new InvoiceApi();
        // $this->user = Auth::user();
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());
        // return response()->json($request->all());
        try {

            $user = User::where("uuid", $request->user)->first();
            $create_invoice_request = new CreateInvoiceRequest([
                "external_id" => (string) Str::uuid(),
                "description" => "BAYAR KAS",
                "amount" => $request->amount,
                "payer_email" => $request->email,
                "invoice_duration_days" => 3600,
                "customer" => [
                    "given_name" => $user->name,
                    "email" => $user->email,
                    "mobile_number" => "$user->no_hp",
                ]
            ]);
            $result = $this->apiInstance->createInvoice($create_invoice_request);

            $pemasukanData = Pemasukan::where("user_id", $user->id)->where("kelas_id", $user->kelas_id)->whereDate("created_at", $request->date ? Carbon::parse($request->date) : Carbon::today())->first();
            $pemasukan = null;
            if ($pemasukanData !== null) {
                $pemasukanData->update([
                    "status" =>  strtolower($result["status"]),
                    "metode_pembayaran" => "transfer",
                    "jumlah_pemasukan" => $request->amount,
                ]);
                $pemasukan = $pemasukanData->id;
            } else {
                $pemasukan = Pemasukan::create([
                    "user_id" => $user->id,
                    "kelas_id" => $user->kelas_id,
                    "jumlah_pemasukan" => $request->amount,
                    "status" =>  strtolower($result["status"]),
                    "metode_pembayaran" => "transfer",
                ]);
                $pemasukan = $pemasukan->id;
            }
            // Save to database
            Payment::create([
                "user_id" => $user->id,
                "pemasukan_id" => $pemasukan,
                "external_id" => $create_invoice_request["external_id"],
                "checkout_link" => $result["invoice_url"],
                "expired_date" => $result['expiry_date'],
                "amount" => $result['amount'],
                "status" => strtolower($result["status"]),
            ]);
            
            return response()->json($result["invoice_url"]);
            // return redirect($result["invoice_url"]);
        } catch (Exception $e) {
            return  response()->json($e->getMessage());
        }
    }

    public function notification(Request $request)
    {
        try {
            $result = $this->apiInstance->getInvoices(null, $request->external_id);
            // Get data
            $payment = Payment::where('external_id', $request->external_id)->firstOrFail();
            $pemasukan = Pemasukan::where('id', $payment->pemasukan_id)->firstOrFail();
            // Update status;
            if ($result[0]["status"] === 'SETTLED' || $result[0]["status"] === 'PAID') {
                $pemasukan->update([
                    'status' => 'sudah bayar',
                ]);
                $payment->status = "PAID";
                $payment->save();
                $kelas = ClassTable::where("id", $pemasukan->kelas_id)->first();
                $kelas->update([
                    "saldo_digital" => $kelas->saldo_digital + $payment->amount
                ]);
                History_activities::create([
                    "user_id" => $pemasukan->user_id,
                    "kelas_id" => $pemasukan->kelas_id,
                    "isBendahara" => 0,
                    "description" => $pemasukan->user->name . " Menambahkan pemasukan sebanyak $payment->amount",
                ]);
                return response()->json("success");
            }
        } catch (\Xendit\XenditSdkException $e) {
            return response()->json($e->getMessage());
        }
    }
}
