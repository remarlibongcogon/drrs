<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\CivilStatus;
use App\Models\FamilyAssistance;
use App\Models\ShelterDamageClassification;
use App\Models\HouseOwnership;
use App\Models\FamilyMember;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use LengthException;

class FamilyAssistanceController extends Controller
{
    public function create(){

        $genders = map_options(Gender::class, 'id', 'description');
        $civil_status = map_options(CivilStatus::class, 'id', 'description');
        $shelter_damage = map_options(ShelterDamageClassification::class, 'id', 'description');
        $house_ownership = map_options(HouseOwnership::class, 'id', 'description');

        return view('pages.assistance.add', compact('genders', 'civil_status', 'shelter_damage', 'house_ownership'));
    }

    public function store(Request $request){
        
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:50',
                'middle_name' => 'nullable|string|max:50',
                'last_name' => 'required|string|max:50',
                'suffix' => 'nullable|string|max:20',
                'birthdate' => 'required|date',
                'age' => 'required|integer',
                'birthplace' => 'required|string|max:225',
                'gender' => 'required', 
                'permanent_address' => 'required|string|max:225',
                'civil_status' => 'required',  
                'religion' => 'nullable|string|max:100',
                'occupation' => 'required|string|max:100',
                'primary_contact_no' => 'required|regex:/^0?[0-9]{11}$/',  
                'alternate_contact_no' => 'nullable|regex:/^0?[0-9]{11}$/', 
                'mother_maiden_name' => 'nullable|string|max:50',
                'monthly_family_net_income' => 'required|numeric|min:0',
                'id_card_presented' => 'nullable|string|max:50',
                'id_card_number' => 'nullable|string|max:50',
                'ethnicity' => 'nullable|string|max:50',
                'region' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'city_municipality' => 'required|string|max:100',
                'barangay' => 'required|string|max:100',
                'evacuation_center' => 'nullable|string|max:100',
                'total_older_person' => 'nullable|integer|min:0',
                'total_preg_women' => 'nullable|integer|min:0',
                'total_lactating_women' => 'nullable|integer|min:0',
                'total_PWD' => 'nullable|integer|min:0',
                'house_ownership' => 'required',
                'shelter_damage' => 'required',
            ]);
    
            if ($validator->fails()) {
                return back()->with('error', implode('<br>', $validator->errors()->all()));
            }
    
            $fam_assistance = FamilyAssistance::create([
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name,
                        'suffix' => $request->suffix,
                        'birthdate' => $request->birthdate,
                        'age' => $request->age,
                        'birthplace' => $request->birthplace,
                        'gender' => $request->gender, 
                        'permanent_address' => $request->permanent_address,
                        'civil_status' => $request->civil_status,  
                        'religion' => $request->religion,
                        'occupation' => $request->occupation,
                        'primary_contact_no' => $request->primary_contact_no,  
                        'alternate_contact_no' => $request->alternate_contact_no, 
                        'mother_maiden_name' => $request->mother_maiden_name,
                        'monthly_family_net_income' => $request->monthly_family_net_income,
                        'id_card_presented' => $request->id_card_presented,
                        'id_card_number' => $request->id_card_number,
                        'ethnicity' => $request->ethnicity,
                        'region' => $request->region,
                        'province' => $request->province,
                        'district' => $request->district,
                        'city_municipality' => $request->city_municipality,
                        'barangay' => $request->barangay,
                        'evacuation_center' => $request->evacuation_center,
                        'total_older_person' => $request->total_older_person ?? 0,
                        'total_preg_women' => $request->total_preg_women ?? 0,
                        'total_lactating_women' => $request->total_lactating_women ?? 0,
                        'total_PWD' => $request->total_PWD ?? 0,
                        'house_ownership' => $request->house_ownership,
                        'shelter_damage' => $request->shelter_damage,
                        'is4PsBenef' => !is_null($request->is4PsBenef) ? 1 : 0,
                        'isIP' => !is_null($request->isIP) ? 1 : 0,
                    ]);
    
            if($request->family_member){
                $family_member_arrs = $request->family_member;
    
                foreach ($family_member_arrs as $member) {
                
                    $familyMemberData = [
                        'family_head_id' => $fam_assistance->id,
                        'fullname' => $member[0],
                        'relation' => $member[1], 
                        'birthdate' => $member[2], 
                        'age' => $member[3], 
                        'gender' => $member[4], 
                        'educational_attainment' => $member[5], 
                        'occupation' => $member[6], 
                        'remarks' => $member[7], 
                    ];
            
                    FamilyMember::create($familyMemberData);
                }
            }
    
            return redirect()->route('request.family.assistance')->with('success', 'Successfully sent assistance request!');
        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }

    public function index(){
        
        $datas = FamilyAssistance::select('id', 'first_name', 'middle_name', 'last_name', 'suffix','primary_contact_no', 'city_municipality', 'created_at')->get()->toArray();
  
        return view('pages.assistance.index', compact('datas'));
    }

    public function view($id){

        $data = FamilyAssistance::get_data($id)[0];
        $family_member = FamilyMember::get_data($id);
        
        return view('pages.assistance.view', compact('data', 'family_member'));
    }

    public function print_record(Request $request){
        
        $data = $request->all();
        $pdf = app('dompdf.wrapper')->loadView('pages.assistance.report', compact('data'))
                ->setPaper('legal', 'portrait');
   
        // download the generated PDF
        return $pdf->download('assistance.pdf');
    }

    public function view_update($id){

        $data = FamilyAssistance::get_data($id)[0];
        $family_member = FamilyMember::get_data($id);

        $genders = map_options(Gender::class, 'id', 'description');
        $civil_status = map_options(CivilStatus::class, 'id', 'description');
        $shelter_damage = map_options(ShelterDamageClassification::class, 'id', 'description');
        $house_ownership = map_options(HouseOwnership::class, 'id', 'description');

        // dd($data);
        return view('pages.assistance.edit', compact('data', 'family_member', 'genders', 'civil_status', 'shelter_damage', 'house_ownership'));
    }

    public function update(Request $request, $id)
    {

        $fam_assistance = FamilyAssistance::find($id);

        $fam_assistance->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'birthplace' => $request->birthplace,
            'gender' => $request->gender, 
            'permanent_address' => $request->permanent_address,
            'civil_status' => $request->civil_status,  
            'religion' => $request->religion,
            'occupation' => $request->occupation,
            'primary_contact_no' => $request->primary_contact_no,  
            'alternate_contact_no' => $request->alternate_contact_no, 
            'mother_maiden_name' => $request->mother_maiden_name,
            'monthly_family_net_income' => $request->monthly_family_net_income,
            'id_card_presented' => $request->id_card_presented,
            'id_card_number' => $request->id_card_number,
            'ethnicity' => $request->ethnicity,
            'region' => $request->region,
            'province' => $request->province,
            'district' => $request->district,
            'city_municipality' => $request->city_municipality,
            'barangay' => $request->barangay,
            'evacuation_center' => $request->evacuation_center,
            'total_older_person' => $request->total_older_person ?? 0,
            'total_preg_women' => $request->total_preg_women ?? 0,
            'total_lactating_women' => $request->total_lactating_women ?? 0,
            'total_PWD' => $request->total_PWD ?? 0,
            'house_ownership' => $request->house_ownership,
            'shelter_damage' => $request->shelter_damage,
            'is4PsBenef' => !is_null($request->is4PsBenef) ? 1 : 0,
            'isIP' => !is_null($request->isIP) ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Family Assistance Form updated successfully!');
    }
}
