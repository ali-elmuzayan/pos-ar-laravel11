<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Route::get('/admin-panel-setting', [AdminPanelSettingController::class, 'index'])->name('admin-panel-setting.index');

Route::resource('categories', CategoryController::class)->only(['index', 'create', 'store']);
Route::resource('pos', PosController::class)->only(['index']);
Route::resource('users', UserController::class)->only(['index']);
Route::resource('products', ProductController::class)->only(['index', 'create', 'store', 'show', 'edit']);

