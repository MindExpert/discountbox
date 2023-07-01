<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\QueryBuilders\DiscountBoxQueryBuilder;
use App\Support\Helper;
use App\Support\SerialGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int                  $id
 * @property int|null             $coupon_id
 * @property string               $serial
 * @property string               $name
 * @property float|null           $price
 * @property float|null           $discount # Calculated Discount from COUPON RELATIONSHIP
 * @property float|null           $total    # Calculated Total (Price - Discount)
//* @property string|null          $discount_type # Got it from COUPON RELATIONSHIP
//* @property float|null           $discount
 * @property Carbon|null          $expires_at
 * @property StatusEnum           $status
 * @property bool                 $highlighted
 * @property bool                 $show_on_home # Same as HOME_DISCOUNTBOX
 * @property string               $label
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property Carbon|null          $deleted_at
 *
 * @mixin DiscountBoxQueryBuilder
 */
class DiscountBox extends Model
{
    use SoftDeletes;

    public static string $morph_key = 'discount_box';

    protected $guarded = ['id'];

    protected $casts = [
        'expires_at'   => 'datetime',
        'highlighted'  => 'boolean',
        'show_on_home' => 'boolean',
        'status'       => StatusEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (DiscountBox $discountBox) {
            $discountBox->serial = Str::uuid();
        });

        static::created(function (DiscountBox $discountBox) {
            $discountBox->updateQuietly([
                'serial' => SerialGenerator::generateSerialNumber('DB', $discountBox->id),
            ]);
        });
    }

    public function newEloquentBuilder($query): DiscountBoxQueryBuilder
    {
        return new DiscountBoxQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return $this->serial;
    }

    public function inProgress(): bool
    {
        return $this->status === StatusEnum::IN_PROGRESS;
    }

    public function isAwarded(): bool
    {
        return $this->status === StatusEnum::AWARDED;
    }

    public function isConcluded(): bool
    {
        return $this->status === StatusEnum::CONCLUDED;
    }
}
