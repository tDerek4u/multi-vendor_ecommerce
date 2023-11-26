<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminsTableSeeder;
use Database\Seeders\BrandsTableSeeder;
use Database\Seeders\BannersTableSeeder;
use Database\Seeders\FiltersTableSeeder;
use Database\Seeders\SectionTableSeeder;
use Database\Seeders\VendorsTableSeeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\FiltersValueTableSeeder;
use Database\Seeders\ProductsAttributesTableSeeder;
use Database\Seeders\VendorsBusinessDetailsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(AdminsTableSeeder::class);
        // $this->call(VendorsTableSeeder::class);
        // $this->call(VendorsBusinessDetailsTableSeeder::class);
        // $this->call(VendorsBankDetailsTableSeeder::class);
        // $this->call(SectionTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        // $this->call(BrandsTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        // $this->call(ProductsAttributesTableSeeder::class);
        // $this->call(BannersTableSeeder::class);
        // $this->call(FiltersTableSeeder::class);
        // $this->call(FiltersValueTableSeeder::class);
    }
}
