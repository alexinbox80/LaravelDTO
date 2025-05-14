<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\BlogPostDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogPostRequest;
use App\Http\Resources\Api\BlogPostResource;
use App\Models\BlogPost;
use App\Services\Blog\BlogPostService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;

class BlogPostController extends Controller
{

    public function __construct(
      protected BlogPostService $blogPostService,
      protected ResponseService $responseService,
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $blogPosts = $this->blogPostService->index();

        return $this->responseService->success([
            BlogPostResource::collection($blogPosts['data'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $request): JsonResponse
    {
        $post = $this->blogPostService->store(
            BlogPostDto::fromRequest($request),
        );

        return $this->responseService->success([
            BlogPostResource::make($post)
        ]);
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
    public function update(BlogPost $blogPost, BlogPostRequest $request): JsonResponse
    {
        $post = $this->blogPostService->update(
            $blogPost,
            BlogPostDto::fromRequest($request),
        );

        return $this->responseService->success([
            BlogPostResource::make($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
