<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'expenses';
    public $timestamps = false;

    /**
     * Get expenses for the current month.
     */
    public static function ExpensesInCurrentMonth()
    {
        $currentMonth = now()->month; // Get the current month
        $currentYear = now()->year;   // Get the current year

        return self::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();
    }

    public static function totalExpenseForCurrentMonth(){
        $currentMonth = now()->month;
        $currentYear = now()->year;
        return self::WhereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');
    }
}
