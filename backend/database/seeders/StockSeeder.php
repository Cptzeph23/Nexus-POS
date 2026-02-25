<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $branchIds = [
            '01936d9e-9f5a-4b2c-9d3e-1111111111aa',
            '01936d9e-9f5a-4b2c-9d3e-2222222222bb',
            '01936d9e-9f5a-4b2c-9d3e-3333333333cc',
        ];

        $products = DB::table('products')->get();

        foreach ($branchIds as $branchId) {
            foreach ($products as $product) {
                DB::table('branch_stock')->insert([
                    'id' => Str::uuid(),
                    'branch_id' => $branchId,
                    'product_id' => $product->id,
                    'quantity' => rand(20, 200),
                    'reorder_point' => 10,
                    'max_stock' => 500,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}