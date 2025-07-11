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


Route::prefix('v1')->group(function () {
    Route::prefix('pembeli')->group(function () {
        Route::post('/register', [App\Http\Controllers\API\Pembeli\AuthController::class, 'register']);
        Route::post('/login', [App\Http\Controllers\API\Pembeli\AuthController::class, 'login']);

        Route::get('/makanan', [App\Http\Controllers\API\Pembeli\MakananController::class, 'index']);
        Route::get('/makanan/{id}', [App\Http\Controllers\API\Pembeli\MakananController::class, 'detail']);
        Route::get('/kategori', [App\Http\Controllers\API\Pembeli\MakananController::class, 'kategori']);

        Route::get('/artikel', [App\Http\Controllers\API\Pembeli\ArtikelController::class, 'index']);
        Route::get('/artikel/{slug}', [App\Http\Controllers\API\Pembeli\ArtikelController::class, 'show']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/profile', [App\Http\Controllers\API\Pembeli\ProfileController::class, 'show']);

            Route::get('/pesanan', [App\Http\Controllers\API\Pembeli\PesananController::class, 'index']);
            Route::post('/pesan', [App\Http\Controllers\API\Pembeli\PesananController::class, 'store']);
            Route::post('/pesanan/{id}/batal', [App\Http\Controllers\API\Pembeli\PesananController::class, 'batalkanPesanan']);
            // Route::post('/pesanan/{id}/ambil', [App\Http\Controllers\API\Pembeli\PesananController::class, 'ambilPesanan']);
            Route::post('/pesanan/{id}/ulasan', [App\Http\Controllers\API\Pembeli\PesananController::class, 'buatUlasan']);
        });
    });
    Route::prefix('penjual')->group(function () {
        Route::get('/', [App\Http\Controllers\API\Pembeli\PenjualController::class, 'index']);
    });
});
