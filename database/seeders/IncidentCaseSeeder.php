<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidentCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            ['description' => 'OBSTETRICS'],
            ['description' => 'MEDICAL'],
            ['description' => 'INJURY/TRAUMA'],
            ['description' => 'CARDIA'],
            ['description' => 'DISASTER'],
        ];

        DB::table('incident_case')->insert($cases);
    }
}
