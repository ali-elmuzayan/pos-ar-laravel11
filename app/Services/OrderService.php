<?php

namespace App\Services;

use App\Http\Traits\HandleBarcode;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrderService
{
    use handleBarcode;
    public function createOrder(array $data): Order
    {
        // Ensure the customer exists or create a new one
        if (isset($data['customer_phone'])){
        $customer = $this->getCustomer($data['customer_phone'], $data['customer_name']);
        }else {
            $customer = null;
        }

        // get last order code
        $lastOrderCode = Order::latest('id')->value('invoice_no');

        // Generate a unique invoice number
        $invoiceNo = 'O-' . $this->generateCode($lastOrderCode);


        // Create the order
        $order = Order::create([
            'order_status' =>  0,
            'invoice_no' => $invoiceNo,
            'total_products' => $data['total_products'],
            'sub_total' => $data['subTotal'],
            'total_price' => $data['total_price'],
            'discount' => $data['discount'] ?? null,
            'pay' => $data['pay'] ?? $data['total_price'],
            'due' => !empty($data['pay']) ? $data['due'] : 0 ,
            'customer_id' => !empty($customer->id) ? $customer->id : null,
        ]);

        Log::info('Order created successfully', ['order_id' => $order->id]);

        return $order;
    }

    public function createOrderDetails(Order $order, array $orderDetails): void
    {
        $discount = $order['discount'] ?? 0;
        foreach ($orderDetails as $detail) {
            $product = Product::find($detail['id']);

            $unitCost = ($product->selling_price - ($product->selling_price * $discount));
            $totalProfit = (($unitCost) - ($product->buying_price) )* $detail['quantity']; ;
            $totalCost = ($unitCost) * ($detail['quantity']);
            OrderDetails::create([
                'quantity' => $detail['quantity'],
                'unit_cost' => $unitCost,
                'total_profit' => $totalProfit ,
                'total_cost' =>  $totalCost,
                'order_id' => $order->id,
                'product_id' => $detail['id'],
            ]);
        }

        Log::info('Order details created successfully', ['order_id' => $order->id]);
    }

    public function getCustomer($phone, $name = null) {
        $customer = Customer::where('phone', '=', $phone)->first();
        if(empty($customer)){
            $customer = Customer::create([
                'phone' => $phone,
                'name' => !empty($name) ? $name : null,
            ]);
        }
        return $customer;
    }

    public function processOrder(array $orderData, array $orderDetailsData): Order
    {
        // Create the order
        $order = $this->createOrder($orderData);

        // Create the order details
        $this->createOrderDetails($order, $orderDetailsData);

        return $order;
    }

    public function getOrderDetails(array $orderDetails) {
        if (isset($orderDetails['pid_arr']) && isset($orderDetails['quantity_arr']) && count($orderDetails['pid_arr']) === count($orderDetails['quantity_arr'])) {

            $items = [];
            // Loop through 'pid_arr' and 'quantity' arrays and combine the values
            foreach ($orderDetails['pid_arr'] as $key => $id) {
                $items[] = [
                    'id' => $id,
                    'quantity' => (int) $orderDetails['quantity_arr'][$key], // Explicitly cast to integer to avoid unexpected behavior
                ];
            }
            return $items;
            // Optionally, you can use the $items array for further processing, like saving to the database
        } else {
            // Handle invalid request data (either 'pid_arr' or 'quantity' missing, or the arrays have different lengths)
            toastr()->error('المنتجات او الكميات التي ادخلتها غير صحيحة');
            return false ;
        }
    }

    // get the order data =
    public function getOrderRequest(array $request) {
        $total_product = 0;
        foreach($request['quantity_arr'] as $qty)
            $total_product += $qty;

        return [
           'subTotal' => $request['txtsubtotal'],
           'discount' => $request['txtdiscount'] ?? 0,
           'phone' => $request['customer_phone'] ?? null,
            'total_products' => $total_product,
           'total_price' => $request['txttotal'] ,
           'type_pay' => $request['rb'] ?? 'cash',
           'due' => $request['txtdue'] ?? 0,
           'paid' => $request['txtpaid'] ?? 0,
       ];
    }

}
