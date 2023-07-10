<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\QueryBuilders\DiscountBoxQueryBuilder;
use App\Support\Helper;
use App\Support\SerialGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property string               $serial
 * @property string               $name
 * @property float|null           $price
 * @property float|null           $discount # Calculated Discount from COUPON RELATIONSHIP (as a value)
 * @property float|null           $total    # Calculated Total (Price - Discount)
//* @property string|null          $discount_type # Got it from COUPON RELATIONSHIP
//* @property float|null           $discount
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
 * @property Collection|Product[] $products
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_box_product', 'discount_box_id', 'product_id')
            ->withTimestamps()
            ->using(DiscountBoxProduct::class);
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
