<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{

    protected $table = 'returns';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * Get the order associated with the return.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the order details associated with the return.
     */
    public function orderDetails()
    {
        return $this->belongsTo(OrderDetails::class);
    }

    /**
     * Get the user who processed the return.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * return the total refund amount fo the day
     */
    public static function totalReturnAmount() {

        return self::whereDay('created_at', now()->day)->sum('refund_amount');
    }

    public static function currentMonthReturns() {
        return self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

}
