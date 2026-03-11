<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/cars/create', [CarController::class, 'create_step1'])
        ->name('cars.create');

    Route::post('/cars/create', [CarController::class, 'store_step1']);

    Route::get('/cars/create/{license_plate}', [CarController::class, 'create_step2'])
        ->name('cars.create.step2');

    Route::post('/cars/store', [CarController::class, 'store'])
        ->name('cars.store');

});

require __DIR__.'/auth.php';
    