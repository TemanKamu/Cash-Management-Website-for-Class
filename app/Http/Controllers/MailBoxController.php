<?php

namespace App\Http\Controllers;

use App\Models\Mail_box;
use App\Models\User;
use Exception;
use Illuminate\Console\View\Components\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailBoxController extends Controller
{
    var $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function index()
    {
        $data = Mail_box::where("for_user_id", Auth::user()->id)->get();
        if (request()->has("email_id")) {
            $data->mail_detail = Mail_box::where("id", request("email_id"))->first();
            Mail_box::where("id", request("email_id"))->update([
                "isRead" => 1
            ]);
        }
        if (request()->has("search")) {
            $data = $data->search(request()->search);
        }
        return view("dashboard.pages.mail.index", compact("data"));
    }
    public function create()
    {
        return view("dashboard.pages.mailbox.create");
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                "user_id" => "required|integer",
                "description" => "required",
            ]);
            Mail_box::create($validated);
            return redirect("dashboard.pages.class.index")->with("success", "Pesan berhasil terkirim");
        } catch (Exception $e) {
            return redirect("dashboard.pages.class.index")->with("failed", "Pesan gagal terkirim");
        }
    }
    public function show($id)
    {
        $data = Mail_box::where("id", $id)->get();
        return view("dashboard.pages.mailbox.detail", compact("data"));
    }
    public function edit(Mail_box $mail_box)
    {
        if ($this->user->kelas_id && $this->user->status_verifikasi_kelas === true) {
            return view("dashboard.mailbox.update", compact("mail_box"));
        } else {
            return view("dashboard.index");
        }
    }
    public function update(Request $request, Mail_box $mail_box)
    {
        try {
            $validate = $request->validate([
                "user_id" => "required|integer",
                "description" => "required",
            ]);
            Mail_box::where("id", $mail_box->id)->update($validate);
            return redirect("dashboard.pages.class.index")->with("success", "Pesan berhasil diupdate");
        } catch (Exception $e) {
            return redirect("dashboard.pages.class.index")->with("failed", "Pesan gagal diupdate");
        }
    }
    public function destroy($id)
    {
        try {
            Mail_box::destroy($id);
            return redirect("/mail");
        } catch (Exception $e) {
            return redirect("dashboard.pages.class.index")->with("failed", "Pesan gagal di hapus!");
        }
    }
}
