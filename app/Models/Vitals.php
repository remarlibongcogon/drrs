<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    protected $table = 'patient_care_vitals'; 
    public $timestamps = false;

    protected $fillable = [
        'patientCareID', 'BP', 'TEMP', 'HR', 'SPo2', 'RR'
    ];

    public function patientCareReport()
    {
        return $this->belongsTo(PatientCareReport::class, 'patientCareID');
    }
}
