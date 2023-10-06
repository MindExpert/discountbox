<?php

namespace App\Models;

use App\Enums\DiscountRequestStatusEnum;
use App\Models\QueryBuilders\DiscountRequestQueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int          $id
 * @property int          $user_id          # The user who submitted the request
 * @property int          $discount_box_id  # The user who created the product
 * @property double       $percentage       # The percentage user entered
 * @property double       $credit           # The credits taken for participating in the discount
 * @property string|null  $notes
 * @property DiscountRequestStatusEnum   $status
 * @property Carbon|null  $approved_at
 * @property string       $label
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property Carbon|null  $deleted_at
 *
 * @property User         $user
 * @property DiscountBox  $discount_box
 * @property Collection|Transaction[] $transactions
 *
 * @mixin DiscountRequestQueryBuilder
 */
class DiscountRequest extends Model
{
    use SoftDeletes;

    public static string $morph_key = 'discount_request';

    protected $guarded = ['id'];

    protected $casts = [
        'approved_at' => 'datetime',
        'credit'      => 'double',
        'status'      => DiscountRequestStatusEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (DiscountRequest $discountRequest) {
            //
        });

        static::created(function (DiscountRequest $discountRequest) {
            //
        });
    }

    public function newEloquentBuilder($query): DiscountRequestQueryBuilder
    {
        return new DiscountRequestQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function discount_box(): BelongsTo
    {
        return $this->belongsTo(DiscountBox::class, 'discount_box_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactional', 'transactional_type', 'transactional_id', 'id');
    }

    public function getLabelAttribute(): string
    {
        return $this->id;
    }

    public function inPending(): bool
    {
        return $this->status === DiscountRequestStatusEnum::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === DiscountRequestStatusEnum::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === DiscountRequestStatusEnum::REJECTED;
    }
}
