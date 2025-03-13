<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;
    const storageFolder= 'Portfolio';

    protected $fillable = [
        'name',
        'description',
        'programLang',
        'mainImage',
        'images',
        'videoUrl',
        'url',
        'startDate',
        'endDate',
        'status',
        'projectType'

    ];

    protected $casts = [
        'images' => 'array',
        'programLang' => 'array',
    ];
}
