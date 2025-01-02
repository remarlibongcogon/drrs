<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseSeeder extends Seeder
{
    public function run()
    {
        $cases = [
            ['description' => 'OB'],
            ['description' => 'MEDICAL'],
            ['description' => 'PSYCHOLOGICAL'],
            ['description' => 'FALL'],
            ['description' => 'GUN SHOT'],
            ['description' => 'FRACTURE'],
            ['description' => 'INJURIES'],
            ['description' => 'VEHICULAR TRAUMA'],
            ['description' => 'DROWNING'],
            ['description' => 'CARDIA'],
            ['description' => 'SUICIDE'],
            ['description' => 'DEAD'],
        ];

        DB::table('case')->insert($cases);
    }
}
