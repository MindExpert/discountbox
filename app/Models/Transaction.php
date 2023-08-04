<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use App\Models\QueryBuilders\TransactionQueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Lang;

/**
 * @property int                   $id
 * @property int                   $user_id
 * @property string|null           $transactional_type
 * @property int|null              $transactional_id
 * @property string                $name
 * @property string|null           $notes
 * @property float                 $debit
 * @property float                 $credit
 * @property TransactionTypeEnum   $type
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 * @property Carbon|null           $deleted_at
 * @property User                  $user
 * @property Product|DiscountBox   $transactional
 *
 * @mixin TransactionQueryBuilder
 */
class Transaction extends Model
{
    protected $guarded = ['id'];

    public static string $morph_key = 'transaction';

    protected $casts = [
        'role' => TransactionTypeEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Transaction $transaction) {
            //
        });

        static::created(function (Transaction $transaction) {
            //
        });
    }

    public function newEloquentBuilder($query): TransactionQueryBuilder
    {
        return new TransactionQueryBuilder($query);
    }

    public function transactional(): MorphTo
    {
        return $this->morphTo('transactional', 'transactional_type', 'transactional_id')->withTrashed();
    }

    public function getNameAttribute($name): ?string
    {
        if ($name) {
            $decoded = json_decode($name, true);
            if ($decoded && isset($decoded['lang']) && Lang::has($decoded['lang'])) {
                return __($decoded['lang'], $decoded['params'] ?? []);
            }
        }

        return $name;
    }

}
