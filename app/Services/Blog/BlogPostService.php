<?php

namespace App\Services\Blog;

use App\DTO\BlogPostDto;
use App\Models\BlogPost;

class BlogPostService
{
    public function store(BlogPostDto $blogPostDto): BlogPost
    {
        return BlogPost::create([
            'title' => $blogPostDto->title,
            'description' => $blogPostDto->description,
            'source' => $blogPostDto->blogPostSource,
            'isPublished' => $blogPostDto->isPublished,
        ]);
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
}
