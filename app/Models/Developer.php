<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'photo',
        'zahaOpinion',
        'notes',
        'creationDate',
        'job',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_developers')->withPivot('profit');
    }
}
