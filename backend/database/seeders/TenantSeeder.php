<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tenants')->insert([
            'id' => '01936d9e-8f5a-4b2c-9d3e-1234567890ab',
            'name' => 'Demo Retail Company',
            'domain' => 'demo.nexuspos.local',
            'plan' => 'enterprise',
            'settings' => json_encode([
                'currency' => 'USD',
                'timezone' => 'America/New_York',
                'tax_rate' => 8.0,
            ]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}