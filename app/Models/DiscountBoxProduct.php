<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int         $discount_box_id
 * @property int         $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class DiscountBoxProduct extends Pivot
{
    public static string $morph_key = 'discount_box_product';

    protected $table = 'discount_box_product';

    protected $casts = [
        //
    ];

    public function discount_box(): BelongsTo
    {
        return $this->belongsTo(DiscountBox::class, 'discount_box_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
