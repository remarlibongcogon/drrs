<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'gender';
    protected $fillable = ['description']; 

    public function responseRecords()
    {
        return $this->hasMany(ResponseRecord::class, 'patientGender', 'id');
    }
}
