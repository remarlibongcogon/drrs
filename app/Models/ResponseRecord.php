<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'responseID';

    protected $fillable = [
        'date',
        'time',
        'incidentFrom',
        'takenTo',
        'callerOrReporter',
        'patientName',
        'patientAge',
        'patientAddress',
        'patientCase',
        'patientGender',
        'responders',
        'actionTaken',
        'remarks'
    ];

    public $incrementing = true;

    protected $table = 'response_record';

    protected $keyType = 'int';

    public $timestamps = false;

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'patientGender', 'id');
    }
    public function case()
    {
        return $this->belongsTo(Cases::class, 'patientCase', 'id');
    }
}
