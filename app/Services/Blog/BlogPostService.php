<?php

namespace App\Services\Blog;

use App\DTO\BlogPostDto;
use App\Models\BlogPostModel;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\Contracts\BlogPostContract;

class BlogPostService
{
    public function __construct(
        private readonly BlogPostContract $blogPostRepository
    )
    {
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
            $blogPosts = $this->blogPostRepository->getPaginated(config('pagination.index.blogPosts'));

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
