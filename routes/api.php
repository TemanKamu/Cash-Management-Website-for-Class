<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/chart/{id}', [\App\Http\Controllers\api\ChartController::class, 'index']);
Route::post('/laporan', [\App\Http\Controllers\api\ReportController::class, 'getData']);
Route::post('/laporan/checkuser', [\App\Http\Controllers\api\ReportController::class, 'checkUser']);
Route::post('/editProfile/update', [\App\Http\Controllers\api\EditProfileController::class, 'update']);
Route::post('/handlePayment', [\App\Http\Controllers\api\PaymentController::class, 'store']);
Route::post('/handlePayment/notification', [\App\Http\Controllers\api\PaymentController::class, 'notification']);
Route::post('/handlePayout/notification', [\App\Http\Controllers\api\PayoutCallback::class, 'notification']);
