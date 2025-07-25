<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    const storageFolder= 'Client';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'photo',
        'clientOpinion',
        'zahaOpinion',
        'notes',
        'creationDate'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
