<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $genders = [
            ['description' => 'Single'],
            ['description' => 'Married'],
            ['description' => 'Divorced'],
            ['description' => 'Widowed'],
        ];

        DB::table('civil_status')->insert($genders);
    }
}