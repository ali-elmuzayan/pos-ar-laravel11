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


}
