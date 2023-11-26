<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'Admin',
                'type' => 'superadmin',
                'vendor_id' => 0,
                'mobile' => '980000000',
                'email' => 'admin@gmail.com',
                'password' => '$2a$12$VF9GMcaT4l89xzzp/vF0AOT9M1qf/jxmIRHULF7kO7TyFVA.rzx2C',
                'image' => '',
                'status' => 1
            ],
            // [
            //     'id' => 2,
            //     'name' => 'Vendor John',
            //     'type' => 'vendor',
            //     'vendor_id' => 1,
            //     'mobile' => '970000000',
            //     'email' => 'john@gmail.com',
            //     'password' => '$2a$12$VF9GMcaT4l89xzzp/vF0AOT9M1qf/jxmIRHULF7kO7TyFVA.rzx2C',
            //     'image' => '',
            //     'status' => 0
            // ],

        ];

        Admin::insert($adminRecords);
    }
}
