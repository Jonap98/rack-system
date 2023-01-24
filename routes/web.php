<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensoresController;
use App\Http\Controllers\RacksController;
use App\Http\Controllers\rack\RequerimientosRackController;

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


Route::get('/', [SensoresController::class, 'index'])->name('sensores');

// Sensores
Route::get('sensores', [SensoresController::class, 'index'])->name('sensores');
Route::post('sensores/store', [SensoresController::class, 'store'])->name('sensores.store');

// Racks
Route::get('racks', [RacksController::class, 'index'])->name('racks');
Route::post('racks/store', [RacksController::class, 'store'])->name('racks.store');

// Requerimientos
Route::get('requerimientos', [RequerimientosRackController::class, 'index'])->name('requerimientos');
Route::post('requerimientos/store', [RequerimientosRackController::class, 'store'])->name('requerimientos.store');
