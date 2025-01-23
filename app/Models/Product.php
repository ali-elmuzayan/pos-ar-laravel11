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
}
