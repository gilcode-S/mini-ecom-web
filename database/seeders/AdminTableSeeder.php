<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $password = Hash::make('123456');
        // $admin = new Admin;
        // $admin->name = "GarthDev";
        // $admin->role = 'admin';
        // $admin->mobile = '00001111';
        // $admin->email = "admin@admin.com";
        // $admin->password = $password;
        // $admin->status = 1;
        // $admin->save();

        // create more admins for testing feature
        $admin = new Admin;
        $admin->name  = "Gilbert Dev";
        $admin->role = 'subadmin';
        $admin->mobile = '123123123';
        $admin->email = "dev@dev.com";
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();
        $admin = new Admin;
        $admin->name  = "HoundDev";
        $admin->role = 'subadmin';
        $admin->mobile = '123123123';
        $admin->email = "hounddev@dev.com";
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();
    }
}
