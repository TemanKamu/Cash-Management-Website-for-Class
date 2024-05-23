<?php

namespace App\Http\Controllers;

use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Pemasukan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryActivitiesController extends Controller
{
    public function index()
    {
        if (request()->has("user") && request()->has("date_at") && request()->has("date_to")) {
            $user = request("user") !== "all_user" ? User::where("uuid", request("user"))->first() : "";
            $userForFilter = User::where("kelas_id", Auth::user()->kelas_id)->where("status_verifikasi_kelas", 1);
            $datas = request("user") === "all_user" ? History_activities::where("kelas_id", Auth::user()->kelas_id) : History_activities::where("user_id", $user->id)->where("kelas_id", $user->kelas_id);
            
            $date_at = Carbon::createFromFormat('Y-m-d', request('date_at'), 'Asia/Makassar')->startOfDay();
            $date_to = Carbon::createFromFormat('Y-m-d', request('date_to'), 'Asia/Makassar')->endOfDay();
            $datas = $datas->whereBetween("created_at", [$date_at, $date_to]);
            if (Auth::user()->isBendahara === 1) {
                $datas = $datas->get();
                $datas->userData = $userForFilter->orderBy('isBendahara', 'desc')->get();
            } else {
                $datas = $datas->where("isBendahara", 1)->get();
                $datas->userData = $userForFilter->where("isBendahara", 1)->get();
            }
            return view('dashboard.pages.bendahara_activity.index', compact('datas'));
        } else {
            $kelas = ClassTable::where("id", Auth::user()->kelas_id)->first();
            $datas = History_activities::where("kelas_id", $kelas->id)->orderBy('created_at', 'desc');
            $user = User::where("kelas_id", $kelas->id)->where("status_verifikasi_kelas", 1);
            if (Auth::user()->isBendahara === 1) {
                $datas = $datas->orderBy('isBendahara', 'desc')->get();
                $datas->userData = $user->orderBy('isBendahara', 'desc')->get();
            } else {
                $datas = $datas->where("isBendahara", 1)->get();
                $datas->userData = $user->where("isBendahara", 1)->get();
            }
            return view('dashboard.pages.bendahara_activity.index', compact('datas'));
        }
    }
    // public function show($id)
    // {
    //     $data = null;
    //     if ($this->user->isBendahara) {
    //         $data = History_activities::where("kelas_id", $this->user->kelas_id)->latest();
    //     } else {
    //         $data = History_activities::where("user_id", $this->user->id)->where("isBendahara", false)->latest();
    //     }
    //     return view("dashboard.pages.history_activities.index", compact("data"));
    // }
}
