<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'iti'       => $this->iti,
            'name'      => $this->name,
            'email'     => $this->email,
            'status'    => $this->status,
            'profile_photo_path' => $this->profile_photo_path,
            'verification_token' => $this->verification_token,
            'registration_type' => $this->registration_type,
        ];
    }
}
