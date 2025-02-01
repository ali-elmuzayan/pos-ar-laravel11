<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function supplier() : BelongsTo
    {
        return $this->belongsTo(supplier::class);
    }


    public function hasStock() {
        return $this->stock ? true: false;
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetails::class);
    }

    public function totalProfit() {
        // Sum teh refund_amount from the returns relationship
        $returns_amount = $this->orderDetails->flatMap(function ($orderDetail) {
            return $orderDetail->returns->pluck('refund_amount');
        })->sum();

        $total_cost = $this->orderDetails()->sum('total_cost');

        return $total_cost -  $returns_amount;
    }

    public function totalAmountOfSoldProduct() {
        $returns_amount = $this->orderDetails->flatMap(function ($orderDetail) {
            return $orderDetail->returns->pluck('total_quantity');
        })->sum();

        $total_amount = $this->orderDetails()->sum('quantity');

        return $total_amount - $returns_amount;
    }

    public static function getCurrentMonthSalesSummary() {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Get the total quantity and total profit for the current month
        $salesResult = OrderDetails::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->selectRaw('SUM(quantity) as total_quantity, SUM(total_profit) as total_profit')
            ->first();

        // Get the total returned quantity and total refund amount for the current month
        $returnsResult = Returns::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->selectRaw('SUM(total_quantity) as total_returned_quantity, SUM(refund_amount) as total_refund_amount')
            ->first();

    // Calculate the real quantity and real profit
    $realQuantity = $salesResult->total_quantity - ($returnsResult->total_returned_quantity ?? 0);
    $realProfit = $salesResult->total_profit - ($returnsResult->total_refund_amount ?? 0);

    return [
        'total_quantity' => $realQuantity,
        'total_profit' => $realProfit
    ];
}

    public static function getCurrentDaySalesSummary() {
        $currentDay = now()->day;
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Get the total quantity and total profit for the current month
        $salesResult = OrderDetails::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereDay('created_at', $currentDay)
            ->selectRaw('SUM(quantity) as total_quantity, SUM(total_profit) as total_profit')
            ->first();

        // Get the total returned quantity and total refund amount for the current month
        $returnsResult = Returns::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereDay('created_at', $currentDay)
            ->selectRaw('SUM(total_quantity) as total_returned_quantity, SUM(refund_amount) as total_refund_amount')
            ->first();

        // Calculate the real quantity and real profit
        $realQuantity = $salesResult->total_quantity - ($returnsResult->total_returned_quantity ?? 0);
        $realProfit = $salesResult->total_profit - ($returnsResult->total_refund_amount ?? 0);

        return [
            'total_quantity' => $realQuantity,
            'total_profit' => $realProfit
        ];
    }

}
