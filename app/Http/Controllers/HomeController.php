<?php

namespace App\Http\Controllers;

use App\Models\Hazard;
use App\Models\Shelter;
use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $hazards = Hazard::where('hazardStatus', 1)->get();
        $shelters = Shelter::all();
        $incidents = IncidentReport::where('isConfirmed', 1)->where('typeOfIncident', 3)->whereNotNull('coordinates')->pluck('coordinates');

        $latestHazard = Hazard::latest()->first();

        $hazardAlert = false;
        if ($latestHazard) {
            $hazardTime = Carbon::parse($latestHazard->created_at);
            $timeDifference = $hazardTime->diffInMinutes(Carbon::now());
            if ($timeDifference <= 90) {
                $hazardAlert = true;
            }
            
        }
        return view('pages.home.view', compact('hazards', 'shelters', 'latestHazard', 'hazardAlert', 'incidents'));
    }
}
