<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'client_id',
        'cost',
        'projectType',
        'startDate',
        'endDate',
        'hostName',
        'hostCost',
        'buyHostDate',
        'renewalHostDate',
        'domainName',
        'domainCost',
        'buyDomainDate',
        'renewalDomainDate',
        'reason',
        'amount',
        'creationDate',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function developers()
    {
        return $this->belongsToMany(Developer::class, 'project_developers')->withPivot('profit');
    }

     protected $casts = [
        'amount' => 'decimal:2',
        'cost' => 'decimal:2',
        'hostCost' => 'decimal:2',
        'domainCost' => 'decimal:2',
   
    ];


}
