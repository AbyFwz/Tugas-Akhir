<?php

use App\Http\Controllers\API\Arsip\ArsipController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Arsip\KategoriController;
use App\Http\Controllers\API\Services\UploadController;
use App\Http\Controllers\API\Siswa\SiswaController;
use App\Http\Controllers\API\Surat\SuratKeluarController;
use App\Http\Controllers\API\Surat\SuratMasukController;
use App\Http\Controllers\API\Tamu\TamuController;
use App\Http\Controllers\API\Tamu\TamuDinasController;
use App\Http\Controllers\API\Tamu\TamuUmumController;
use App\Http\Controllers\API\Tamu\TamuYayasanController;
use App\Http\Controllers\API\User\RoleController;
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
Route::get('/login', function () {
    return abort(404);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('siswa', SiswaController::class,);
    Route::apiResource('arsip', ArsipController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('surat-masuk', SuratMasukController::class);
    Route::apiResource('surat-keluar', SuratKeluarController::class);
    Route::apiResource('tamu-dinas', TamuDinasController::class);
    Route::apiResource('tamu-umum', TamuUmumController::class);
    Route::apiResource('tamu-yayasan', TamuYayasanController::class);
    Route::apiResource('user', UserController::class);
    Route::apiResource('role', RoleController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('upload', [UploadController::class, 'handleUpload']);
});
