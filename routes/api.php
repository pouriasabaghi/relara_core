<?php

use App\Http\Controllers\api\v1\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('/token', [UserAuthController::class, 'createToken']);
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:admin')->group(function () {
        Route::apiResource('/users', App\Http\Controllers\api\v1\UserController::class)->middleware('auth:sanctum');
    });
});