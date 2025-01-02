<?php

namespace App\Http\Controllers;

use App\Models\Hazard;
use App\Models\IncidentReport;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {

        // if authenticated, go to home instead
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $hazards = Hazard::where('hazardStatus', 1)->get();
        $shelters = Shelter::all();
        $incidents = IncidentReport::where('isConfirmed', 1)->where('typeOfIncident', 3)->whereNotNull('coordinates')->pluck('coordinates');

        $latestHazard = Hazard::latest()->first();

        $hazardAlert = false;
        if ($latestHazard) {
            $hazardTime = Carbon::parse($latestHazard->created_at);
            $timeDifference = $hazardTime->diffInMinutes(Carbon::now());

            // Check if the time difference < 1 hour and 30 mins
            if ($timeDifference <= 90) {
                $hazardAlert = true;
            }
        }

        return view('pages.landingPage.view', compact('hazards', 'shelters', 'latestHazard', 'hazardAlert','incidents'));
    }
}
