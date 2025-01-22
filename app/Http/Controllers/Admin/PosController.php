<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosController extends Controller
{

    protected $orderService;

    /**
     * Constructor to inject OrderService.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::where('stock', '>', 0)->select('name', 'id','code')->get();

        $row = [];
        return view('admin.pages.pos.index', compact('products', 'row'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        DB::transaction(function () {});
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }


    // to get the product
    public function getProdcutAjax(string $code){
//        $product = Product::where('code', $code)
//            ->orWhere('id', $code)
//            ->orWhere('name', $code)
//            ->first();
//        if ($product){
//
//        return response()->json($product);
//        }else {
//            return response()->json(['message' => 'Product not found']);
//        }
//        // Validate input
//        if (empty($code)) {
//            return response()->json(['error' => true, 'message' => 'يجب ادخال كود صحيح'], 400);
//        }

        try {
            // Optimize the query
            $product = Product::where('code', $code)
                ->orWhere('id', $code)
                ->orWhere('name', $code)
                ->first();

            // If product is found, return it
            if ($product) {
                return response()->json($product);
            }

            // If no product is found, return a 404 response
            return response()->json(['error' => true, 'message' => 'المنتج غير موجود'], 404);

        } catch (\Exception $e) {
            // Log the error and return a generic error message
            Log::error('Error fetching product: ' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'حدث خطأ اثناء اضافة المنتج يرجى المحاولة مرة اخرى'], 500);
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
