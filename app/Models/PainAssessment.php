<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PainAssessment extends Model
{
    protected $table = 'patient_care_pain_assessment'; 
    public $timestamps = false;

    protected $fillable = [
        'patientCareID', 'O', 'P', 'Q', 'R', 'S', 'T'
    ];

    public function patientCareReport()
    {
        return $this->belongsTo(PatientCareReport::class, 'patientCareID');
    }
}
