<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCareReport extends Model
{
    use HasFactory;

    protected $table = 'patient_care_reports'; 

    protected $primaryKey = 'patientCareID';


    protected $fillable = [
        'patientName',
        'patientAddress',
        'patientAge',
        'patientGender',
        'case',
        'others',
        'recordedBy',
        'recievedBy',
        'time',
        'incidentPlace',
        'incidentDate',
        'contactNumber',
        'patientContactPerson'
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'patientGender');
    }

    public function patientCareCase()
    {
        return $this->belongsTo(PatientCareCase::class, 'case');
    }

    public function consciousness_lvl()
    {
        return $this->hasOne(ConsciousnessLevel::class, 'patientCareID');
    }

    public function sample_history()
    {
        return $this->hasOne(SampleHistory::class, 'patientCareID');
    }

    public function pain_assessment()
    {
        return $this->hasOne(PainAssessment::class, 'patientCareID');
    }

    public function injury_dtl()
    {
        return $this->hasOne(InjuryDtl::class, 'patientCareID');
    }

    public function dcapbtls()
    {
        return $this->hasOne(DCAPBLTS::class, 'patientCareID');
    }

    public function spotStroke()
    {
        return $this->hasOne(SpotStroke::class, 'patientCareID', 'patientCareID');
    }
    public function vitals()
    {
        return $this->hasOne(Vitals::class, 'patientCareID');
    }

    public function recorded_by()
    {
        return $this->belongsTo(User::class, 'recordedBy', 'id');
    }

}
