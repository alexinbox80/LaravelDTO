<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\BlogPostController;

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
