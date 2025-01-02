<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalIR extends Model
{
    use HasFactory;

  
    protected $table = 'medical_ir';

    
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
