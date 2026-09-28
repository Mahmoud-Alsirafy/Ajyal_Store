<?php

use App\Http\Controllers\Api\AccessToeknsController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(fn() => Route::apiResource('products', ProductController::class)->except('index', 'show'));

// Authentication routes
Route::post('auth/access-tokens', [AccessToeknsController::class, 'store'])->middleware('guest:sanctum');


// Auth->delete Token

Route::delete('auth/access-tokens/{token?}', [AccessToeknsController::class, 'destroy'])->middleware('auth:sanctum');


//
Route::get('auth/user', fn() => request()->user())->middleware('auth:sanctum');