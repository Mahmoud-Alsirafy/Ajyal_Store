<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\Roles;
use Illuminate\Support\Facades\Route;


// Route::get('/dashboard', function () {
//     return view('Dashboard.index');
// })->middleware('auth')->name('dashboard');
// // ['auth', 'verified']

Route::group([
    'middleware' => ['auth:admin,web'],
    'prefix' => 'admin',
], function () {

    Route::get('/dashboard', function () {
        return view('Dashboard.index');
    })->name('dashboard');
    // ['auth', 'verified']
    Route::get('/categories/trash', [CategoriesController::class, 'trashed'])->name('Categories.trashed');
    Route::put('/categories/{categoy}/restore', [CategoriesController::class, 'restore'])->name('Categories.restore');
    Route::delete('/categories/{categoy}/force-delete', [CategoriesController::class, 'forceDelete'])->name('Categories.force-delete');

    Route::resource('/categories', CategoriesController::class)->names([
        'index' => 'Categories.index',
        'create' => 'Categories.create',
        'store' => 'Categories.store',
        'edit' => 'Categories.edit',
        'update' => 'Categories.update',
        'destroy' => 'Categories.destroy',
    ]);
    Route::get('/categories/{category}', [\App\Http\Controllers\Dashboard\CategoriesController::class, 'show'])->name('Categories.show');


    Route::resource('/products', ProductController::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'store' => 'products.store',
        'edit' => 'products.edit',
        'update' => 'products.update',
        'destroy' => 'products.destroy',
    ]);
    Route::get('/products/{product}', [\App\Http\Controllers\Dashboard\ProductController::class, 'update'])->name('products.update');
    Route::get('/profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'edit'])->name('profiley.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profiley.update');


    Route::resource('/Roles', Roles::class)->names([
        'index' => 'Roles.index',
        'create' => 'Roles.create',
        'store' => 'Roles.store',
        'edit' => 'Roles.edit',
        'update' => 'Roles.update',
        'destroy' => 'Roles.destroy',
    ]);

    Route::resource('admins', AdminController::class)->names([
        'index' => 'admins.index',
        'create' => 'admins.create',
        'store' => 'admins.store',
        'edit' => 'admins.edit',
        'update' => 'admins.update',
        'destroy' => 'admins.destroy',
    ]);
});
