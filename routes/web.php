<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\LokasiPenyimpananController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\BoxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RakController::class, 'index']);

Route::get('/organisasi/all', [OrganisasiController::class, 'all']);

Route::post('/lokasi-penyimpanan/find', [LokasiPenyimpananController::class, 'find']);

Route::get('/rak', [RakController::class, 'index']);
Route::post('/rak/find', [RakController::class, 'find']);
Route::post('/rak/generate', [RakController::class, 'generate']);

Route::get('/shelf', [ShelfController::class, 'index']);
Route::post('/shelf/find', [ShelfController::class, 'find']);
Route::post('/shelf/generate', [ShelfController::class, 'generate']);

Route::get('/box', [BoxController::class, 'index']);
Route::post('/box/find', [BoxController::class, 'find']);
Route::post('/box/generate', [BoxController::class, 'generate']);
