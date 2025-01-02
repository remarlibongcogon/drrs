<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentCase extends Model
{
    use HasFactory;

    protected $table = 'incident_case'; 

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'description'

    ];

    public function incidentReports()
    {
        return $this->hasMany(IncidentReport::class, 'typeOfIncident', 'id');
    }
}
