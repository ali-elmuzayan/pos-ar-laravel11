<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Log;

class OrderService
{

    public function createOrder(array $data): Order
    {
        dd($data);
        $order = Order::create($data);

        Log::info('Order created successfully', ['order_id' => $order->id]);

        return $order;
    }

    public function createOrderDetails(array $data): OrderDetails
    {

    }
}
