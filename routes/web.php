<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

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

    Route::get('/cars/mine', [CarController::class, 'mine'])
        ->name('cars.mine');

    Route::get('/cars', [CarController::class, 'index'])
        ->name('cars.index');

    Route::get('/cars/{car}', [CarController::class, 'show'])
        ->name('cars.show');

    Route::delete('/cars/{car}', [CarController::class, 'destroy'])
        ->name('cars.destroy');

    Route::get('/cars/{car}/pdf', [CarController::class, 'pdf'])
        ->name('cars.pdf');

});

require __DIR__.'/auth.php';