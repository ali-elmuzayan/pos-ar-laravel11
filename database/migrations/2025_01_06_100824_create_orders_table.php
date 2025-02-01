<?php

use App\Models\Customer;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order_status')->default(0);
            $table->string('invoice_no', 20)->unique();
            $table->integer('total_products');
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('total_price', 12,2);
            $table->decimal('discount',8,2)->default(0);
            $table->decimal('cash_discount',8,2)->default(0);
            $table->decimal('pay', 12,2)->default(0);
            $table->decimal('due', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'card'])->default('cash');
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            // Indexes
            $table->index('order_status'); // Index for order status
            $table->index('invoice_no');
            $table->index('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
