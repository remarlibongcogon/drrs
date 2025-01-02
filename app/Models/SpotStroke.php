<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotStroke extends Model
{
    protected $table = 'patient_care_spot_stroke'; 
    public $timestamps = false;

    protected $fillable = [
        'patientCareID', 'B', 'F', 'A', 'S', 'T'
    ];

    public function patientCareReport()
    {
        return $this->belongsTo(PatientCareReport::class, 'patientCareID');
    }
}
