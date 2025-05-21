<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BlogPostApiCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexRoute(): void
    {
        $response = $this->getJson(route('blog-posts.index'));

        $response->assertStatus(Response::HTTP_OK)->assertJsonFragment(['status' => true]);
    }

    public function testStoreDataRoute(): void
    {
        $data = [
            'title' => 'Test title',
            'description' => 'Test description',
            'is-published' => false
        ];

        $response = $this->postJson(route('blog-posts.store'), $data);

        $response->assertStatus(Response::HTTP_OK)->assertJsonFragment(['status' => true]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => Arr::get($data, 'title'),
            'description' => Arr::get($data, 'description'),
            'is-published' => 'is-published'
        ]);
    }

    public function testStoreEmptyDataRoute(): void
    {
        $data = [
            'title' => '',
            'description' => '',
            'is-published' => false
        ];

        $response = $this->postJson(route('blog-posts.store'), $data);

        $response->assertUnprocessable();
    }

    public function testShowDataRoute(): void
    {
        $response = $this->getJson('api/v1/blog-post/1');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testPutDataRoute(): void
    {
        $data = [
            'title' => 'Test title',
            'description' => 'Test description',
            'is-published' => false
        ];

        $this->postJson(route('blog-posts.store'), $data);

        $data = [
            'title' => 'Test title put',
            'description' => 'Test description put',
            'is-published' => false
        ];

        $response = $this->putJson('api/v1/blog-post/1', $data);
        $response->assertStatus(Response::HTTP_OK)->assertJsonFragment(['status' => true]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => Arr::get($data, 'title'),
            'description' => Arr::get($data, 'description'),
            'is-published' => 'is-published'
        ]);
    }

    public function testDeleteRoute(): void
    {
        $response = $this->deleteJson('api/v1/blog-post/1');
        $response->assertStatus(Response::HTTP_OK)->assertJsonFragment(['status' => false]);
    }
}
