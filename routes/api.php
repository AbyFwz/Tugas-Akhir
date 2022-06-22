<?php

use App\Http\Controllers\API\Arsip\ArsipController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Siswa\SiswaController;
use App\Http\Controllers\API\Surat\SuratKeluarController;
use App\Http\Controllers\API\Surat\SuratMasukController;
use App\Http\Controllers\API\Tamu\TamuController;
use App\Http\Controllers\API\Tamu\TamuDinasController;
use App\Http\Controllers\API\Tamu\TamuUmumController;
use App\Http\Controllers\API\Tamu\TamuYayasanController;
use App\Http\Controllers\API\User\UserController;
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
    return response()->json(['message' => 'Request sukses', 'listarsip' => $data]);
});

Route::post('/request-post', function (Request $request) {
    $data = [
        'nama' => $request->nama,
        'nomor' => $request->nomor,
        'deskripsi' => $request->deskripsi
    ];

    return response()->json(['data' => $data]);
});

// Route::group(['middleware' => ['auth:sanctum']], function () {
Route::get('/profile', function () {
    // $user = json_encode(auth()->user());
    $user = [
        [
            'nama' => 'Abyan Fawwaz',
            'email' => 'aby@aby.com'
        ],
        [
            'nama' => 'Erni Srihartini',
            'email' => 'erni@erni.com'
        ]
    ];
    $user = json_encode($user);
    return response()->json(['message' => 'Ini Profile', 'user' => $user]);
});

Route::apiResource('siswa', SiswaController::class,);
Route::apiResource('arsip', ArsipController::class);
Route::apiResource('surat-masuk', SuratMasukController::class);
Route::apiResource('surat-keluar', SuratKeluarController::class);
Route::apiResource('tamu-dinas', TamuDinasController::class);
Route::apiResource('tamu-umum', TamuUmumController::class);
Route::apiResource('tamu-yayasan', TamuYayasanController::class);
Route::apiResource('user', UserController::class);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });
