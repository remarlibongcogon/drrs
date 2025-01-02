<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardStatus extends Model
{
    protected $fillable = [
        'description'
    ];
    public $timestamps = false;

    public function hazard()
    {
        return $this->hasMany(Hazard::class,'hazardStatus');
    }
}
