<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'phone' => $this->phone,
            'address' => $this->address,
            'photo' => $this->photo,
            'clientOpinion' => $this->clientOpinion,
            'zahaOpinion' => $this->zahaOpinion,
            'notes' => $this->notes,
            'creationDate' => $this->creationDate
        ];
    }
}
