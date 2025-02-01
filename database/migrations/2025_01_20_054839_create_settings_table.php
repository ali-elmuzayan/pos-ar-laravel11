<?php

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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 20);
            $table->string('backup_dir')->nullable();
            $table->integer('return_period')->nullable();
            $table->integer('exchange_period')->nullable();
            $table->string('data_per_page')->default(15);
            $table->string('currency')->nullable();
            $table->string('wallet_password')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('phone'); // Index for phone
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
