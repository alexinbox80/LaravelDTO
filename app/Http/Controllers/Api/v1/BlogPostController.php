<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\BlogPostDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogPostRequest;
use App\Http\Resources\Api\BlogPostResource;
use App\Models\BlogPost;
use App\Services\Blog\BlogPostService;

class BlogPostController extends Controller
{

    public function __construct(
      protected BlogPostService $blogPostService
    ) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $request): BlogPostResource
    {
        $post = $this->blogPostService->store(
            BlogPostDto::fromRequest($request),
        );

        return BlogPostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPost $blogPost, BlogPostRequest $request): BlogPostResource
    {
        $post = $this->blogPostService->update(
            $blogPost,
            BlogPostDto::fromRequest($request),
        );

        return BlogPostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
