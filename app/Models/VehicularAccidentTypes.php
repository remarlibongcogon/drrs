<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicularAccidentTypes extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description'
    ];
}
