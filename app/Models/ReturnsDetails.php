<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnsDetails extends Model
{
    use hasFactory;

    protected $table = 'returns_details';
    protected $guarded = [];
}
