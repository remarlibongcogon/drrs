<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterIR extends Model
{
    protected $table = 'disaster_ir';

    
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'reportID',
        'photoPathFile',
        'description',
        'disasterTypeID',
        // 'coordinates'
    ];

    public function incidentReports()
    {
        return $this->hasMany(IncidentReport::class, 'reportID', 'reportID');
    }

    public function disasterType()
    {
        return $this->belongsTo(DisasterType::class, 'disasterTypeID', 'id');
    }


}
