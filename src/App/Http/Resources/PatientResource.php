<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'document' => $this->document,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'birthDate' => $this->birth_date->format('Y-m-d'),
            'email' => $this->email,
            'phone' => $this->phone,
            'genre' => $this->genre,
            'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),
        ];
    }
}
