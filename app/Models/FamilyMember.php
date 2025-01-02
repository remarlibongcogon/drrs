<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $table = 'family_member';

    public $timestamps = false;  

    protected $fillable = [
        'family_head_id',
        'fullname',
        'relation',
        'birthdate',
        'age',
        'gender',
        'educational_attainment',
        'occupation',
        'remarks'
    ]; 

    public static function get_data($id = null){

        $query =  self::leftJoin('gender', 'family_member.gender', '=', 'gender.id')
                        ->select('family_member.*', 'gender.description as genderDesc');


        if (!is_null($id)) {
            $query->where('family_member.family_head_id', $id);
        }
    
        return $query->get()->toArray();
     }
}
