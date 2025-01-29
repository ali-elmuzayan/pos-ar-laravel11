<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $guarded = [];
    public $timestamps = false;


    // get the total amount of customers
    public static function getTotalCustomerCount():int
    {
        return self::count();
    }

    // get the count of new customers created in a specific month and year
    public static function getNewCustomersCountForMonth(int $year, int $month): int
    {
        return self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
    }


    // the relationship to orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    // get the total amount that customer paid
    public function getTotalAmountPaid(): float
    {
        return $this->orders()
            ->sum('total_price'); // Sum the total_price of paid orders
    }

    // get the count of orders he pay from us
    public function getOrderCount(): int
    {
        return $this->orders()->count();
    }

    // get the new customer this month
    public static function getNewCustomersThisMonthCount(): int
    {
        return self::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
    }



}
