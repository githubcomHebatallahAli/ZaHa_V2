<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
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
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function developers()
    {
        return $this->belongsToMany(Developer::class, 'project_developers')->withPivot('profit');
    }
}
