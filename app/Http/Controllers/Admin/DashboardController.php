<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\Returns;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // get the count of today's orders
        $currentOrders = Order::getCurrentOrdersCount();

        // get the count of the current month orders
        $currentMonthOrders = Order::getOrdersByMonth(now()->month);

        // amount of products sold in current month and profit of the month
        $totalProducts = Product::getCurrentDaySalesSummary()['total_quantity'];

        // profit of today

        $profitAmount = (Order::currentProfitOfToday()) - (Returns::totalReturnAmount()) ;
        // get the amount of the customer
        $newCustomers = Customer::getNewCustomersThisMonthCount();

        // Get the current year and month
        $currentMonth = date('m');

        // Fetch total orders per month for the current year
        $ordersData = Order::totalCountOfOrderForEachMonthOfTheYear();


        // Fetch expenses and profit for the current month
        $currentMonthExpenses = Expense::totalExpenseForCurrentMonth();
        // Fetch Profit of the month
        $currentMonthProfit = Order::totalProfitForMonthAndYear(now()->year, now()->month);

        // Fetch total profit per month for the current year
        $profitData = Order::totalProfitOfEachMonthInCurrentYear();

        $currentMonthReturns = Returns::currentMonthReturns();

        // data for the charts
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
                    'currentOrders',
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
