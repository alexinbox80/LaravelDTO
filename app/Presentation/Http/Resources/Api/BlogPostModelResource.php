<?php

namespace App\Presentation\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => !is_null($this->getDescription()) ? $this->getDescription() : null,
            'source' => $this->getSource(),
            'is_published' => $this->isPublished(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}
