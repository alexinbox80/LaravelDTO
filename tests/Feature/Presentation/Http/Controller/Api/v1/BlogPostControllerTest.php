<?php

namespace Tests\Feature\Presentation\Http\Controller\Api\v1;

use App\Domain\Models\BlogPostModel;
use App\Domain\Services\Blog\BlogPostService;
use App\Domain\ValueObject\Enums\BlogPostSource;
use App\Presentation\Http\Controllers\Api\v1\BlogPostController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Tests\TestCase;

class BlogPostControllerTest extends TestCase
{
    protected function createRequest(
        $method,
        $content,
        $uri = 'api/v1/blog-post',
        $server = ['CONTENT_TYPE' => 'application/json'],
        $parameters = [],
        $cookies = [],
        $files = []
    ): Request
    {
        $request = new Request();
        return $request->createFromBase(
            HttpFoundationRequest::create(
                $uri,
                $method,
                $parameters,
                $cookies,
                $files,
                $server,
                $content
            )
        );
    }

    public function test_index(): void
    {
        $result[] = new BlogPostModel(
            1,
            'title',
            'description',
            BlogPostSource::Api,
            true,
            now(),
            now()
        );

        $this->mock(BlogPostService::class, function (MockInterface $mock) use ($result) {
            $mock->shouldReceive('index')->once()->andReturn(['data' => $result]);
        });

        $request = $this->createRequest(
            'GET',
            ''
        );

        app(BlogPostController::class)->index($request);
    }
}
