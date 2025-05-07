<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'address' => $this->address,
            'profile_picture' => $this->profile_picture
                ? asset('storage/' . $this->profile_picture)
                : null,
            'gender' => $this->gender,
            'educations' => $this->educations,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
