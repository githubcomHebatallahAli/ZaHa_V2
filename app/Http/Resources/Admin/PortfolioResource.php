<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this -> id,
            'name' => $this -> name,
            'slug' => $this -> slug,
            'description' => $this -> description,
            'programLang' => $this -> programLang,
            'mainImage' => $this -> mainImage,
            'images' => $this -> images,
            'videoUrl' => $this -> videoUrl,
            'url' => $this -> url,
            'projectType' => $this -> projectType,
            'startDate' => $this -> startDate,
            'endDate' => $this -> endDate,
            'status' => $this -> status,
        ];
    }
}
