<?php

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

Route::prefix('v1')->group(function () {
    Route::post('users', [
        \App\Http\Controllers\Api\UserController::class, 'store',
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::apiResource('users', \App\Http\Controllers\Api\UserController::class)->except(['store']);
        Route::apiResource('apps', \App\Http\Controllers\Api\AppController::class);
        Route::apiResource('urls', \App\Http\Controllers\Api\UrlController::class);
    });
});
