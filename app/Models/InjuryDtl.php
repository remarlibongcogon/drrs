<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InjuryDtl extends Model
{
    protected $table = 'patient_care_injury_dtl'; 
    public $timestamps = false;

    protected $fillable = [
        'patientCareID', 'vehicular', 'fall', 'cut', 'broken', 'gunshot', 'drowning', 'electrocuted', 'suicide', 'burns'
    ];

    public function patientCareReport()
    {
        return $this->belongsTo(PatientCareReport::class, 'patientCareID');
    }

    public function vehicular_type()
    {
        return $this->belongsTo(VehicularAccidentTypes::class, 'vehicular');
    }
}
