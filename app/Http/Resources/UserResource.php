<?php

namespace App\Http\Resources;

use App\Models\Favourite;
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
            'id' => $this->id,
            'imageName' => $this->image_name,
            "profileImage" => $this->profile_image,
            'name' => $this->name,
            'email' => $this->email,
            "gender" => $this->gender,
            "role" => $this->role,
            'hadiths' => $this->hadiths->pluck('id'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
