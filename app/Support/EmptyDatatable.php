<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

final class EmptyDatatable
{
    public static function response(): array
    {
        return [
            'data'            => [],
            'draw'            => 1,
            'recordsFiltered' => 0,
            'recordsTotal'    => 0,
        ];
    }

    public static function toJson(): JsonResponse
    {
        return response()->json(self::response());
    }
}
