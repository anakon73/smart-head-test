<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'poster_url' => asset('storage/' . $this->poster_path),
            'is_published' => $this->is_published,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'genres' => $this->genres->pluck('name'),
        ];
    }
}
