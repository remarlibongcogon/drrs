<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCAPBLTS extends Model
{
    protected $table = 'patient_care_dcap_blts'; 
    public $timestamps = false;

    protected $fillable = [
        'patientCareID', 'D', 'C', 'A', 'P', 'B', 'L', 'T', 'S'
    ];

    public function patientCareReport()
    {
        return $this->belongsTo(PatientCareReport::class, 'patientCareID');
    }
}
