<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\handleImage;
use App\Http\Traits\HandleTime;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class ProductController extends Controller
{
    use handleImage;
    use HandleTime;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counter = 1;
        $data = Product::all();
//        $data = Product::latest()->paginate(50);

        return view('admin.pages.products.index', compact('data', 'counter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastProductCode = Product::latest('id')->value('code');

        $categories = Category::all();
        return view('admin.pages.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $barcode = DNS1D::getBarcodeHtml('123456789', 'c128', 1, 15);
//        dd($barcode);

        // created at &&  updated at
        $created_at = $this->getTime($product->updated_at, 'd-m-Y');
        $updated_at = $this->getTime($product->created_at, 'd-m-Y');

        // the profit of the product
        $profit = $product->selling_price - $product->buying_price;

        return view('admin.pages.products.show', compact('product', 'created_at', 'updated_at', 'profit', 'barcode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        dd($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request);


        if (!is_null($request->file('image'))){
            $path = '/uploads';

            $save_image = $this->uploadImage($request->file('image'), $path);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
