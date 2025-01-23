<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];

    public function products() {
        return $this->hasMany(Product::class);
    }
    /**
     * Get the count of products related to the category.
     */
    public function productCount()
    {
        return $this->products()->count();
    }

    /**
     * get products related to the category that have more than
     * 1 value in stock
     */
    public function validProductsInStock() {
        return $this->products()->where('stock', '>=', 1)->get();
    }

}
