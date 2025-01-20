<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                Supplier::create([
            'name' => 'بدون موزع',
            'phone' => '0000000',
            'email' => 'test@test.com',
            'image' => 'null',
        ]);
    }
}
