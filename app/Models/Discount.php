<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';
    public $timestamps = false;
    protected $fillable = [
        'percent',
        'end_date'
    ];

    /**
     * Get all valid discounts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getValidDiscounts()
    {
        $today = Carbon::today()->toDateString(); // Get today's date as a string

        return self::where(function ($query) use ($today) {
            $query->whereNull('end_date') // Discounts with no end_date are always valid
            ->orWhere('end_date', '>=', $today); // Discounts with end_date in the future
        })->get();
    }

    public function valid(): bool
    {
        // If end_date is null, the discount is always valid
        if ($this->end_date === null) {
            return true;
        }

        // Get the current date (without time)
        $today = Carbon::today();

        // Compare the end_date with the current date
        return Carbon::parse($this->end_date)->greaterThanOrEqualTo($today);
    }
}
