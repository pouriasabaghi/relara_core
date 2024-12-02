<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('/token', [App\Http\Controllers\api\v1\UserAuthController::class, 'createToken']);
    Route::post('/register', [App\Http\Controllers\api\v1\UserAuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\api\v1\UserAuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\api\v1\UserAuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:admin')->group(function () {
        Route::apiResource('/users', App\Http\Controllers\api\v1\UserController::class)->middleware('auth:sanctum');
        Route::get('categories/all', [App\Http\Controllers\api\v1\CategoryController::class, 'allCategories']);
        Route::apiResource('categories', App\Http\Controllers\api\v1\CategoryController::class);
    });
});