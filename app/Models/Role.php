<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'user_roles');
    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'role_permissions');
    // }

}
