<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


/*  ============ dashboard & profile  ============  */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
Route::put('/profile/', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
/*  ===============================================  */


/*  ============ settings  && admin ============  */
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::get('/settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
/*  ===============================================  */


/*  ============ Customers  ============  */
Route::resource('customers', CustomerController::class)->only('index', 'edit', 'update');
Route::delete('/customers', [CustomerController::class, 'destroy'])->name('customers.destroy');
/*  =====================================  */


/*  ============  suppliers ============  */
Route::resource('suppliers', SupplierController::class)->only('index', 'edit', 'update', 'create', 'store');
Route::delete('/suppliers', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
/*  =======================================  */

/*  ============ Products ============  */
Route::resource('products', ProductController::class)->only('create', 'store', 'edit', 'update','show');
Route::delete('/products/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
/*  =======================================  */


/*  ============ Reports  ============  */
Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
/*  ===================================  */


/*  ============ Expenses  ============  */
Route::resource('/expenses', ExpenseController::class)->only('index', 'store', 'update', 'destroy');
/*  ===================================  */

/*  ============ Resources  ============  */
Route::resource('users', UserController::class)->only(['index', 'store']);
Route::resource('discounts', DiscountController::class)->only(['index', 'store', 'update', 'destroy']);

/*  ===================================  */

