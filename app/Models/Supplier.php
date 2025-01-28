<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    public $timestamps= false;
    protected $guarded = [];

    public function products() :HasMany {
        return $this->hasMany(Product::class);
    }

    public function countOfProducts() :int {
        return $this->products()->count();
    }
}
