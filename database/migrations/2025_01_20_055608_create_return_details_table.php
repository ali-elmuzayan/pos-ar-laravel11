<?php

use App\Models\Product;
use App\Models\Returns;
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
        Schema::create('returns_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('total_price');
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Returns::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns_details');
    }
};
