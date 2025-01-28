<?php

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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id(); // Primary key, auto-indexed
            $table->unsignedInteger('quantity_change'); // Non-negative quantity change
            $table->enum('type', ['in', 'out'])->default('in'); // Inventory change type
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete(); // Foreign key to products
            $table->timestamp('created_at')->useCurrent(); // Adds created_at and updated_at

            // Indexes
            $table->index('type'); // Index for type
            $table->index(['product_id', 'type']); // Composite index for product_id and type
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
