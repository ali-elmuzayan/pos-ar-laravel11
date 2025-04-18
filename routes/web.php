<?php

use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\WalletController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    /*  ============ dashboard & profile  ============  */
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
     /*  ===============================================  */


    /*  ============ Resources  ============  */
    Route::resource('categories', CategoryController::class)->only(['index', 'show', 'update' ,'store', 'destroy']);
    /*  ====================================  */


    /*  ============ pos && ajax of pos ============  */
    Route::resource('pos', PosController::class)->only('index', 'store');
    Route::get('/pos/product/{code}', [PosController::class, 'getProdcutAjax'])->name('pos.product');

    Route::get('/pos/{order}/bill', [PosController::class, 'generateBill'])->name('pos.bill');
    // returns
    Route::get('/pos/{order}/return', [PosController::class, 'edit'])->name('pos.return');
    Route::put('pos/{order}', [PosController::class, 'update'])->name('pos.update');
    // check the customer
    Route::get('/customer/check', [CustomerController::class, 'checkCustomer'])->name('customer.check');

    /*  ================================================  */


    /*  ============ pos && ajax of pos ============  */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/bill', [OrderController::class, 'generateBill'])->name('orders.bill');
    /*  ================================================  */



    /*  ============ Wallet ============  */
    Route::post('/wallets/emptying', [WalletController::class, 'emptying'])->name('wallets.emptying');
    /*  ================================================  */

    /*  ============ returns ============  */
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::delete('/returns', [ReturnController::class, 'destroy'])->name('returns.destroy');
    /*  ================================================  */


    /*  ============ Products ============  */
    Route::resource('products', ProductController::class)->only('index');
    Route::put('/products/{id}/add-quantity', [ProductController::class, 'addQuantity'])->name('products.add.quantity');
    /*  =======================================  */


    /*  ============ barcodes && print barcode ============  */
    Route::get('/products/{product}/barcode', [BarcodeController::class, 'show'])->name('barcode.product.show');
    Route::post('/products/barcode', [BarcodeController::class, 'print'])->name('barcode.print');
    /*  ===================================================  */

});



require __DIR__.'/auth.php';
