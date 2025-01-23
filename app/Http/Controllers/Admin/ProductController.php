<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Traits\HandleBarcode;
use App\Http\Traits\handleImage;
use App\Http\Traits\HandleTime;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class ProductController extends Controller
{
    use handleImage;
    use HandleTime;
    use HandleBarcode;

    // display lists of products;
    public function index()
    {
        $counter = 1;
        $data = Product::latest()->paginate(50);
//        $data = Product::latest()->paginate(50);

        return view('admin.pages.products.index', compact('data', 'counter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $lastProductCode = Product::latest('id')->value('code');

        $barcode = 'PR-0' . $this->generateCode($lastProductCode);
        $suppliers = Supplier::all();

        $categories = Category::all();
        return view('admin.pages.products.create', compact('categories', 'barcode', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // if the image is added
        if($request->hasFile('image')) {
            $image = $this->uploadImage($request->file('image'), 'uploads/products');
        }



        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'stock' => $request->stock,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
        ]);
        toastr()->success(  'تم انشاء المنتج' . $request->name . 'بنجاح');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $barcode = DNS1D::getBarcodeHtml('123456789', 'c128', 1, 25);
//        dd($barcode);

        // created at &&  updated at
//        $created_at = $this->getTime($product->updated_at, 'd-m-Y');
        $created_at = $product->created_at->diffForHumans();
        $updated_at = $product->created_at->diffForHumans();

        // the profit of the product
        $profit = $product->selling_price - $product->buying_price;

        return view('admin.pages.products.show', compact('product', 'created_at', 'updated_at', 'profit', 'barcode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
       return view('admin.pages.products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $image = $product->image;
        // if the image is added

        if($request->hasFile('image')) {

            // in case the image is empty so we need to check first
            if(!empty($product->image))
            {
            unlink($product->image);
            }
            $image = $this->uploadImage($request->file('image'), 'uploads/products');
        }

        $product->update([
            'code' => $product->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'stock' => $request->stock,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'image' => $image
        ]);


        toastr()->success('تم تحديث المنتج ينجاح');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        // check if order exist or not
        // check if it has any order or has been sold before
        // if not redirect to products.index then destroy it
        dd($request->all());

        $product = Product::findOrFail($request->id);
        if (!empty($product->image)){
        unlink($product->image);
        }
        $product->delete();
        return response()->json(['success' => true, 'message' => '', 'id' => $id]);

    }

    // add quantity
    public function addQuantity(Request $request,$id)
    {

        // Validate the request
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid quantity provided.',
            ], 400);
        }


        // Find the product by ID
        $product = Product::find($id);


        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'هذا المنتج غير موجود',
            ]);
        }


        // Update the product quantity
        $product->stock += $request->input('quantity'); // Add the new quantity to the existing quantity
        Inventory::create([
            'product_id' => $id,
            'quantity_change' => $request->input('quantity'),
            'type' => 'in'
        ]);
        $product->save();

//
        // Return a success response
        return response()->json([
            'success' => true,
            'message' =>   ' تمت اضافة الكمية بنجاح الكمية الحالية ' . $product->stock,
        ]);
    }
}
