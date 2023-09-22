<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensoresController;
use App\Http\Controllers\RacksController;
use App\Http\Controllers\NuevosRequerimientosController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api'
], function($router) {
    // Sensores
    Route::post('sensores/store', [SensoresController::class, 'store'])->name('sensores.store');
    // Get part number
    Route::get('sensores/getpart/{sensor}', [SensoresController::class, 'getPart'])->name('racks.getPart');
    // Racks
    Route::post('racks/store', [RacksController::class, 'store'])->name('racks.store');
    Route::post('racks/update/', [RacksController::class, 'update'])->name('racks.update');

    // GetApi test
    Route::get('racks/get', [RacksController::class, 'getApi'])->name('racks.get');
    Route::get('racks/upd/{num_parte}/{sensor_min}/{sensor_max}', [RacksController::class, 'updateGet'])->name('racks.updateget');

    // Get rack info
    Route::get('get/rack-info-api', [NuevosRequerimientosController::class, 'getRackInfo'])->name('get.rack-info-api');

    
});


