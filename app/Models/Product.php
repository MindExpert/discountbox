<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\QueryBuilders\ProductQueryBuilder;
use App\Support\Helper;
use App\Support\SerialGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int          $id
 * @property int          $user_id # The user who created the product
 * @property string       $serial
 * @property string       $name
 * @property string|null  $description
 * @property string|null  $review
 * @property string|null  $url
 * @property StatusEnum   $status
 * @property bool         $highlighted
 * @property bool         $show_on_home
 * @property Carbon|null  $concluded_at
 * @property string       $label
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property Carbon|null  $deleted_at
 * @property User         $user
 * @property Collection|DiscountBox[] $discount_boxes
 *
 * @mixin ProductQueryBuilder
 */
class Product extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public static string $morph_key = 'product';

    protected $guarded = ['id'];

    protected $casts = [
        'concluded_at' => 'datetime',
        'highlighted'  => 'boolean',
        'show_on_home' => 'boolean',
        'status'       => StatusEnum::class,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->serial = Str::uuid();
        });

        static::created(function (Product $product) {
            $product->updateQuietly([
                'serial' => SerialGenerator::generateSerialNumber('PO', $product->id),
            ]);
        });
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile();
        $this->addMediaCollection('gallery_images');
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
            ->performOnCollections('featured_image');

        $this->addMediaConversion('image')
            ->width(582)
            ->height(432)
            ->fit(Manipulations::FIT_CROP, 582, 432)
            ->performOnCollections('featured_image');

        $this->addMediaConversion('gallery_images')
            ->width(640)
            ->height(500)
            ->fit(Manipulations::FIT_CROP, 640, 500)
            ->performOnCollections('gallery_images');

        $this->addMediaConversion('preview')
            ->width(150)
            ->height(150)
            ->fit(Manipulations::FIT_CROP, 150, 150);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function discount_boxes(): BelongsToMany
    {
        return $this->belongsToMany(DiscountBox::class, 'discount_box_product', 'product_id', 'discount_box_id')
            ->withTimestamps()
            ->using(DiscountBoxProduct::class);
    }

    public function getLabelAttribute(): string
    {
        return $this->serial;
    }

    public function getThumbnailAttribute(): string
    {
        if ($this->relationLoaded('media') && $this->getFirstMedia('featured_image')) {
            return $this->getFirstMediaUrl('featured_image', 'preview');
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

}
