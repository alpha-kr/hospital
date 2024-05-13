<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'observation' => $this->observation,
            'date' => $this->date->format('Y-m-d H:i'),
            'diagnose' => new DiagnoseResource($this->whenLoaded('diagnose')),
        ];
    }
}
