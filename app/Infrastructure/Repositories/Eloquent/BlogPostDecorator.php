<?php

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\Models\BlogPostModel;
use App\Domain\Repository\Eloquent\Contracts\BlogPostContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

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
        Cache::set('bar', 'baz', 600);

        Cache::store('redis')->put('bar1', 'baz1', 600); // 10 Minutes

        Cache::tags(['products'])->put('product_' . 1, 123, 600);

        if (Cache::has('bar12')) {
           $cache = Cache::get('bar1');
            dump($cache);
        }

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
