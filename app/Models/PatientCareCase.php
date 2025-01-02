<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCareCase extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description'
    ];
}
