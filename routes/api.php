<?php

use App\Http\Controllers\Api\V1\ActivityLogController;
use App\Http\Controllers\Api\V1\DeviceSyncController;
use App\Http\Controllers\Api\V1\DeviceTokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/activity-logs', [ActivityLogController::class, 'store']);
    Route::get('/devices/{uuid}/sync', [DeviceSyncController::class, 'checkStatus']);
    Route::post('/devices/token', [DeviceTokenController::class, 'updateToken']);
});