<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\QueryBuilders\ProductQueryBuilder;
use App\Support\Helper;
use App\Support\SerialGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int          $id
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
 *
 * @mixin ProductQueryBuilder
 */
class Product extends Model
{
    use SoftDeletes;

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
