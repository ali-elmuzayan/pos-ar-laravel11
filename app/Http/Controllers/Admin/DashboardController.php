<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $currentMonthOrders = Order::getOrdersByMonth(now()->month);

        // amount of products sold in current mont and profit of the month
        $currentMonthSalesSummary = Product::getCurrentDaySalesSummary();
        $totalProducts = $currentMonthSalesSummary['total_quantity'];
        $profitAmount = $currentMonthSalesSummary['total_profit'];

        // get the amount of the customer
        $newCustomers = Customer::getNewCustomersThisMonthCount();

        // Get the current year and month
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Fetch total orders per month for the current year
        $ordersData = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total_orders')
            ->whereYear('created_at', $currentYear) // Filter by current year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fetch total profit per month for the current year
        $profitData = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_profit')
            ->whereYear('created_at', $currentYear) // Filter by current year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fetch expenses and profit for the current month
        $currentMonthExpenses = DB::table('expenses') // Assuming you have an 'expenses' table
        ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount'); // Sum of expenses for the month

        // Fetch Profit of the month
        $currentMonthProfit = DB::table('orders')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_price'); // Sum of profit for the month


        // Fetch total profit per month for the current year
        $profitData = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_profit')
            ->whereYear('created_at', $currentYear) // Filter by current year
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $currentMonthReturns = DB::table('returns') // Assuming you have a 'returns' table
        ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        $arabicMonths = [
            'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ];

        // Prepare data for Chart.js
        $months = [];
        $totalOrders = [];
        $totalProfit = [];

        // Loop through each month up to the current month
        for ($i = 1; $i <= $currentMonth; $i++) {
            $months[] = $arabicMonths[$i - 1]; // Use Arabic month names
            $totalOrders[] = $ordersData->where('month', $i)->first()->total_orders ?? 0;
            $totalProfit[] = $profitData->where('month', $i)->first()->total_profit ?? 0;
        }

            return view('admin.index',
                compact(
                    'months',
                    'totalOrders',
                    'totalProfit',
                    'currentMonthOrders',
                    'newCustomers',
                    'totalProducts',
                    'profitAmount',
                    'currentMonthReturns',
                    'currentMonthExpenses',
                    'currentMonthProfit',
                    'profitData',
                ));
    }
}
