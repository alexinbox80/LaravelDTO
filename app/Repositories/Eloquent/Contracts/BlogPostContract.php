<?php

namespace App\Repositories\Eloquent\Contracts;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;

interface BlogPostContract
{
    public function getPaginated(int $perPage): array;

    public function getAll(): array;

    public function getById(int $blogPostId): BlogPost;

    public function create(array $attributes): BlogPost;

    public function patch(int $blogPostId, array $blogPostDetails): BlogPost;

    public function getIsPublished(): Collection;

    public function destroy(array|Collection $ids): int;
}
