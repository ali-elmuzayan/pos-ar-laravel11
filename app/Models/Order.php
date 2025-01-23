<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];

    // Relationship to OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // return the amount of products in that order
    public function products(): int
    {
        return $this->orderDetails()->count();
    }

    // calculate the profit of th order
    public function profit()
    {

        return $this->orderDetails->sum(function ($orderDetail) {
            return ($orderDetail->product->buying_price * $orderDetail->quantity) - $orderDetail->total_cost;
        });
    }

    public static function totalProfitForAllOrders(): float
    {
        return self::with('orderDetails')->get()->sum(function ($order) {
            return $order->profit();
        });
    }

    public static function totalProfitForMonthAndYear(int $month, int $year): float
    {
        return self::with('orderDetails')
            ->whereYear('created_at', $year) // Filter by year
            ->whereMonth('created_at', $month) // Filter by month
            ->get()
            ->sum(function ($order) {
                return $order->profit();
            });
    }

    /**
     * get the number of order by the month
     */
    public static function getOrdersByMonth($month) {
        // get the current year
        $year = now()->year;

        return self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)->count();
    }

    /**
     * Get the count of orders for each of the last 6 months.
     */
    public static function getOrderByMonth()
    {
        // Step 1: Generate the last 6 months
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $date = now()->subMonths($i);
            $months[] = [
                'year' => $date->year,
                'month' => $date->month,
                'month_name' => $date->format('F'), // Optional: Include month name
            ];
        }

        // Step 2: Query the database for order counts in the last 6 months
        $orders = self::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as order_count')
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth()) // Filter for the last 6 months
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . $item->month; // Create a unique key for each month
            });

        // Step 3: Merge the generated months with the query results
        $result = [];
        foreach ($months as $month) {
            $key = $month['year'] . '-' . $month['month'];
            $result[] = [
                'year' => $month['year'],
                'month' => $month['month'],
                'month_name' => $month['month_name'], // Optional: Include month name
                'order_count' => $orders->has($key) ? $orders[$key]->order_count : 0, // Default to 0 if no orders
            ];
        }

        // Reverse the array to show the most recent month first
        return array_reverse($result);
    }

}
