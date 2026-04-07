<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "staff_code" => $this->staff_code,
            "name" => $this->name,
            "department" => $this->department,
            "phone" => $this->phone,
            "email" => $this->email,
            "user_id" => $this->user_id,
            "role" => $this->user->role,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
