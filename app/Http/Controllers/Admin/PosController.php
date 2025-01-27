<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Discount;
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
     *p
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

        $products = Product::where('stock', '>', 0)->select('name', 'id', 'code')->get();
        $discounts = Discount::getValidDiscounts();
        $row = [];
        return view('admin.pages.pos.index', compact('products', 'row', 'discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

   // Directly retrieve only the needed data from the request
        $orderDetails = $this->orderService->getOrderDetails($request->only('pid_arr', 'quantity_arr'));
        if(!$orderDetails) {
            return redirect()->route('pos.index');
        }
        $order = $this->orderService->getOrderRequest($request->all());

        // start the transaction
        DB::beginTransaction();
        try {
            // the process of creating the order
            $order = $this->orderService->processOrder($order, $orderDetails);

            DB::commit();
            toastr()->success('تم انشاء الاوردر بنجاح');
            redirect()->route('orders.bill', ['order' => $order->id]);
        }catch (\Exception $exception){
            DB::rollBack();

            // notify the user
            toastr()->error($exception->getMessage());
            return redirect()->back();
        }
    }



    // to get the product
    public function getProdcutAjax(string $code){
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
