<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class settingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => 'اسم الشركة',
            'logo' => 'uploads/no-logo.png',
            'description' =>'متجر متخصصة في بيع المنتجات النسائية',
            'address' => 'سمالوط غرب - شارع اسواق الاتحاد - امام تاون تيم',
            'phone' => '01010232458',
            'backup_dir' => '/backups/',
            'exchange_period' => 14,
            'return_period' => 7,
            'data_per_page' => 15,
            'currency' => 'EGP',
        ]);
    }

}
