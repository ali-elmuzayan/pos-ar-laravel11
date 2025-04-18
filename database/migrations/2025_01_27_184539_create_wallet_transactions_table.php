<?php

use App\Models\Wallet;
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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            // ensure index on foreign key
            $table->foreignIdFor(Wallet::class)->constrained()->index();
            $table->enum('type', ['deposit', 'withdraw'])->default('deposit');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('description')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Add Composite index for common query patterns
            $table->index(['wallet_id', 'type']);
            $table->index(['wallet_id', 'created_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
