<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->renderable(function (QueryException $e): JsonResponse {
            if (app()->isProduction()) {
                return api()->error('Something went wrong', 500);
            }

            return api()->error('Database query error', 500, [
                'error' => $e->getMessage(),
            ]);
        });

        $exceptions->renderable(
            fn(ValidationException $e): JsonResponse => api()->error(
                'Validation failed',
                422,
                $e->errors()
            )
        );

        $exceptions->renderable(function (ModelNotFoundException $e): JsonResponse {
            $model = class_basename($e->getModel());
            return api()->error("$model not found", 404);
        });

        $exceptions->renderable(
            fn(AuthenticationException $e): JsonResponse => api()->error('Unauthenticated', 401)
        );

        $exceptions->renderable(
            fn(AuthorizationException $e): JsonResponse => api()->error('Unauthorized', 403)
        );

        $exceptions->renderable(function (Throwable $e): JsonResponse {
            if (app()->isProduction()) {
                return api()::error('Something went wrong', 500);
            }

            return api()::error(
                class_basename($e::class) . ' occurred',
                500,
                ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
        });
    })->create();
