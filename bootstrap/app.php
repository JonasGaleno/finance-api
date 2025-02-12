<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            $response = [
                'error' => 'Internal server error',
                'message' => $e->getMessage()
            ];
            $statusCode = 500;

            if ($e instanceof AuthenticationException) {
                $response = ['error' => 'Unauthenticated'];
                $statusCode = 401;
            }

            if ($e instanceof NotFoundHttpException) {
                $response = ['error' => 'Route not found'];
                $statusCode = 404;
            }

            return response()->json($response, $statusCode);
        });
    })->create();
