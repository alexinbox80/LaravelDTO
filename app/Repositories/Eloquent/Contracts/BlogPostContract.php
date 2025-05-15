<?php

namespace App\Repositories\Eloquent\Contracts;

use App\Models\BlogPostModel;
use Illuminate\Database\Eloquent\Collection;

interface BlogPostContract
{
    public function getPaginated(int $perPage): array;

    public function getAll(): array;

    public function find(int $blogPostId): ?BlogPostModel;

    public function create(array $attributes): BlogPostModel;

    public function patch(int $blogPostId, array $blogPostDetails): BlogPostModel;

    public function getIsPublished(): Collection;

    public function destroy(array|Collection $ids): int;
}
