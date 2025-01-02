<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $table = 'case';
    protected $fillable = ['description']; 

    public function responseRecords()
    {
        return $this->hasMany(ResponseRecord::class, 'patientCase', 'id');
    }
}

