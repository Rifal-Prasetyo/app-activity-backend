<?php

use App\Http\Controllers\Dashboard\DeviceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestApiController;

Route::inertia('/', 'welcome')->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('dashboard')->group(function () {
        Route::resource('devices', DeviceController::class);
    });

});

// test
Route::get('/test-api', [TestApiController::class, 'index']);
Route::post('/test-api/send', [TestApiController::class, 'simulateSend'])->name('test.api.send');


require __DIR__ . '/settings.php';
