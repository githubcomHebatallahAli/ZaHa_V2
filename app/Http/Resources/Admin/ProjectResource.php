<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'client_id' => $this->client_id,
            'client' => new ClientResource($this->whenLoaded('client')),
            'cost' => $this->cost,
            'projectType' => $this->projectType,
            'status' => $this->status,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'hostName' => $this->hostName,
            'hostCost' => $this->hostCost,
            'buyHostDate' => $this->buyHostDate,
            'renewalHostDate' => $this->renewalHostDate,
            'domainName' => $this->domainName,
            'domainCost' => $this->domainCost,
            'buyDomainDate' => $this->buyDomainDate,
            'renewalDomainDate' => $this->renewalDomainDate,
            'reason' => $this->reason,
            'amount' => $this->amount,
            'creationDate' => $this->creationDate,
        'developers' => $this->whenLoaded('developers', function () {
            return $this->developers->map(function ($developer) {
                return [
                    'id' => $developer->id,
                    'name' => $developer->name,
                    'profit' => $developer->pivot->profit,
                ];
            });
        }),
        ];
    }

}
