<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use HasFactory, SoftDeletes;
    const storageFolder = 'Developer';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'photo',
        'zahaOpinion',
        'notes',
        'creationDate',
        'job',
        'status',
        'salary'

    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_developers')->withPivot('profit');
    }

    protected $casts = [
        'salary' => 'decimal:2',
    ];
}
