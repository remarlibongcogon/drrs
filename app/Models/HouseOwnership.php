<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseOwnership extends Model
{
    protected $table = 'house_ownership_type';
    protected $fillable = ['description']; 
}
