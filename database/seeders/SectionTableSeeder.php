<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionRecords = [
            [
                'id' => 1,
                'name' => 'Clothing',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'Electronic',
                'status' => 1
            ],
            [
                'id' => 3,
                'name' => 'Appliances',
                'status' => 1
            ]
        ];

        Section::insert($sectionRecords);
    }
}
