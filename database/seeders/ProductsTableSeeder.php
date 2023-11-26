<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productRecords = [

            [
                'id' => 1,
                'section_id' => 1,
                'category_id' => 1,
                'brand_id' => 7,
                'vendor_id' => 1,
                'admin_id' => 2,
                'admin_type' => 'vendor',
                'product_name' => 'Nike Shirt',
                'product_code' => 'RN11',
                'product_color' => 'black',
                'product_price' => 150000,
                'product_discount' => 40,
                'product_weight' => 500,
                'product_image' => '',
                'product_video' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'is_featured' => 'Yes',
                'status' => 1
            ],
            [
                'id' => 2,
                'section_id' => 2,
                'category_id' => 5,
                'brand_id' => 2,
                'vendor_id' => 1,
                'admin_id' => 2,
                'admin_type' => 'vendor',
                'product_name' => 'K30 Ultra',
                'product_code' => 'RP11',
                'product_color' => 'black',
                'product_price' => 600000,
                'product_discount' => 10,
                'product_weight' => 600,
                'product_image' => '',
                'product_video' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'is_featured' => 'Yes',
                'status' => 1
            ],
            [
                'id' => 3,
                'section_id' => 3,
                'category_id' => 6,
                'brand_id' => 5,
                'vendor_id' => 0,
                'admin_id' => 0,
                'admin_type' => 'superadmin',
                'product_name' => 'LG Single 8kg Washing Mechine',
                'product_code' => 'RA11',
                'product_color' => 'Grey',
                'product_price' => 800000,
                'product_discount' => 20,
                'product_weight' => 1000,
                'product_image' => '',
                'product_video' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'is_featured' => 'Yes',
                'status' => 1
            ],

        ];
        Product::insert($productRecords);
    }
}
