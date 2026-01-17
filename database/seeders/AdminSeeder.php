<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@admin.com',
            'password' => Hash::make('password123'),
            'role'     => 'super_admin',
            'mobile'   => '09999999999',
            'status'   => 1,
        ]);
    }
}
