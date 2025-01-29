<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandleBill;
use App\Models\Order;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class OrderController extends Controller
{

    use HandleBill;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Order::getAllValidOrder();



        return view('admin.pages.orders.index', compact('data'));
    }

    public function generateBill(Order $order)
    {
        // Load order with details
        $order = Order::with('orderDetails')->findOrFail($order->id);

        // create bill
         $this->createBill($order);
         toastr()->success('تم طباعة المنتج بنجاح');
         return redirect()->route('orders.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $barcode = DNS1D::getBarcodeHtml($order->invoice_no, 'c128', 1, 25);


        return view('admin.pages.orders.show', compact('order', 'barcode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

}
