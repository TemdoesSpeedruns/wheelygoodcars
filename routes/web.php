<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/cars', [CarController::class, 'index'])
    ->name('cars.index');

/*
|--------------------------------------------------------------------------
| AUTH ONLY
|--------------------------------------------------------------------------
*/

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

    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])
        ->name('cars.edit');

    Route::put('/cars/{car}', [CarController::class, 'update'])
        ->name('cars.update');

    Route::delete('/cars/{car}', [CarController::class, 'destroy'])
        ->name('cars.destroy');

    Route::get('/cars/{car}/pdf', [CarController::class, 'pdf'])
        ->name('cars.pdf');

    Route::post('/cars/{car}/toggle-sold', [CarController::class, 'toggleSold'])
        ->name('cars.toggleSold');

    Route::post('/cars/{car}/update-price', [CarController::class, 'updatePrice'])
        ->name('cars.updatePrice');
});
    
Route::get('/cars/{car}', [CarController::class, 'show'])
    ->name('cars.show');

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/tags', [AdminController::class, 'tagStats'])
        ->name('admin.tags.stats');

    Route::get('/admin/suspicious-users', [AdminController::class, 'suspiciousUsers'])
        ->name('admin.suspicious.users');

    Route::post('/admin/users/{user}/ignore', [AdminController::class, 'ignoreUser'])
        ->name('admin.users.ignore');
});

require __DIR__.'/auth.php';