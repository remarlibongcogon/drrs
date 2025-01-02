<?php

namespace Database\Seeders;

use App\Models\VehicularAccidentTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicularAccidentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicular_accidents = [
            'Frontal',
            'Rear',
            'Lateral'
        ];

        foreach ($vehicular_accidents as $vehicular_accident)
        {
            VehicularAccidentTypes::firstOrCreate([
                'description' => $vehicular_accident
            ]);
        }
    }
}
