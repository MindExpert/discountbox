<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

final class ActionJsonResponse
{
    private bool $success;

    private int $httpStatusCode;

    private ?string $redirectTo;

    public function __construct(bool $success, int $httpStatusCode = 200, ?string $redirectTo = null)
    {
        $this->success = $success;
        $this->httpStatusCode = $httpStatusCode;
        $this->redirectTo = $redirectTo;
    }

    public static function make(bool $success, ?string $redirectTo = null): self
    {
        $httpStatusCode = $success ? 200 : 500;

        return new self($success, $httpStatusCode, $redirectTo);
    }

    public function response(): JsonResponse
    {
        return response()->json([
            'data' => [
                'success' => $this->success,
                'redirect_to' => $this->redirectTo,
            ]
        ], $this->httpStatusCode);
    }
}
