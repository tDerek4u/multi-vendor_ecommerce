<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            [
                'id' => 1,
                'name' => 'John',
                'address' => 'CP-122',
                'city' => 'Warshinton Dc',
                'state' => 'America',
                'country' => 'American',
                'pincode' => '110001',
                'mobile' => '97000000',
                'email' => 'john@gmail.com',
                'status' => 0,

            ]
        ];
        Vendor::insert($vendorRecords);

    }
}
