<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            [
                'id' => 1,
                'vendor_id' => '1',
                'account_holder_name' => 'john2000Dehli',
                'bank_name' => 'CICA',
                'account_number' => '500016438',
                'bank_ifsc_code' => '20001928001'
            ]
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}
