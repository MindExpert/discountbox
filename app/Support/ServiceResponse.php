<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;

class ServiceResponse
{
    private bool $success;

    private int $httpStatusCode;

    private ?Model $model;

    public function __construct(bool $success, int $httpStatusCode = 200, ?Model $model = null)
    {
        $this->success = $success;
        $this->httpStatusCode = $httpStatusCode;
        $this->model = $model;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function httpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function model(): ?Model
    {
        return $this->model;
    }

    public function toArray(): array
    {
        return [
            'success'        => $this->success(),
            'httpStatusCode' => $this->httpStatusCode(),
            'model'          => $this->model(),
        ];
    }
}
