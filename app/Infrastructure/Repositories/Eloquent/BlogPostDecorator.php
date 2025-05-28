<?php

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\Models\BlogPostModel;
use App\Domain\Repository\Eloquent\Contracts\BlogPostContract;
use App\Domain\ValueObject\Enums\BlogPostSource;
use App\Infrastructure\Repositories\Redis\Contracts\RedisRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BlogPostDecorator implements BlogPostContract
{
    public const CACHE_TAG = 'blogPosts';

    public function __construct(
        private readonly BlogPostRepository $blogPostRepository,
        private readonly RedisRepositoryContract $redis
    )
    {
    }

//    /**
//     * @param int $perPage
//     * @return LengthAwarePaginator
//     */
//    public function getPaginated(int $perPage): LengthAwarePaginator
//    {
//        return $this->blogPostRepository->getPaginated($perPage);
//    }

    /**
     * @param int $page
     * @return BlogPostModel[]
     */
    public function getPaginated(int $page): array
    {
        $perPage = config('pagination.index.blogPosts');

        return Cache::get(
            $this->redis->getCacheKey( self::CACHE_TAG, $page, $perPage),
            function () use ($page, $perPage) {
                $blogPosts = $this->blogPostRepository->getOwnPaginated($page, $perPage);
                $blogPostModels = array_map(
                    static fn (array $blogPost): BlogPostModel => new BlogPostModel(
                        $blogPost['id'],
                        $blogPost['title'],
                        $blogPost['description'],
                        $blogPost['source'] === 'api' ? BlogPostSource::Api : BlogPostSource::App,
                        $blogPost['isPublished'],
                        $blogPost['created_at'],
                        $blogPost['updated_at']
                    ),
                    $blogPosts
                );
                Cache::tags([self::CACHE_TAG])->put($this->redis->getCacheKey(self::CACHE_TAG, $page, $perPage), $blogPostModels);

                return $blogPostModels;
            }
        );
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

        Cache::tags([self::CACHE_TAG])->flush();

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

        Cache::tags([self::CACHE_TAG])->flush();

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
        $item = $this->blogPostRepository->destroy($ids);

        if ($item)
            Cache::tags([self::CACHE_TAG])->flush();

        return $item;
    }
}
