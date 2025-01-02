<?php

namespace Database\Seeders;

use App\Models\InjuryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InjuryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $injury_types = [
            'Vehiclular',
            'Fall',
            'Cut',
            'Broken',
            'Gunshot',
            'Drowning',
            'Electrecuted',
            'Suicide',
            'Burns'
        ];

        foreach ($injury_types as $injury_type)
        {
            InjuryType::firstOrCreate([
                'description' => $injury_type
            ]);
        }
    }
}
