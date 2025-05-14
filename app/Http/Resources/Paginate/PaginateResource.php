<?php

namespace App\Http\Resources\Paginate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PaginateResource extends JsonResource
{
    public function __construct(array $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!$request->get('page')) {
            return [];
        }

        try {
            return [
                'current_page' => $this->resource[0]->currentPage(),
                'last_page' => $this->resource[0]->lastPage(),
                'next_page_url' => $this->resource[0]->nextPageUrl(),
                'path' => $this->resource[0]->path(),
                'per_page' => $this->resource[0]->perPage(),
                'prev_page_url' => $this->resource[0]->previousPageUrl(),
                'has_more_range' => $this->resource[0]->hasMorePages(),
                'total' => $this->resource[0]->total(),
                'count' => $this->resource[0]->count(),
            ];
        } catch (\Exception $e) {
            return [];
        }
    }
}
