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
        'slug',
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


    private function generateSlug($name, $id)
{
    // استبدال المسافات بـ "-" وتحويل النص إلى lowercase
    $slug = strtolower(str_replace(' ', '-', $name));

    // إضافة الـ id إلى الـ slug
    $slug = $slug . '-' . $id;

    return $slug;
}
}
