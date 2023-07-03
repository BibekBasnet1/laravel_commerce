<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // to establish the relationship with the roles permission table 
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'roles_permission', 'permission_id', 'roles_id')
        ->withTimestamps();
    }
   
}
 

