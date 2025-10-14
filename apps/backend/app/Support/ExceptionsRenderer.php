<?php

namespace App\Support;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class ExceptionsRenderer {

    protected bool $isProd;

    public function __construct() {
        $this->isProd = app()->isProduction();
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Throwable $e): JsonResponse {
        // Map exception types to handler methods
        $exceptionHandler = match (true) {
            $e instanceof AuthenticationException => [$this, 'authentication'],
            $e instanceof AuthorizationException => [$this, 'authorization'],
            $e instanceof ValidationException => [$this, 'validations'],
            $e instanceof ModelNotFoundException => [$this, 'model_not_found'],
            $e instanceof RouteNotFoundException => [$this, 'route_not_found'],
            $e instanceof QueryException => [$this, 'query'],
            default => [$this, 'default'],
        };

        return $exceptionHandler($e);
    }

    /**
     * Handle unauthenticated requests.
     */
    protected function authentication(AuthenticationException $e): JsonResponse {
        return api()->error(
            message: 'You are not authenticated',
            status: 401
        );
    }

    /**
     * Handle unauthorized requests.
     */
    protected function authorization(AuthorizationException $e): JsonResponse {
        return api()->error(
            message: 'You do not have permission to perform this action',
            status: 403
        );
    }

    /**
     * Handle model not found exceptions.
     */
    protected function model_not_found(ModelNotFoundException $e): JsonResponse {
        $model = class_basename($e->getModel());
        return api()->error(
            message: "$model not found",
            status: 404
        );
    }

    /**
     * Handle route not found exceptions.
     */
    protected function route_not_found(RouteNotFoundException $e): JsonResponse {
        return api()->error(
            message: "Route not found",
            status: 404
        );
    }

    /**
     * Handle validation exceptions.
     */
    protected function validations(ValidationException $e): JsonResponse {
        return api()->error(
            message: 'Validation failed',
            errors: $e->errors(),
            status: 422
        );
    }

    /**
     * Handle database query exceptions.
     */
    protected function query(QueryException $e): JsonResponse {
        return api()->error(
            message: $this->isProd ? 'Something went wrong' : $e->getMessage(),
            errors: $this->isProd ? [] : [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'code' => $e->getCode(),
            ],
            status: 500,
        );
    }

    /**
     * Handle all other exceptions.
     */
    protected function default(Throwable $e): JsonResponse {
        return api()->error(
            message: $this->isProd ? 'Something went wrong' : $e->getMessage(),
            errors: $this->isProd ? [] : [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ],
            status: 500,
        );
    }
}
