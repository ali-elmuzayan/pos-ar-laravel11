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
            $table->date('date');
            $table->tinyInteger('order_status')->default(0);
            $table->string('invoice_no');
            $table->string('total_products');
            $table->decimal('total_price');
            $table->string('sub_total')->nullable();
            $table->string('vat')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('pay')->nullable();
            $table->string('due')->nullable();
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
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
