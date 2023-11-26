<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            [
                'id' => 1,
                'vendor_id' => 1,
                'shop_name' => 'John Electronic Store',
                'shop_address' => '146-SCF',
                'shop_city' => 'New Delhi',
                'shop_state' => 'Delhi',
                'shop_country' => 'India',
                'shop_pincode' => '101156',
                'shop_mobile' => '96000000',
                'shop_website' => 'sitemakers.in',
                'shop_email' => 'john@gmail.com',
                'address_proof' => 'Passport',
                'address_proof_image' => 'test.jpg',
                'business_license_number' => '20/KTN/464657',
                'gst_number' => '45674443',
                'pan_number' => '58536584'
            ]
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
