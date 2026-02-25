<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = '01936d9e-8f5a-4b2c-9d3e-1234567890ab';

        $products = [
            ['barcode' => '012345678901', 'name' => 'Mineral Water 500ml', 'price' => 1.25, 'cost' => 0.50, 'category' => 'Beverages'],
            ['barcode' => '012345678902', 'name' => 'Orange Juice 1L', 'price' => 3.99, 'cost' => 2.20, 'category' => 'Beverages'],
            ['barcode' => '012345678903', 'name' => 'Whole Milk 1L', 'price' => 2.49, 'cost' => 1.50, 'category' => 'Dairy'],
            ['barcode' => '012345678904', 'name' => 'Greek Yogurt 500g', 'price' => 4.29, 'cost' => 2.80, 'category' => 'Dairy'],
            ['barcode' => '012345678905', 'name' => 'Sourdough Bread', 'price' => 5.50, 'cost' => 2.00, 'category' => 'Bakery'],
            ['barcode' => '012345678906', 'name' => 'Croissant', 'price' => 2.25, 'cost' => 0.90, 'category' => 'Bakery'],
            ['barcode' => '012345678907', 'name' => 'Chicken Breast 1kg', 'price' => 8.99, 'cost' => 5.50, 'category' => 'Meat'],
            ['barcode' => '012345678908', 'name' => 'Atlantic Salmon 500g', 'price' => 12.49, 'cost' => 8.00, 'category' => 'Seafood'],
            ['barcode' => '012345678909', 'name' => 'Cherry Tomatoes 250g', 'price' => 2.99, 'cost' => 1.20, 'category' => 'Produce'],
            ['barcode' => '012345678910', 'name' => 'Baby Spinach 150g', 'price' => 3.49, 'cost' => 1.80, 'category' => 'Produce'],
            ['barcode' => '012345678911', 'name' => 'Cheddar Cheese 400g', 'price' => 6.79, 'cost' => 4.20, 'category' => 'Dairy'],
            ['barcode' => '012345678912', 'name' => 'Pasta Penne 500g', 'price' => 1.99, 'cost' => 0.80, 'category' => 'Pantry'],
            ['barcode' => '012345678913', 'name' => 'Olive Oil 500ml', 'price' => 9.99, 'cost' => 6.00, 'category' => 'Pantry'],
            ['barcode' => '012345678914', 'name' => 'Dark Chocolate 100g', 'price' => 3.75, 'cost' => 2.00, 'category' => 'Snacks'],
            ['barcode' => '012345678915', 'name' => 'Potato Chips 200g', 'price' => 2.89, 'cost' => 1.40, 'category' => 'Snacks'],
            ['barcode' => '012345678916', 'name' => 'Coffee Beans 500g', 'price' => 14.99, 'cost' => 9.00, 'category' => 'Beverages'],
            ['barcode' => '012345678917', 'name' => 'Green Tea Bags x20', 'price' => 4.99, 'cost' => 2.50, 'category' => 'Beverages'],
            ['barcode' => '012345678918', 'name' => 'Honey 350g', 'price' => 7.50, 'cost' => 4.50, 'category' => 'Pantry'],
            ['barcode' => '012345678919', 'name' => 'Peanut Butter 400g', 'price' => 5.25, 'cost' => 3.00, 'category' => 'Pantry'],
            ['barcode' => '012345678920', 'name' => 'Whole Wheat Bread', 'price' => 4.75, 'cost' => 1.80, 'category' => 'Bakery'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'id' => Str::uuid(),
                'tenant_id' => $tenantId,
                'barcode' => $product['barcode'],
                'sku' => 'SKU-' . substr($product['barcode'], -6),
                'name' => $product['name'],
                'description' => null,
                'price' => $product['price'],
                'cost' => $product['cost'],
                'tax_rate' => 0.08,
                'category' => $product['category'],
                'unit' => 'each',
                'image_url' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}