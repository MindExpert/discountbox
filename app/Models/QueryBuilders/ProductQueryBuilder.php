<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null): ProductQueryBuilder
    {
        $query = $this
            ->with('media')
            ->orderBy('name');

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
                return $query
                    ->where('name', 'LIKE', $keyword)
                    ->orWhere('serial', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}
