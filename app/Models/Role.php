<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['description']; 

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'role_id');
    }
}