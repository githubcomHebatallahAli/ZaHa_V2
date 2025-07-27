<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'funder' => $this->funder,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'creationDate' => $this->creationDate,
        ] ;
    }
}
