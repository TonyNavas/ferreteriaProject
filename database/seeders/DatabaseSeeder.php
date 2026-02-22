<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Customer, Product, Supplier, User};
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Tony Navas',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([CategorySeeder::class]);
        $this->call([IdentitySeeder::class]);
        $this->call([WarehouseSeeder::class]);

        Customer::factory(50)->create();
        Product::factory(100)->create();
        Supplier::factory(50)->create();
    }
}
