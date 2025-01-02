<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleHistory extends Model
{
    protected $table = 'patient_care_sample_history'; 
    public $timestamps = false;

    protected $fillable = [
        'patientCareID', 'S', 'A', 'M', 'P', 'L', 'E'
    ];
}
