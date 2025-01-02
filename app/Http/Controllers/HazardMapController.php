<?php

namespace App\Http\Controllers;

use App\Models\Hazard;
use App\Models\Shelter;
use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HazardMapController extends Controller
{
    public function index()
    {
        $hazards = Hazard::where('hazardStatus', 1)->get();
        $shelters = Shelter::all();
        $incidents = IncidentReport::where('isConfirmed', 1)->where('typeOfIncident', 3)->whereNotNull('coordinates')->pluck('coordinates');

        return view('pages.hazardMap.view', compact('hazards', 'shelters', 'incidents'));
    }

    public function create()
    {

        return view('pages.hazardMap.add');
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(),[
            'hazardName' => 'required|string|max:255',
            'coordinates' => 'required|string|min:1',
        ]);

        if($validator->fails())
        {
            return redirect()->back()->with('error', 'Oh no! An error occured.');
        }
 
        try{
            $zone = Hazard::create([
                'hazardName' => $request->hazardName,
                'hazardStatus' => 1,
                'coordinates' => $request->coordinates,
            ]);

            return redirect()->intended(route('hazard_map.index'))->with('success', 'Hazard added successfully');  

        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'Oh no! An error has occured');
        }  

    }

    public function edit($id)
    {
        $hazard = Hazard::findOrFail($id);

        if($hazard)
        {
            return view('pages.hazardMap.editHazard', compact('hazard'));
        }

        return redirect()->back()->with('error', 'Hazard doesn\'t exist');
    }

    public function update(Request $request, $id)
    {
        // Validate incoming data
        $validation = $request->validate([
            'hazardName' => 'required|string|max:255',
            'coordinates' => 'required|string|min:1',
        ]);

        $hazard = Hazard::findOrFail($id);
        $hazard->update($request->all());

        return redirect()->route('hazard_map.shelter')->with('success', 'Shelter updated successfuly!');;
    }

    public function updateHazardStatus(Request $request, $id)
    {
        $hazard = Hazard::findOrFail($id);

        if(!$hazard)
        {   
            return redirect()->back()->with('error', 'Hazard doesn\'t exist');
        }

        $hazard->update([
            'hazardStatus' => 2,
        ]);

        return redirect()->route('hazard_map.shelter')->with('success','Hazard status is set to inactive!');
    }
    public function shelterCreate()
    {
        return view('pages.hazardMap.add-shelter');
    }

    public function shelter_edit(Request $request, $id)
    {
        $shelter = Shelter::findOrFail($id);

        if (!$shelter)
        {
            return redirect()->back()->with('error', 'Shelter not found!');
        }

        return view('pages.hazardMap.edit-shelter', compact('shelter'));
    }

    public function shelter_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'shelterName' => 'nullable|string',
            'shelterCoordinates' => 'nullable|string',
            'shelterImagePath' => 'nullable|image|max:10240',
        ]);

        if ($validator->fails()) {
            dd($request->all(), $request->file('shelterImagePath'));
            return redirect()->back()->with('error', 'Oh no! An error occured.');
        }

        $shelter = Shelter::findOrFail($id);

        if (!$shelter) {
            return redirect()->back()->with('error', 'Shelter not found!');
        }

        $updateData = $request->only(['shelterName', 'shelterCoordinates']);

        if ($request->hasFile('shelterImagePath')) {
            if ($shelter->shelterImagePath) {
                Storage::disk('public')->delete($shelter->shelterImagePath); //delete old image
            }

            // save new image
            $updateData['shelterImagePath'] = $request->file('shelterImagePath')->store('shelter_photos', 'public');
        }

        $shelter->update($updateData); 

        return redirect()->route('hazard_map.shelter')->with('success', 'Shelter updated successfuly!');
    }

    public function shelterStore(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(),[
            'shelterName' => 'required|string|max:255',
            'shelterCoordinates' => 'required|string|min:1',
            'shelterImagePath' => 'image|max:10240', // max 10mb image file
        ]);

        try {
            $photoPath = null;
            if ($request->hasFile('shelterImagePath')) { // Match the form input name
                $photoPath = $request->file('shelterImagePath')->store('shelter_photos', 'public');
            }
        
            $shelter = Shelter::create([ 
                'shelterName' => $request->shelterName,
                'shelterCoordinates' => $request->shelterCoordinates,
                'shelterImagePath' => $photoPath
            ]);
        
            return redirect()->intended(route('hazard_map.index'))->with('success', 'Shelter added successfully!');
        } catch(\Exception $e) {
            \Log::error('Shelter creation error: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Oh no! An error has occurred');
        }    
    }

    public function shelterDelete($id)
    {
        $shelter = Shelter::findOrFail($id);

        if(!$shelter)
        {
            return redirect()->back()->with('error', 'Shelter does not exist');
        }

        $shelter->delete();
        
        return redirect()->back()->with('success', 'Shelter has been removed!.');
    }

    public function view()
    {
        $hazards = Hazard::all();
        $shelters = Shelter::all();

        return view('pages.hazardMap.viewSheltersHazards', compact('hazards', 'shelters'));
    }
}
