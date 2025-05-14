<?php

namespace App\Services\Blog;

use App\DTO\BlogPostDto;
use App\Models\BlogPost;

class BlogPostService
{
    /**
     * @return array
     */
    public function index(): array
    {
        $blogPosts = BlogPost::query();

        return [
            'data' => $blogPosts->latest('created_at')->paginate(config('pagination.index.blogPosts'))
        ];
    }

    public function store(BlogPostDto $blogPostDto): BlogPost
    {
        return BlogPost::create([
            'title' => $blogPostDto->title,
            'description' => $blogPostDto->description,
            'source' => $blogPostDto->blogPostSource,
            'isPublished' => $blogPostDto->isPublished,
        ]);
    }

    public function show(BlogPost $blogPost): BlogPost
    {
        return $blogPost;
    }

    public function update(BlogPost $blogPost, BlogPostDto $blogPostDto): BlogPost
    {
        return tap($blogPost)->update([
            'title' => $blogPostDto->title,
            'description' => $blogPostDto->description,
            'source' => $blogPostDto->blogPostSource,
            'isPublished' => $blogPostDto->isPublished,
        ]);
    }

    public function destroy(BlogPost $blogPost): bool
    {
            return $blogPost->delete();
    }
}
