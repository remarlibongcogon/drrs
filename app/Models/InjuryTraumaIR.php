<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InjuryTraumaIR extends Model
{
    protected $table = 'injury_trauma_ir';

    
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'reportID',
        'fullName',
        'shortnessOfBreath',
        'paleness',
        'heartRate',
    ];

    public function incidentReports()
    {
        return $this->hasMany(IncidentReport::class, 'reportID', 'reportID');
    }
}
