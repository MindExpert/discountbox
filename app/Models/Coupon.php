<?php

namespace App\Models;

use App\Enums\DiscountTypeEnum;
use App\Models\QueryBuilders\CouponQueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int                       $id
 * @property int                       $user_id     #CREATOR
 * @property int|null                  $assignee_id #TO WHICH USER THIS COUPON IS GIVEN
 * @property string                    $code
 * @property DiscountTypeEnum          $type
 * @property float                     $discount
 * @property Carbon                    $valid_from
 * @property Carbon                    $expires_at
 * @property Carbon|null               $applied_at
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property User                      $user
 * @property User|null                 $assignee
 * @property DiscountBox|null          $discount_box
 * @property Collection|DiscountBox[]  $discount_boxes
 *
 * @mixin CouponQueryBuilder
 */
class Coupon extends Model
{
    public static string $morph_key = 'coupon';

    protected $guarded = ['id'];

    protected $casts = [
        'valid_from' => 'datetime',
        'expires_at' => 'datetime',
        'applied_at' => 'datetime',
        'type'       => DiscountTypeEnum::class,
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Coupon $coupon) {
            if ($coupon->code !== null) {
                $coupon->code = Str::upper($coupon->code);
            } else {
                $coupon->code = Str::upper(Str::random(8));
            }
        });
    }

    public function newEloquentBuilder($query): CouponQueryBuilder
    {
        return new CouponQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        $value = null;

        if ($this->type === DiscountTypeEnum::PERCENTAGE) {
            $value = "{$this->discount}%";
        } elseif ($this->type === DiscountTypeEnum::VALUE) {
            $value = "{$this->discount}€";
        }

        return "{$this->code} ($value)";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }

    public function discount_boxes(): HasMany
    {
        return $this->hasMany(DiscountBox::class, 'coupon_id', 'id');
    }

    public function discount_box(): HasOne
    {
        return $this->hasOne(DiscountBox::class, 'coupon_id', 'id');
    }

    public function hasPercentageDiscount(): bool
    {
        return $this->type === DiscountTypeEnum::PERCENTAGE;
    }

    public function hasExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return $this->expires_at === null || $this->expires_at->isFuture();
    }

    public function isApplied(): bool
    {
        return $this->applied_at !== null;
    }

    public function hasBeenApplied(): bool
    {
        return $this->discount_boxes()->exists() || $this->isApplied();
    }

    public function canBeApplied(): bool
    {
        if (! $this->isValid()) {
            return false;
        }

        if ($this->hasExpired()) {
            return false;
        }

        if ($this->hasBeenApplied()) {
            return false;
        }

        return true;
    }

    public function canBeAppliedForUser(int $userId): bool
    {
        if (! $this->canBeApplied()) {
            return false;
        }

        if ($this->user_id !== null && $this->user_id !== $userId) {
            return false;
        }

        return true;
    }

    public function calculateDiscountedPrice(?float $price): float|int
    {
        if ($price === null) {
            return 0;
        }

        if (! $this->canBeApplied()) {
            return $price;
        }

        if ($this->hasPercentageDiscount()) {
            $discountedPrice = $price - ($price * $this->discount / 100);
        } else {
            $discountedPrice = $price - $this->discount;
        }

        if ($discountedPrice <= 0) {
            $discountedPrice = 0;
        }

        return $discountedPrice;
    }
}
