<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = '01936d9e-8f5a-4b2c-9d3e-1234567890ab';
        $branchId = '01936d9e-9f5a-4b2c-9d3e-1111111111aa';

        $users = [
            [
                'id' => Str::uuid(),
                'name' => 'Admin User',
                'email' => 'admin@nexuspos.com',
                'role' => 'admin',
                'pin' => '0000',
                'password' => Hash::make('password'),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Store Manager',
                'email' => 'manager@nexuspos.com',
                'role' => 'manager',
                'pin' => '1234',
                'password' => Hash::make('password'),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'John Rivera',
                'email' => 'john@nexuspos.com',
                'role' => 'cashier',
                'pin' => '1111',
                'password' => Hash::make('password'),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sarah Chen',
                'email' => 'sarah@nexuspos.com',
                'role' => 'cashier',
                'pin' => '2222',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'id' => $user['id'],
                'tenant_id' => $tenantId,
                'branch_id' => $branchId,
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => null,
                'role' => $user['role'],
                'pin' => $user['pin'],
                'password' => $user['password'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}