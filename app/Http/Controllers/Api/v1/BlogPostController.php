<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\BlogPostDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogPostRequest;
use App\Http\Resources\Api\BlogPostResource;
use App\Models\BlogPost;
use App\Services\Blog\BlogPostService;
use App\Services\Contracts\ResponseContract;
use Illuminate\Http\JsonResponse;

class BlogPostController extends Controller
{

    public function __construct(
      private readonly BlogPostService $blogPostService,
      private readonly ResponseContract $responseService,
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
            BlogPostDto::fromRequest($request)
        );

        return $this->responseService->created([
            BlogPostResource::make($post)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost): JsonResponse
    {
        $post = $this->blogPostService->show($blogPost);

        return $this->responseService->success([
            BlogPostResource::make($post)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPost $blogPost, BlogPostRequest $request): JsonResponse
    {
        $post = $this->blogPostService->update(
            $blogPost,
            BlogPostDto::fromRequest($request)
        );

        return $this->responseService->success([
            BlogPostResource::make($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost): JsonResponse
    {
        $post = $this->blogPostService->destroy(
            $blogPost
        );

        if ($post) {
            return $this->responseService->success([
                'message' => __('messages.blog.destroy.success')
            ]);
        } else {
            return $this->responseService->unSuccess([
                'message' => __('messages.blog.destroy.failed')
            ]);
        }
    }
}
