<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../app/Presentation/Http/Routes/web.php',
        api: __DIR__ . '/../app/Presentation/Http/Routes/api.php',
        commands: __DIR__ . '/../app/Presentation/Console/Routes/console.php',
        health: '/healthcheck',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'error' => 'Entity not found.',
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }
        });
    })->create();
