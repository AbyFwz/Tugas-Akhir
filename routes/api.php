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

Route::get('/request-read', function () {
    $data = [
        [
            'nama' => 'Arsip satu',
            'nomor' => 'FRM-BAA-01',
            'deskripsi' => 'Ini arsip'
        ],
        [
            'nama' => 'Arsip dua',
            'nomor' => 'FRM-BAA-02',
            'deskripsi' => 'Ini arsip'
        ]
    ];
    return response()->json(['message' => 'Request sukses', 'data' => $data]);
});

Route::post('/request-post', function (Request $request) {
    $data = [
        'nama' => $request->nama,
        'nomor' => $request->nomor,
        'deskripsi' => $request->deskripsi
    ];

    return response()->json(['data' => $data]);
});

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
