<?php

namespace App\Domain\Services\Blog;

use App\Domain\Models\BlogPostModel;
use App\Domain\Repository\Eloquent\Contracts\BlogPostContract;
use App\Infrastructure\Repositories\Elasticsearch\BlogPostDecorator as BlogPostRepository;
use App\Presentation\Http\DTO\BlogPostDto;
use Illuminate\Http\Request;

class BlogPostService
{
    public function __construct(
        private readonly BlogPostContract $blogPostRepository,
        private readonly BlogPostRepository $blogPostElasticsearchRepository
    )
    {
    }

    /**
     * @param Request $request
     * @return array
     */
    public function search(Request $request): array
    {
        //$blogPosts = $this->blogPostRepository->search($request->query->get('query'));

        $blogPosts = $this
            ->blogPostElasticsearchRepository
            ->search($request->query->get('query'));

        return ['data' => $blogPosts];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        if (is_null($request->query('page')))
            $blogPosts = $this->blogPostRepository->getAll();
        else
            $blogPosts = $this->blogPostRepository->getPaginated($request->query('page') < 1 ? 1 : $request->query('page'));

        return ['data' => $blogPosts];
    }

    public function store(BlogPostDto $blogPostDto): BlogPostModel
    {
        $blogPost = $this->blogPostRepository->create([
            'title' => $blogPostDto->title,
            'description' => $blogPostDto->description,
            'source' => $blogPostDto->blogPostSource,
            'isPublished' => $blogPostDto->isPublished
        ]);

        return $blogPost;
    }

    public function show(string $blogPostId): ?BlogPostModel
    {
        return $this->blogPostRepository->find((int)$blogPostId);
    }

    public function update(string $blogPostId, BlogPostDto $blogPostDto): BlogPostModel
    {
        $blogPost = $this->blogPostRepository->patch(
            (int) $blogPostId,
            [
                'title' => $blogPostDto->title,
                'description' => $blogPostDto->description,
                'source' => $blogPostDto->blogPostSource,
                'isPublished' => $blogPostDto->isPublished
            ]);

        return $blogPost;
    }

    public function destroy(string $blogPostId): int
    {
        return $this->blogPostRepository->destroy([(int) $blogPostId]);
    }
}
