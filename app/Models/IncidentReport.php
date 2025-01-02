<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $table = 'incident_reports';

    protected $primaryKey = 'reportID';

    public $timestamps = false;

    protected $fillable = [
        'typeOfIncident',
        'incidentPlace',
        'landmark',
        'numberOfCasualties',
        'reporterFullName',
        'reporterContactNumber',
        'referenceCode',
        'date',
        'time',
        'isConfirmed',
        'coordinates'
    ];

    public function incidentCase()
    {
        return $this->belongsTo(IncidentCase::class, 'typeOfIncident', 'id');
    }

    public function obstetrics()
    {
        return $this->belongsTo(ObstetricsIR::class, 'reportID', 'reportID');
    }

    public function medical()
    {
        return $this->hasMany(MedicalIR::class, 'reportID', 'reportID');
    }

    public function injury_trauma()
    {
        return $this->hasMany(InjuryTraumaIR::class, 'reportID', 'reportID');
    }

    public function cardia()
    {
        return $this->hasMany(CardiaIR::class, 'reportID', 'reportID');
    }

    public function disaster()
    {
        return $this->belongsTo(DisasterIr::class, 'reportID', 'reportID');
    }

    public function disaster_patients()
    {
        return $this->hasMany(DisasterIRPatients::class, 'reportID', 'reportID');
    }


    

    public function deleteObstetrics()
    {
        return $this->hasOne(ObstetricsIR::class, 'reportID', 'reportID');
    }

    public function deleteMedical()
    {
        return $this->hasOne(MedicalIR::class, 'reportID', 'reportID');
    }

    public function deleteInjury_trauma()
    {
        return $this->hasOne(InjuryTraumaIR::class, 'reportID', 'reportID');
    }

    public function deleteCardia()
    {
        return $this->hasOne(CardiaIR::class, 'reportID', 'reportID');
    }

    public function deleteDisaster()
    {
        return $this->hasOne(DisasterIr::class, 'reportID', 'reportID');
    }


}
