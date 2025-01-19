<?php

use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    /*  ============ dashboard & profile  ============  */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/', [ProfileController::class, 'update'])->name('profile.update');
    /*  ===============================================  */


    /*  ============ Resources  ============  */
    Route::resource('users', UserController::class)->only(['index', 'store']);
    Route::resource('categories', CategoryController::class)->only(['index', 'create', 'update' ,'store', 'destroy']);
    //Route::get('/admin-panel-setting', [AdminPanelSettingController::class, 'index'])->name('admin-panel-setting.index');
    /*  ====================================  */




    /*  ============ pos && ajax of pos ============  */
    Route::resource('pos', PosController::class)->only(['index']);
    Route::get('/pos/product/{code}', [PosController::class, 'getProdcutAjax'])->name('pos.product');
    /*  ================================================  */



    /*  ============ pos && ajax of pos ============  */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/bill', [OrderController::class, 'generateBill'])->name('orders.bill');
    /*  ================================================  */


    /*  ============ Products ============  */
    Route::resource('products', ProductController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    Route::delete('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::put('/products/{id}/add-quantity', [ProductController::class, 'addQuantity'])->name('products.add.quantity');
    /*  =======================================  */



    /*  ============ barcodes && print barcode ============  */
    Route::get('/products/{product}/barcode', [BarcodeController::class, 'show'])->name('barcode.product.show');
    Route::post('/products/barcode', [BarcodeController::class, 'print'])->name('barcode.print');
    /*  ===================================================  */



    /*  ============ Reports  ============  */
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    /*  ===================================  */


    /*  ============ Expenses  ============  */
    Route::resource('/expenses', ExpenseController::class)->only('index', 'store', 'update');
    /*  ===================================  */
});
