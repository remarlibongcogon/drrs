<?php

namespace Database\Seeders;

use App\Models\HazardStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HazardStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hazard_statuses = [
            'Active',
            'Inactive'
        ];

        foreach ($hazard_statuses as $hazard_status)
        {
            HazardStatus::firstOrCreate([
                'description' => $hazard_status
            ]);
        }
    }
}
