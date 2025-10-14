<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

/**
 * @template T
 */
final class Result {
    private int $httpCode = 200;
    private array $meta = [];

    private function __construct(
        private bool $ok,
        private mixed $value,
        private ?string $error = null,
        private array $errorDetails = []
    ) {
    }

    /**
     * @param T|null $value
     * @return self<T>
     */
    public static function ok($value = null): self {
        return new self(true, $value);
    }

    /**
     * @param string $error
     * @param array $details
     * @return self<null>
     */
    public static function fail(string $error, array $details = []): self {
        return new self(false, null, $error, $details);
    }

    public function isOk(): bool {
        return $this->ok;
    }

    public function value(): mixed {
        return $this->value;
    }

    public function error(): ?string {
        return $this->error;
    }

    public function errorDetails(): array {
        return $this->errorDetails;
    }

    /** Attach meta for success */
    public function withMeta(array $meta): self {
        $this->meta = $meta;
        return $this;
    }

    /** Override HTTP status */
    public function withHttpCode(int $code): self {
        $this->httpCode = $code;
        return $this;
    }

    /** Convert to standardized API response */
    public function toResponse(string $successMessage = 'OK'): JsonResponse {
        if ($this->isOk()) {
            return ApiResponse::success(
                data: $this->value,
                message: $successMessage,
                meta: $this->meta,
                status: $this->httpCode
            );
        }

        return ApiResponse::error(
            message: $this->error ?? 'Unknown error',
            status: $this->httpCode > 0 ? $this->httpCode : 400,
            errors: $this->errorDetails
        );
    }
}
