<?php

namespace App\Models\QueryBuilders;

use App\Enums\DiscountRequestStatusEnum;
use App\Models\DiscountRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountBoxQueryBuilder extends Builder
{
    public function search(?string $keyword = null, int|array|null $id = null): DiscountBoxQueryBuilder
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

    public function withWinnerRequest(): DiscountBoxQueryBuilder
    {
        return $this->addSelect(['winning_request_id' => DiscountRequest::select('id')
            ->whereColumn('user_id', 'discount_boxes.id')
            ->where('status', DiscountRequestStatusEnum::APPROVED->value)
            ->latest()
            ->take(1),
        ])->with([
            'winning_request' => fn (BelongsTo $query) => $query->with('user'),
        ]); // this connects to lastLogin relation to get only one model.
    }
}
