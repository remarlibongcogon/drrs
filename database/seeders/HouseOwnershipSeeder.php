<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HouseOwnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            ['description' => 'Owner'],
            ['description' => 'Renter'],
            ['description' => 'Sharer']
        ];

        DB::table('house_ownership_type')->insert($cases);
    }
}
