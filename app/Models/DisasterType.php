<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterType extends Model
{
    protected $table = 'disaster_type';
    protected $fillable = ['description']; 

    public function disaster()
    {
        return $this->hasMany(DisasterIR::class, 'disasterTypeID', 'id');
    }
}


    