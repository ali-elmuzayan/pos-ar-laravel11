<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    public $table = 'wallet_transactions';

    // disable automatic timestamps
    public $timestamps = false;
    protected $guarded = [];

    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }


    // which will return the type in arabic
    public function type() {
        return ($this->type === 'deposit') ? 'ايداع' : 'سحب';
    }

}
