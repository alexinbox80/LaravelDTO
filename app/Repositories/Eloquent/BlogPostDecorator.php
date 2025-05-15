<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogPost;
use App\Repositories\Eloquent\Contracts\BlogPostContract;
use Illuminate\Database\Eloquent\Collection;

class BlogPostDecorator implements BlogPostContract
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository
    )
    {
    }

    public function getPaginated(int $perPage): array
    {
        return $this->blogPostRepository->getPaginated($perPage);
    }

    public function getAll(): array
    {
        return $this->blogPostRepository->getAll();
    }

    public function getById(int $blogPostId): BlogPost
    {
        return $this->blogPostRepository->getById($blogPostId);
    }

    public function create(array $attributes): BlogPost
    {
        return $this->blogPostRepository->create($attributes);
    }

    public function patch(int $blogPostId, array $blogPostDetails): BlogPost
    {
        return $this->blogPostRepository->patch($blogPostId, $blogPostDetails);
    }

    public function getIsPublished(): Collection
    {
        return $this->blogPostRepository->getIsPublished();
    }

    public function destroy(array|Collection $ids): int
    {
        return $this->blogPostRepository->destroy($ids);
    }
}
