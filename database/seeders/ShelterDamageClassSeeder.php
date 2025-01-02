<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ShelterDamageClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            ['description' => 'Paritally Damaged'],
            ['description' => 'Totally Damage'],
        ];

        DB::table('shelter_damage_classification')->insert($cases);
    }
}
