<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class TransactionQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null): TransactionQueryBuilder
    {
        return $this;
    }
}
