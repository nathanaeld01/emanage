<?php

namespace App\Support;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class ExceptionsRenderer {
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Throwable $e): JsonResponse {
        // Map exception types to handler methods
        $exceptionHandler = match (true) {
            $e instanceof AuthenticationException => [$this, 'render401'],
            $e instanceof AuthorizationException => [$this, 'render403'],
            $e instanceof ValidationException => [$this, 'render422'],
            $e instanceof ModelNotFoundException => [$this, 'render404'],
            default => [$this, 'renderDefault'],
        };

        return $exceptionHandler($e);
    }

    /**
     * Handle unauthenticated requests.
     */
    public function render401(AuthenticationException $e): JsonResponse {
        return api()->error(
            message: 'You are not authenticated',
            status: 401
        );
    }

    /**
     * Handle unauthorized requests.
     */
    public function render403(AuthorizationException $e): JsonResponse {
        return api()->error(
            message: 'You do not have permission to perform this action',
            status: 403
        );
    }

    /**
     * Handle model not found exceptions.
     */
    public function render404(ModelNotFoundException $e): JsonResponse {
        $model = class_basename($e->getModel());

        return api()->error(
            message: "$model not found",
            status: 404
        );
    }

    /**
     * Handle validation exceptions.
     */
    public function render422(ValidationException $e): JsonResponse {
        return api()->error(
            message: 'Validation failed',
            errors: $e->errors(),
            status: 422
        );
    }

    /**
     * Handle all other exceptions.
     */
    public function renderDefault(Throwable $e): JsonResponse {
        $isProd = app()->isProduction();

        return api()->error(
            message: $isProd ? 'Something went wrong' : $e->getMessage(),
            errors: $isProd ? [] : [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ],
            status: 500,
        );
    }
}
