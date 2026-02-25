<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = '01936d9e-8f5a-4b2c-9d3e-1234567890ab';

        $branches = [
            [
                'id' => '01936d9e-9f5a-4b2c-9d3e-1111111111aa',
                'name' => 'Downtown Store',
                'code' => 'DT01',
                'address' => json_encode([
                    'street' => '123 Main Street',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10001',
                    'country' => 'USA',
                ]),
            ],
            [
                'id' => '01936d9e-9f5a-4b2c-9d3e-2222222222bb',
                'name' => 'Uptown Store',
                'code' => 'UT01',
                'address' => json_encode([
                    'street' => '456 Park Avenue',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10022',
                    'country' => 'USA',
                ]),
            ],
            [
                'id' => '01936d9e-9f5a-4b2c-9d3e-3333333333cc',
                'name' => 'Brooklyn Store',
                'code' => 'BK01',
                'address' => json_encode([
                    'street' => '789 Atlantic Ave',
                    'city' => 'Brooklyn',
                    'state' => 'NY',
                    'zip' => '11201',
                    'country' => 'USA',
                ]),
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->insert([
                'id' => $branch['id'],
                'tenant_id' => $tenantId,
                'name' => $branch['name'],
                'code' => $branch['code'],
                'address' => $branch['address'],
                'settings' => json_encode([
                    'tax_rate' => 8.0,
                    'currency' => 'USD',
                    'receipt_footer' => 'Thank you for shopping with us!',
                    'timezone' => 'America/New_York',
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}