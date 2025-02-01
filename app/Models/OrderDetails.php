<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function profit(): float
    {
        return ($this->selling_price - $this->buying_price) * $this->quantity;
    }

    // Other model properties and methods

    public function returns()
    {
        return $this->hasMany(Returns::class);
    }

    public function validToReturn() {
        // Check if the status allows returns
        if (!$this->status) {
            // Get the total quantity of returns related to this order detail
            $totalReturnedQuantity = $this->returns()->sum('total_quantity');

            // Compare the total returned quantity with the order detail quantity
            if ($totalReturnedQuantity < $this->validQtyToReturn()) {
                // The total returned quantity is less than the order detail quantity
                return true;
            } else {
                // The total returned quantity is equal to or greater than the order detail quantity
                return false;
            }
        } else {
        // If the status does not allow returns, return false
        return true;
        }

    }

    /**
     * change the status of the order details use it when the customer return all
     * the item
     */
    public function changeStatus() {
         $this->status  = 1;
         $this->save();
    }

    /**
     *  return the valid quantity to return
     */
    public function validQtyToReturn() {
        return $this->quantity - $this->returns()->sum('total_quantity');

    }


    public function addQuantityToProduct(string|int $quantity) :void {
        $this->product->stock += $quantity;
        $this->product->save();
    }
}
