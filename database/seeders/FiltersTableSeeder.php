<?php

namespace Database\Seeders;

use App\Models\ProductsFilter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filterRecords = [
            [
                'id' => 1,
                'cat_ids' => '1,3,7,6',
                'filter_name' => 'Fabric',
                'filter_column' => 'fabric',
                'status' => 1
            ],
            [
                'id' => 2,
                'cat_ids' => '2,4,5,8',
                'filter_name' => 'RAM',
                'filter_column' => 'ram',
                'status' => 1
            ]
        ];

        ProductsFilter::insert($filterRecords);
    }
}
