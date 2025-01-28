<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    private const CASHER_WALLET = [
        'name' => 'كاشير',
        'balance' => 0,
    ];

    private const MAIN_WALLET = [
        'name' => 'الحساب الاساسي',
        'balance' => 0,
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the cashier wallet already exists
        if (!Wallet::where('name', self::CASHER_WALLET['name'])->exists()) {
            Wallet::create(self::CASHER_WALLET);
        }

        // Check if the main wallet already exists
        if (!Wallet::where('name', self::MAIN_WALLET['name'])->exists()) {
            Wallet::create(self::MAIN_WALLET);
        }
    }
}
