<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hazard extends Model
{
    protected $primaryKey = 'hazardID';
    protected $fillable = [
        'hazardName',
        'hazardStatus',
        'coordinates',
    ];
    public function hazard_status()
    {
        return $this->hasOne(HazardStatus::class, 'id', 'hazardStatus');
    }
}
