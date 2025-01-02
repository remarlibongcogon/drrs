<?php

namespace Database\Seeders;

use App\Models\PatientCareCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientCareCasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patient_care_cases = [
            'OB',
            'Medical',
            'Injury / Trauma',
            'Cardia'
        ];

        foreach ($patient_care_cases as $patient_care_case)
        {
            PatientCareCase::firstOrCreate([
                'description' => $patient_care_case
            ]);
        }
    }
}
