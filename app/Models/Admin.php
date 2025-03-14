<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin  extends Authenticatable  implements JWTSubject
{
    use HasFactory , Notifiable, SoftDeletes ;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role_id',

    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $cast = [
        'password'=>'hashed'
    ];

    protected $attributes = [
        'status' => 'active', // تعيين القيمة الافتراضية في الموديل
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
