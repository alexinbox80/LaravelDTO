<?php

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\Models\BlogPostModel;
use App\Domain\Repository\Eloquent\Contracts\BlogPostContract;
use App\Domain\Repository\Redis\RedisRepositoryContract;
use App\Domain\ValueObject\Enums\BlogPostSource;
use App\Domain\ValueObject\Enums\CacheTags;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BlogPostDecorator implements BlogPostContract
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository,
        private readonly RedisRepositoryContract $redis
    )
    {
    }

    /**
     * @param string $query
     * @return BlogPostModel[]
     */
    public function search(string $query = ''): array
    {
        $blogPosts = $this->blogPostRepository->search($query);

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
            $this->redis->getCacheKey(CacheTags::BlogPosts->value, $page, $perPage),
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
                Cache::tags([CacheTags::BlogPosts->value])->put($this->redis->getCacheKey(CacheTags::BlogPosts->value, $page, $perPage), $blogPostModels);

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
