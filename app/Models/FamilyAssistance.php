<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyAssistance extends Model
{
    public $timestamps = true;  
    
    protected $table = 'family_assistance';

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix', 'birthdate', 'age', 'birthplace', 
        'gender', 'permanent_address', 'civil_status', 'religion', 'occupation', 'primary_contact_no', 
        'alternate_contact_no', 'mother_maiden_name', 'monthly_family_net_income', 'id_card_presented', 
        'id_card_number', 'is4PsBenef', 'isIP', 'ethnicity', 'region', 'province', 'district', 
        'city_municipality', 'barangay', 'evacuation_center', 'total_older_person', 'total_preg_women', 
        'total_lactating_women', 'total_PWD', 'house_ownership', 'shelter_damage'
    ];

    public static function get_data($id = null){

        $query =  self::leftJoin('gender', 'family_assistance.gender', '=', 'gender.id')
                        ->leftJoin('civil_status', 'family_assistance.civil_status', '=', 'civil_status.id')
                        ->leftJoin('house_ownership_type', 'family_assistance.house_ownership', '=', 'house_ownership_type.id')
                        ->leftJoin('shelter_damage_classification', 'family_assistance.shelter_damage', '=', 'shelter_damage_classification.id')
                        ->select('family_assistance.*', 'gender.description as genderDesc', 'civil_status.description as civilStatus',
                                'house_ownership_type.description as houseOwnershipDesc', 'shelter_damage_classification.description as shelterDamageDesc');


        if (!is_null($id)) {
            $query->where('family_assistance.id', $id);
        }
    
        return $query->get()->toArray();
     }
}
