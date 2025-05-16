<?php

namespace App\Presentation\Http\Controllers\Api\v1;

use App\Domain\Services\Blog\BlogPostService;
use App\Domain\Services\Contracts\ResponseContract;
use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\DTO\BlogPostDto;
use App\Presentation\Http\Requests\Api\BlogPostRequest;
use App\Presentation\Http\Resources\Api\BlogPostModelResource;
use App\Presentation\Http\Resources\Api\BlogPostResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{

    public function __construct(
        private readonly BlogPostService  $blogPostService,
        private readonly ResponseContract $responseService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $blogPosts = $this->blogPostService->index($request);

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
            BlogPostModelResource::make($post)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $blogPostId): JsonResponse
    {
        $post = $this->blogPostService->show($blogPostId);

        if ($post !== null)
            return $this->responseService->success([
                BlogPostModelResource::make($post)
            ]);
        else
            return $this->responseService->notFound();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $blogPostId, BlogPostRequest $request): JsonResponse
    {
        $post = $this->blogPostService->update(
            $blogPostId,
            BlogPostDto::fromRequest($request)
        );

        return $this->responseService->success([
            BlogPostModelResource::make($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $blogPostId): JsonResponse
    {
        $destroyId = $this->blogPostService->destroy(
            $blogPostId
        );

        if ($destroyId) {
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
