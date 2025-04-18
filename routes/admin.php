<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use Illuminate\Support\Facades\Route;


/*  ============ dashboard & profile  ============  */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
Route::put('/profile/', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
/*  ===============================================  */


/*  ============ Products ============  */
Route::resource('products', ProductController::class)->only('create', 'store', 'edit', 'update','show');
Route::delete('/products/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
/*  =======================================  */


/*  ============ Expenses & wallet ============  */
Route::resource('/expenses', ExpenseController::class)->only('index', 'store', 'update', 'destroy');
Route::resource('/wallets', WalletController::class)->only('index');
Route::put('/wallets/{wallet}/withdraw', [WalletController::class, 'withdraw'])->name('wallets.withdraw');
Route::put('/wallets/{wallet}/withdraw-to-main', [WalletController::class, 'withdrawToMain'])->name('wallets.withdraw-to-main');
Route::put('/wallets/{wallet}/deposit', [WalletController::class, 'deposit'])->name('wallets.deposit');
Route::get('/wallets/{id}/transactions', [WalletController::class, 'getTransactions'])->name('wallets.transactions');
/*  ===================================  */


/*  ============ Discounts   ============  */
Route::resource('discounts', DiscountController::class)->only(['index', 'store', 'update', 'destroy']);
/*  ===================================  */


/*  ============ Users  ============  */
Route::put('/users/{user}/updatePassword', [UserController::class, 'updatePassword'])->name('users.update.password');
Route::resource('users', UserController::class)->only(['index', 'store', 'edit', 'update']);
Route::delete('/users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
/*  ===================================  */

/*  ============  suppliers ============  */
Route::resource('suppliers', SupplierController::class)->only('index', 'edit', 'update', 'create', 'store');
Route::delete('/suppliers', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
/*  =======================================  */

/*  ============ Customers  ============  */
Route::resource('customers', CustomerController::class)->only('index', 'edit', 'update');
Route::delete('/customers', [CustomerController::class, 'destroy'])->name('customers.destroy');
/*  =====================================  */


/*  ============ Reports  ============  */
Route::get('/reports/orders', [ReportController::class, 'ordersReports'])->name('reports.orders');
Route::get('/reports/money', [ReportController::class, 'moneyReports'])->name('reports.money');
/*  ===================================  */


/*  ============ settings  && admin ============  */
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::get('/settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
Route::get('/settings/latest-backup', [SettingController::class, 'getLatestBackup'])->name('settings.backup');
Route::get('/settings/reset-setting', [SettingController::class, 'resetSetting'])->name('settings.reset-setting');
/*  ===============================================  */


/*  ============ show orders ============  */
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
/*  ======================================  */

