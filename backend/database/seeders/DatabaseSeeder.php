<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
        ]);
    }
}