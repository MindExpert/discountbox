<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ProductDiscountRequestQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null): ProductDiscountRequestQueryBuilder
    {
        return $this;
    }
}
