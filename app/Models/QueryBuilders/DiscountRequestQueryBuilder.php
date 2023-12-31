<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class DiscountRequestQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null): DiscountRequestQueryBuilder
    {
        return $this;
    }
}
