<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShelterDamageClassification extends Model
{
    protected $table = 'shelter_damage_classification';
    protected $fillable = ['description']; 
}
