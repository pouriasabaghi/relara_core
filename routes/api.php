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

    Route::group([], function () {
        Route::get('categories', [App\Http\Controllers\api\v1\CategoryController::class, 'index']);
        Route::get('categories/{category}', [App\Http\Controllers\api\v1\CategoryController::class, 'showProducts']);
        
        Route::get('products/{product}', [App\Http\Controllers\api\v1\ProductController::class, 'show']);
    });

    Route::prefix('admin')->middleware('auth:admin')->group(function () {
        Route::apiResource('users', App\Http\Controllers\api\v1\UserController::class)->middleware('auth:sanctum');
        Route::get('categories/all', [App\Http\Controllers\api\v1\CategoryController::class, 'allCategories']);
        Route::apiResource('categories', App\Http\Controllers\api\v1\CategoryController::class);
        Route::apiResource('attributes', App\Http\Controllers\api\v1\AttributeController::class);
        Route::apiResource('attribute-values', App\Http\Controllers\api\v1\AttributeValueController::class);
        Route::apiResource('products', App\Http\Controllers\api\v1\ProductController::class);
        Route::apiResource('product-variants', App\Http\Controllers\api\v1\ProductVariantController::class);
        Route::post("upload/image", [App\Http\Controllers\api\v1\ImageController::class, 'store']);
        Route::apiResource('discount-codes', App\Http\Controllers\api\v1\DiscountCodeController::class);
    });
});
