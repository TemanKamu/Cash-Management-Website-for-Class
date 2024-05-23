<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClassTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EditProfileController extends Controller
{
    public function update(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "id", 'required',
                'profile_kelas' => 'required|image', // Contoh validasi untuk foto
            ]);
            if ($validate->fails()) {
                // return response()->json($request->id);
                return response()->json($request->all(), 200);
            }
            if ($request->hasFile('profile_kelas')) {
                $kelas = ClassTable::where("id", $request->id)->first();

                $validate['profile_kelas'] = $request->file('profile_kelas')->store('public/image');
                $profile_kelas = $validate['profile_kelas'];
                Storage::delete('public/image/' . basename($kelas->profile_kelas));
                // Lakukan operasi lain sesuai kebutuhan (misalnya, menyimpan nama file ke database)
                $kelas->update(['profile_kelas' => $profile_kelas]);
                return response()->json(['message' => 'Foto berhasil diunggah']);
            } else {
                return response()->json(['error' => 'Tidak ada foto yang dipilih'], 400);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
