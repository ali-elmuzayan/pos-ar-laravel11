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

    public function totalProfit() {
        return 0;
    }

    public function hasStock() {
        return $this->stock ? true: false;
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetails::class);
    }

//    public static function getCurrentMonthSalesSummary() {
//        $currentYear = now()->year;
//        $currentMonth = now()->month;
//
//        $result = OrderDetails::whereYear('created_at', $currentYear)
//            ->whereMonth('created_at', $currentMonth)
//            ->selectRaw('SUM(quantity) as total_quantity, SUM(total_profit) as total_profit')
//            ->first();
//
//        return [
//            'total_quantity' => $result->total_quantity,
//            'total_profit' => $result->total_profit
//        ];
//    }

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
