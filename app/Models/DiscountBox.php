<?php

namespace App\Models;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Models\QueryBuilders\DiscountBoxQueryBuilder;
use App\Support\SerialGenerator;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int                  $id
 * @property int                  $user_id
 * @property int|null             $coupon_id
 * @property int|null             $product_id
 * @property string               $serial
 * @property string               $name
 * @property float|null           $max_discount_percentage
 * @property float|null           $price
 * @property float|null           $discount # Calculated Discount from COUPON RELATIONSHIP (as a value)
 * @property float|null           $total    # Calculated Total (Price - Discount)
 * @property string|null          $discount_type # Got it from COUPON RELATIONSHIP
 * @property Carbon|null          $expires_at
 * @property integer              $credits
 * @property StatusEnum           $status
 * @property bool                 $highlighted
 * @property bool                 $show_on_home # Same as HOME_DISCOUNT-BOX
 * @property string               $label
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property Carbon|null          $deleted_at
 * @property User                 $user
 * @property Coupon|null          $coupon
 * @property Product              $product
 * @property Collection|Transaction[] $transactions
 * @property Collection|DiscountRequest[] $discount_requests
 *
 * @mixin DiscountBoxQueryBuilder
 */
class DiscountBox extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    public static string $morph_key = 'discount_box';

    protected $guarded = ['id'];

    protected $casts = [
        'expires_at'   => 'datetime',
        'highlighted'  => 'boolean',
        'show_on_home' => 'boolean',
        'status'       => StatusEnum::class,
        'max_discount_percentage' => 'integer',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_image')->singleFile();
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(276)
            ->height(240)
            ->fit(Manipulations::FIT_CROP, 276, 240)
            ->performOnCollections('cover_image')
            ->keepOriginalImageFormat();

        $this->addMediaConversion('image')
            ->width(582)
            ->height(432)
            ->fit(Manipulations::FIT_CROP, 582, 432)
            ->performOnCollections('cover_image')
            ->keepOriginalImageFormat();

        $this->addMediaConversion('preview')
            ->width(150)
            ->height(150)
            ->fit(Manipulations::FIT_CROP, 150, 150);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactional', 'transactional_type', 'transactional_id', 'id');
    }

    public function discount_requests(): HasMany
    {
        return $this->hasMany(DiscountRequest::class, 'discount_box_id', 'id');
    }

    public function getLabelAttribute(): string
    {
        return $this->serial;
    }

    public function getThumbnailAttribute(): string
    {
        if ($this->relationLoaded('media') && $this->getFirstMedia('cover_image')) {
            return $this->getFirstMediaUrl('cover_image', 'preview');
        }

        return asset('frontend/assets/img/placeholderx2.png');
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

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isAvailable(): bool
    {
        return $this->inProgress() && ! $this->isExpired();
    }

    public function hasWinner(): bool
    {
        return $this->discount_requests()
            ->where('status', DiscountRequestStatusEnum::APPROVED)
            ->exists();
    }
}
