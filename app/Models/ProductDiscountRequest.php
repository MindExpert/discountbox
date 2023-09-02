<?php

namespace App\Models;

use App\Enums\ProductDiscountRequestStatusEnum;
use App\Models\QueryBuilders\ProductDiscountRequestQueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int          $id
 * @property int          $user_id # The user who submitted the request
 * @property int          $discount_box_id # The user who created the product
 * @property int          $product_id # The user who created the product
 * @property double       $credit
 * @property string|null  $notes
 * @property ProductDiscountRequestStatusEnum   $status
 * @property Carbon|null  $approved_at
 * @property string       $label
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property Carbon|null  $deleted_at
 *
 * @property User         $user
 * @property DiscountBox  $discount_box
 * @property Product      $product
 * @property Collection|Transaction[] $transactions
 *
 * @mixin ProductDiscountRequestQueryBuilder
 */
class ProductDiscountRequest extends Model
{
    use SoftDeletes;

    public static string $morph_key = 'product_discount_request';

    protected $guarded = ['id'];

    protected $casts = [
        'approved_at' => 'datetime',
        'credit'      => 'double',
        'status'      => ProductDiscountRequestStatusEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ProductDiscountRequest $productDiscountRequest) {
            //
        });

        static::created(function (ProductDiscountRequest $productDiscountRequest) {
            //
        });
    }

    public function newEloquentBuilder($query): ProductDiscountRequestQueryBuilder
    {
        return new ProductDiscountRequestQueryBuilder($query);
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
        return $this->status === ProductDiscountRequestStatusEnum::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === ProductDiscountRequestStatusEnum::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === ProductDiscountRequestStatusEnum::REJECTED;
    }
}
