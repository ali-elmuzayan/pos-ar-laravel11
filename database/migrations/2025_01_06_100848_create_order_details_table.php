<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_cost_without_discount', 8, 2)->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_profit', 10, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->timestamps();


            // Composite index for order_id and product_id
            $table->index(['order_id', 'product_id']);
            $table->index('quantity');
            $table->index('total_profit');
            $table->index('total_cost');

            // Optional: Unique constraint for order_id and product_id
            $table->unique(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
