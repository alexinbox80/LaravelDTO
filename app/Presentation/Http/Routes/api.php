<?php

use App\Presentation\Http\Controllers\Api\v1\BlogPostController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function () {
    return 'Hello World';
});

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('blog-post', BlogPostController::class)->names([
        'index' => 'blog-posts.index',
        'store' => 'blog-posts.store',
        'show' => 'blog-posts.show',
        'update' => 'blog-posts.update',
        'destroy' => 'blog-posts.destroy',
    ]);
});
