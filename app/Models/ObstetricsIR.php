<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObstetricsIR extends Model
{
    use HasFactory;

    protected $table = 'obstetrics_ir';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'reportID',
        'fullName',
        'age',
        'monthsPregnant',
        'numberOfBirths',
        'prenatalCareLocation',
    ];

    public function incidentReports()
    {
        return $this->hasMany(IncidentReport::class, 'reportID', 'reportID');
    }
}
