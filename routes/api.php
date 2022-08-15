<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DataTransaksiController;
use App\Http\Controllers\API\HutangPiutangController;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\MitraController;
use App\Http\Controllers\API\PengaturanController;
use App\Http\Controllers\API\RekapController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('dashboard', DashboardController::class)->middleware(['auth:sanctum', 'ability:administrator,user']);
    Route::apiResource('transaksi', DataTransaksiController::class)->middleware(['auth:sanctum', 'ability:administrator,user']);
    Route::apiResource('hutang', HutangPiutangController::class)->middleware(['auth:sanctum', 'ability:administrator,user']);
    Route::apiResource('kategori', KategoriController::class)->middleware(['auth:sanctum', 'ability:administrator,user']);
    Route::apiResource('mitra', MitraController::class)->middleware(['auth:sanctum', 'ability:administrator,user']);
    Route::apiResource('pengaturan', PengaturanController::class)->middleware(['auth:sanctum', 'ability:administrator']);
});