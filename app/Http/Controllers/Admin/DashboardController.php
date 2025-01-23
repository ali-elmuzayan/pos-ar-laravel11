<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // count of orders this month
        $totalOrders = Order::getOrdersByMonth(now()->month);
        $totalProducts = Product::count();
        $totalProfit = Order::totalProfitForAllOrders();
        $newCustomers = Customer::getNewCustomersThisMonthCount();
        return view('admin.index', compact('totalOrders', 'totalProducts', 'totalProfit', 'newCustomers'));
    }
}
