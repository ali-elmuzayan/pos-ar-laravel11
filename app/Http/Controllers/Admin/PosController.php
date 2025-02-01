<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandleBill;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use App\Services\ReturnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosController extends Controller
{
    use HandleBill;

    protected OrderService $orderService;
    protected ReturnService  $returnService;

    /**
     * Constructor to inject OrderService.
     *p
     * @param OrderService $orderService
     * @param ReturnService $returnService
     */
    public function __construct(OrderService $orderService, ReturnService $returnService)
    {
        $this->orderService = $orderService;
        $this->returnService = $returnService;
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
     * store the process of creating an order
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

            // commit changes
            DB::commit();

            // print the bill
            $pdfContent = $this->createBill($order);
            // return a response with JavaScript
            toastr()->success('تم انشاء الاوردر بنجاح');

            return response()->view('admin.pages.pos.redirect', [
                'pdfContent' => base64_encode($pdfContent),
                'redirectUrl' => route('pos.index'),
                ]);

        }catch (\Exception $exception){
            DB::rollBack();

            // notify the user
            toastr()->error($exception->getMessage());
            return redirect()->back();
        }
    }


    /**
     * return the product if it needed
     */
    public function edit(Order $order) {

        $order = Order::with('orderDetails')->find($order->id);
        //check if the order valid to return or not
        if($order->isValidToReturn()){
            return view('admin.pages.pos.edit', compact('order'));
        }
        else {
            toastr()->error('لا يمكن استرجاع هذا الطلب');
            return redirect()->route('orders.index');
        }

    }

    /**
     *  add returns and change the data of the orderDetails
     */
    public  function update(Order $order, Request $request) {


        // get the data and validate it
        $returnDetails = $this->returnService->getReturnsDataFromRequest($request, $order);
        if(!$returnDetails) {
            return redirect()->route('pos.return', $order);
        }

        // start the transaction
        DB::beginTransaction();
        try {
            $result = $this->returnService->returnProcess($returnDetails, $order);

            // if something wrong happen
            if(!$result) {
                DB::rollBack();
                toastr()->error('هناك خطأ في تفاصيل الاوردر يرجى التحقق من الاوردر');
                return redirect()->back();
            }
            // commit the changes
            DB::commit();

            // Notify the user and redirect
            toastr()->success('تم اضافة المنتجات التي تم استرجاعها الى المخزن');
            toastr()->success('تم انشاء المرتجع');
            return redirect()->route('orders.index');
        } catch (\Exception $exception){
            DB::rollBack();

            // Notify the user
            toastr()->error('حدث مشكلة اثناء عملية الاسترجاع يرجى التاكد من صحة الطلب او مراجعة المهندس');
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
     * generate the bills
     */
    public function generateBill(Order $order)
    {


        // Load order with details
        $order = Order::with('orderDetails')->findOrFail($order->id);
        // create bill
        $this->createBill($order);
        toastr()->success('تم طباعة المنتج بنجاح');
        return redirect()->route('pos.index');
    }
}
