<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttributesRecords = [
            [
                'id' => 1,
                'product_id' => 2,
                'size' => 'Small',
                'price' => 300000,
                'stock' => 10,
                'sku' => '002-S',
                'status' => 1
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'size' => 'Medium',
                'price' => 320000,
                'stock' => 15,
                'sku' => '002-M',
                'status' => 1
            ],
            [
                'id' => 3,
                'product_id' => 2,
                'size' => 'Large',
                'price' => 350000,
                'stock' => 20,
                'sku' => '002-L',
                'status' => 1
            ],
        ];

        ProductsAttribute::insert($productAttributesRecords);
    }
}
