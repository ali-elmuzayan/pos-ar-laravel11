<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class BarcodeController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        return view('admin.pages.products.barcodes.barcode', compact('product'));
    }

    /**
     * Print the amount ot barcodes
     */
    public function print(Request $request)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|integer|min:1|max:50',
        ]);
        // Retrieve the product details
        $product = Product::where('code', $request->input('barcode'))->first();


        // Generate barcodes
        $barcodes = [];
        for ($i = 0; $i < $request->input('amount'); $i++) {
            // Generate barcode image using DNS1D
            // C39, C39+, C39E, C39E+, C93, C128
            $barcodeImage =   DNS1D::getBarcodeSVG($product->code, 'C128', 1);
            ; // 'C128' is the barcode type

            $barcodes[] = [
                'barcode_image' => $barcodeImage, // Store the barcode image
                'price' => $product->selling_price, // Product price
            ];
        }

        // Pass the barcodes to the view for printing
        return view('admin.pages.products.barcodes.print', compact('barcodes'));
    }

}
