<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample products
        Product::create(['name' => 'Laptop', 'price' => 15000000, 'stock' => 10]);
        Product::create(['name' => 'Mouse', 'price' => 150000, 'stock' => 50]);
        Product::create(['name' => 'Keyboard', 'price' => 500000, 'stock' => 30]);
        Product::create(['name' => 'Monitor', 'price' => 2000000, 'stock' => 15]);

        // Create sample customers
        Customer::create(['name' => 'Kevin Jonathan', 'phone' => '081234567890']);
        Customer::create(['name' => 'Sean Albert', 'phone' => '081234567891']);
        Customer::create(['name' => 'Yosafat Elim', 'phone' => '081234567892']);
    }
}
