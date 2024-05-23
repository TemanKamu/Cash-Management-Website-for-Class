<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\HistoryActivitiesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailBoxController;
use App\Http\Controllers\ManageClassController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PermissionLeave;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiUserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\ClassTable;
use App\Models\History_activities;
use App\Models\Pemasukan;
use App\Models\UserLeave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing_page.index');
});
// Route::middleware('auth-user')->group(function () {
// });
Route::resource('/login', LoginController::class);
Route::resource('/register', RegisterController::class);

Route::middleware('auth-user')->group(function () {
    Route::get('/mail', [MailBoxController::class, 'index'])->name('mail.index');
    Route::delete('/mail/{mail}', [MailBoxController::class, 'destroy'])->name('mail.destroy');
    Route::post('/logout', [LoginController::class, 'destroy'])->name("logout");
    Route::middleware('not-for-siswa-verified')->group(function () {
        Route::resource('/welcome', ClassController::class);
        Route::put('/welcome/join/proses_join/{id}', [ClassController::class, 'join'])->name('welcome.join');
    });
    Route::resource("/setting-user", UserController::class);
    Route::post('/setting-user/fitur/editProfile', [UserController::class, 'editProfile'])->name('setting-user.editProfile');
    Route::middleware('auth-kelas')->group(function () {
        Route::resource('/home', ManageClassController::class);
        // Route::resource('/home/{home}', [ManageClassController::class, 'show']);
        Route::resource('/bendahara-activity', HistoryActivitiesController::class);
        Route::resource('/pemasukan', PemasukanController::class);
        Route::resource('/pengeluaran', PengeluaranController::class);
        Route::get('/pemasukan-user/{uuid}', [PemasukanController::class, 'getPemasukanByUser'])->name('pemasukan-user');
        Route::get('/laporan/{kode_kelas}', [ManageClassController::class, 'getLaporan'])->name('get-laporan');
        // Route::resource('/profile-user', )
        Route::resource('/keluar', PermissionLeave::class);
        Route::middleware('admin-only')->group(function () {
            Route::post('/keluar/fitur/notAllowed/{id}', [PermissionLeave::class, 'notAllowed'])->name('keluar.notAllowed');
            Route::get('/keluar/fitur/batalKeluar/{id}', [PermissionLeave::class, 'batalKeluar'])->name('keluar.batalKeluar');
            Route::put('/pemasukan/switch/{id}', [PemasukanController::class, "switch"])->name('pemasukan.switch');
            Route::post('/pemasukan/update/date', [PemasukanController::class, "updatePemasukanUserDate"])->name("pemasukan.updateDate");
            Route::post('/ingatkanPembayaran/{id}', [PemasukanController::class, "ingatkanPembayaran"])->name("pemasukan.ingatkanPembayaran");
            Route::resource('/manage-class', ManageClassController::class);
            Route::post('/editProfile', [ManageClassController::class, 'editProfile'])->name('profile.update');
            Route::post('/payout/detail', [PayoutController::class, 'goToInvoice'])->name('payout.detail');
            Route::post('/payout/success', [PayoutController::class, 'store'])->name('payout.success');
            Route::resource('/verification-user', VerifikasiUserController::class);
            Route::get('/manage-user', [ManageClassController::class, 'manageStudent']);
            Route::put('/manage-user/{id}', [ManageClassController::class, 'kickSiswa'])->name('manage-student.kickSiswa');
            Route::post('/kickUser', [ManageClassController::class, 'kickSiswa'])->name('manage-student.kickSiswa');
            Route::get('/resetKodeKelas/{kode_kelas}', [ManageClassController::class, 'resetKodeKelas'])->name('resetKodeKelas');
        });
    });
});
