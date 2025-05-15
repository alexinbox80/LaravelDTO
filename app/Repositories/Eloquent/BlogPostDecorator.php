<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogPostModel;
use App\Repositories\Eloquent\Contracts\BlogPostContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogPostDecorator implements BlogPostContract
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository
    )
    {
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->blogPostRepository->getPaginated($perPage);
    }

    /**
     * @return BlogPostModel[]
     */
    public function getAll(): array
    {
        $blogPosts = $this->blogPostRepository->getAll();

        $result = [];
        foreach ($blogPosts as $blogPost) {
            $result[] = new BlogPostModel(
                $blogPost->id,
                $blogPost->title,
                $blogPost->description,
                $blogPost->source,
                $blogPost->isPublished,
                $blogPost->created_at,
                $blogPost->updated_at
            );
        }

        return $result;
    }

    public function find(int $blogPostId): ?BlogPostModel
    {
        $blogPost = $this->blogPostRepository->find($blogPostId);

        if ($blogPost !== null)
            return new BlogPostModel(
                $blogPost->id,
                $blogPost->title,
                $blogPost->description,
                $blogPost->source,
                $blogPost->isPublished,
                $blogPost->created_at,
                $blogPost->updated_at
            );
        else
            return null;
    }

    public function create(array $attributes): BlogPostModel
    {
        $blogPost =  $this->blogPostRepository->create($attributes);

        return new BlogPostModel(
            $blogPost->id,
            $blogPost->title,
            $blogPost->description,
            $blogPost->source,
            $blogPost->isPublished,
            $blogPost->created_at,
            $blogPost->updated_at
        );
    }

    public function patch(int $blogPostId, array $blogPostDetails): BlogPostModel
    {
        $blogPost = $this->blogPostRepository->patch($blogPostId, $blogPostDetails);

        return new BlogPostModel(
            $blogPost->id,
            $blogPost->title,
            $blogPost->description,
            $blogPost->source,
            $blogPost->isPublished,
            $blogPost->created_at,
            $blogPost->updated_at
        );
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
