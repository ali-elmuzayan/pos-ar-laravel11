<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = [];

    public function transactions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdraw($amount) {
        $this->balance = $this->balance - $amount;
        $this->save();
    }

    public function deposit($amount) {
        $this->balance = $this->balance + $amount;
        $this->save();
    }

    public function hasBalance($amount) {
        return $this->balance >= $amount;
    }
}
