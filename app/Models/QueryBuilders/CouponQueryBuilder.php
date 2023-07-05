<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CouponQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null, ?bool $onlyActive  = null): CouponQueryBuilder
    {
        $query = $this
            ->when($onlyActive, function (CouponQueryBuilder $query) {
                return $query->where(function (Builder $query) {
                    return $query
                        ->whereNull('applied_at')
                        ->where('expires_at', '>', now());
                });
            })
            ->orderBy('code');

        if (! empty($id)) {
            if (is_array($id)) {
                $this->whereIn('id', $id)->limit(count($id));
            } else {
                $this->where('id', $id)->limit(1);
            }
        }

        //if ($id !== null) {
        //    return $this->where('id', $id)->limit(1);
        //}

        if ($keyword === null) {
            return $query->limit(50);
        }

        $keywords = keyword_to_array($keyword, '%');

        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query->where('code', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}
