<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    public function run()
    {
        $genders = [
            ['description' => 'Male'],
            ['description' => 'Female'],
            ['description' => 'Other'],
        ];

        DB::table('gender')->insert($genders);
    }
}
