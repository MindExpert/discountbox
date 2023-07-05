<?php

namespace App\Http\Requests\Management;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class DiscountBoxStoreRequest extends FormRequest
{
    use ValidatesMedia;

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'price'           => ['required', 'numeric', 'gte:0', 'max:9999999'],
            'status'          => ['nullable', new Enum(StatusEnum::class)],
            'coupon_id'       => [
                'required',
                'numeric',
                Rule::exists('coupons', 'id')->whereNull('applied_at')
            ],
            'credits'         => ['required', 'numeric', 'gte:0', 'max:9999999'],
            'highlighted'     => ['nullable', 'boolean'],
            'show_on_home'    => ['nullable', 'boolean'],
            'cover_image' => [
                'nullable',
                $this
                    ->validateSingleMedia()
                    ->maxItemSizeInKb(2048)
                    ->attribute('cover_image', ['required'])
            ],
            'products' => ['required', 'array'],
            'products.*' => [
                'required',
                'numeric',
                Rule::exists('products', 'id')->whereNull('deleted_at')
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => __('discount_box.fields.name'),
            'price'         => __('discount_box.fields.price'),
            'status'        => __('discount_box.fields.status'),
            'coupon_id'     => __('discount_box.fields.coupon_id'),
            'credits'       => __('discount_box.fields.credits'),
            'highlighted'   => __('discount_box.fields.highlighted'),
            'show_on_home'  => __('discount_box.fields.show_on_home'),
            'cover_image'   => __('discount_box.fields.cover_image'),
            'products'      => __('discount_box.fields.products'),
            'products.*'    => __('discount_box.fields.products'),
        ];
    }
}
