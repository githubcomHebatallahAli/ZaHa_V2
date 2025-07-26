<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDeveloper extends Model
{
    protected $fillable = [
        'project_id',
        'developer_id',
        'profit',
    ];



}
