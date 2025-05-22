<?php

namespace Tests\Feature\Presentation\Http\Controller\Api\v1;

use App\Domain\Models\BlogPostModel;
use App\Domain\Services\Blog\BlogPostService;
use App\Domain\ValueObject\Enums\BlogPostSource;
use App\Presentation\Http\Controllers\Api\v1\BlogPostController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
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

    public function testIndex(): void
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

        $response = app(BlogPostController::class)->index($request);
        $data = $response->getData()->data;

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($result[0]->id, $data[0]->id);
        $this->assertEquals($result[0]->title, $data[0]->title);
        $this->assertEquals($result[0]->description, $data[0]->description);
        $this->assertEquals($result[0]->created_at, $data[0]->created_at);
        $this->assertEquals($result[0]->updated_at, $data[0]->updated_at);
    }
}
