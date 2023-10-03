<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public $timestamps = true;


    // to establish the relationship with the roles_permissin table 
    public function permissions()
    {
        return $this->belongsToMany(Permisson::class, 'roles_permission', 'roles_id', 'permission_id')->withTimestamps();;
    }

    public static function boot()
    {
        parent::boot();

        // Event listener for deleting a role
        static::deleting(function ($role) {
            // Delete associated permissions
            $role->permissions()->detach();
        });

    }

    public function user()
    {
        // return $this->belongsToMany('users_class')
        return $this->belongsToMany('users_roles','user','role');
    }
}