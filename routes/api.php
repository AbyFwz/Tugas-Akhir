<?php

use App\Http\Controllers\API\Arsip\ArsipController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Siswa\SiswaController;
use App\Http\Controllers\API\Surat\SuratKeluarController;
use App\Http\Controllers\API\Surat\SuratMasukController;
use App\Http\Controllers\API\Tamu\TamuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function () {
        return auth()->user();
    });

    Route::apiResource('siswa', SiswaController::class,);
    Route::apiResource('arsip', ArsipController::class);
    Route::apiResource('surat-masuk', SuratMasukController::class);
    Route::apiResource('surat-keluar', SuratKeluarController::class);
    Route::apiResource('tamu', TamuController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
