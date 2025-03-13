<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements JWTSubject
{
    use  HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'email_verified_at',
        // 'social_id',
        // 'social_type',
    ];



    // protected $guarded= ['isAdmin'];

    // const ISADMIN =[
    //     0 => 'User',
    //     1 => 'Admin'
    // ];


    // public function admin()
    // {
    //     return $this->hasOne(Admin::class);
    // }

    // public function team()
    // {
    //     return $this->hasOne(Team::class);
    // }
    // public function job()
    // {
    //     return $this->hasOne(Job::class);
    // }


    function orders(){

        return $this->hasMany(Order::class);
    }


    // function comments(){

    //     return $this->hasMany(Comment::class);
    // }


    public function contactUs()
    {
        return $this->hasMany(Contact::class);
    }

    // public function projects()
    // {
    //     return $this->belongsToMany(User::class,'user_projects')
    //     ->withPivot('price','numberOfSales');

    // }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class,'user_roles');
    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class,'user_permissions');
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $cast = [
        'password'=>'hashed'
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
