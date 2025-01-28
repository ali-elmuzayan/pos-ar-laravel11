<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use hasFactory;

    protected $table = 'inventory';
    protected $guarded = [];
    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
