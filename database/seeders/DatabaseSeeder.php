<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // this should run when start the app
//        Supplier::create([
//            'name' => 'بدون موزع',
//            'phone' => '0000000',
//            'email' => 'test@test.com',
//            'image' => 'null',
//        ]);

        // call the settingSededer
        $this->call([
            settingsSeeder::class,
        ]);



        // User::factory(10)->create();

//        Customer::factory(10)->create();
//        Order::factory(100)->create();
//        OrderDetails::factory(10)->create();

//        $this->call([
//            CategorySeeder::class,
//        ]);

//        $this->call([
//            SupplierSeeder::class,
//        ]);

//        $this->call([
//            ProductSeeder::class,
//        ]);


//        User::factory()->create([
//            'name' => 'Admin',
//            'username' => 'admin',
//            'email' => 'admin@example.com',
//            'password' => bcrypt('password'),
//
//        ]);
    }
}
