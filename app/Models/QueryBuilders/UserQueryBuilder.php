<?php

namespace App\Models\QueryBuilders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null): UserQueryBuilder
    {
        $query = $this
            ->orderBy('first_name')
            ->orderBy('last_name');

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
                    ->orWhere('email', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}
