<?php

namespace App\Services;

use App\Http\Traits\HandleBarcode;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    use handleBarcode;

    /**
     * create the order data and handle customer information
     */
    public function createOrder(array $data): Order
    {
        // Ensure the customer exists or create a new one

        if (isset($data['phone'])){
        $customer = $this->getCustomer($data['phone'], $data['customer_name']);
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
            'discount' => $data['discount'] ?? 0,
            'cash_discount' => $data['cash_discount'] ?? 0,
            'pay' => $data['pay'] ?? $data['total_price'],
            'due' => !empty($data['pay']) ? $data['due'] : 0 ,
            'customer_id' => !empty($customer) ? $customer->id : null,
        ]);

        Log::info('Order created successfully', ['order_id' => $order->id]);

        return $order;
    }

    /**
     *  create the order details and handle the amount in the product
     */
    public function createOrderDetails(Order $order, array $orderDetails): void
    {
        $cash_discount_of_each_product =  $order->cash_discount / $order->total_products ;

        $discount = $order['discount'] ?? 0;
        foreach ($orderDetails as $detail) {
            $product = Product::find($detail['id']);

            if($product->stock < $detail['quantity']){
                throw new \Exception('المنتج غير موجود كمية كافية في المخزن');
            }

            $unitCost = ($product->selling_price - ($product->selling_price * ($discount / 100))) - $cash_discount_of_each_product;

            $totalProfit = (($unitCost) - ($product->buying_price) )* $detail['quantity']; ;
            $totalCost = ($unitCost) * ($detail['quantity']);
            OrderDetails::create([
                'quantity' => $detail['quantity'],
                'unit_cost_without_discount' => $product->selling_price,
                'unit_cost' => $unitCost,
                'total_profit' => $totalProfit ,
                'total_cost' =>  $totalCost,
                'order_id' => $order->id,
                'product_id' => $detail['id'],
            ]);

            $product->update(['stock' => $product->stock - $detail['quantity']]);
        }

        Log::info('Order details created successfully', ['order_id' => $order->id]);
    }

    /**
     * get the customer data and create it if he is not exist in
     * storage
     */
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


    /**
     * process the order process by create the order and customer if not
     * exist then create order details after that you can deposit the money
     */
    public function processOrder(array $orderData, array $orderDetailsData): Order
    {
        // Create the order
        $order = $this->createOrder($orderData);

        // Create the order details
        $this->createOrderDetails($order, $orderDetailsData);

        // add the transaction
        $this->createTransaction($order);

        return $order;
    }



    /**
     * get the data of the order details and handle it
     */
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



    /**
     * get the data of the order from the request
     */
    public function getOrderRequest(array $request) {
        $total_product = 0;
        foreach($request['quantity_arr'] as $qty)
            $total_product += $qty;

        return [
           'subTotal' => $request['txtsubtotal'],
           'discount' => $request['txtdiscount'] ?? 0,
            'cash_discount' => $request['cash_discount'] ?? 0,
           'phone' => $request['customer_phone'] ?? null,
           'customer_name' => $request['customer_name'] ?? null,
            'total_products' => $total_product,
           'total_price' => $request['txttotal'] ,
           'type_pay' => $request['rb'] ?? 'cash',
           'due' => $request['txtdue'] ?? 0,
           'paid' => $request['txtpaid'] ?? 0,
       ];
    }

    /**
     * create the transaction and deposit to the wallet
     */
    public function createTransaction(Order $order) {
       $walletTransaction = WalletTransaction::create([
            'amount' => $order['total_price'],
            'type' => 'deposit',
            'wallet_id' => 1,
        ]);
       $wallet = Wallet::where('id', $walletTransaction->wallet_id)->first();
       $wallet->balance = $wallet->balance + $walletTransaction->amount;
       $wallet->save();
    }

}
