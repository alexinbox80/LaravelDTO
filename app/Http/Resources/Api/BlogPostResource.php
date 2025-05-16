<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
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
            'title' => $this->title,
            'description' => !is_null($this->description) ? $this->description : null,
            'source' => $this->source,
            'is_published' => $this->isPublished,
            'created_at' => (string) $this->created_at,//->diffForHumans(),
            'updated_at' => (string) $this->updated_at,//->diffForHumans(),
        ];
    }
}
