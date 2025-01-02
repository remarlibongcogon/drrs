<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterIRPatients extends Model
{
    protected $table = 'disaster_ir_patients';

    
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
