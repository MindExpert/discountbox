<?php

namespace App\Http\Requests\Management;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class DiscountBoxUpdateRequest extends FormRequest
{
    use ValidatesMedia;

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'price'           => ['required', 'numeric', 'gte:0', 'max:9999999'],
            'expires_at'      => ['required', 'date'],
            'status'          => ['nullable', new Enum(StatusEnum::class)],
            'winner_user_id'  => ['nullable', 'numeric', Rule::requiredIf($this->input('status') === StatusEnum::AWARDED->value), Rule::exists('discount_requests', 'user_id')->whereNull('deleted_at')],
            'coupon_id'       => [
                'nullable',
                'numeric',
                Rule::exists('coupons', 'id')->whereNull('applied_at')
            ],
            'credits'         => ['required', 'numeric', 'gte:0', 'max:9999999'],
            'max_discount_percentage' => ['required', 'numeric', 'gte:0', 'max:100'],
            'highlighted'     => ['nullable', 'boolean'],
            'show_on_home'    => ['nullable', 'boolean'],
            'cover_image' => [
                'nullable',
                $this
                    ->validateSingleMedia()
                    ->maxItemSizeInKb(2048)
                    ->attribute('cover_image', ['required'])
            ],
            'product_id' => [
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
            'expires_at'    => __('discount_box.fields.expires_at'),
            'status'        => __('discount_box.fields.status'),
            'winner_user_id'=> __('discount_box.fields.winner_user_id'),
            'coupon_id'     => __('discount_box.fields.coupon_id'),
            'credits'       => __('discount_box.fields.credits'),
            'highlighted'   => __('discount_box.fields.highlighted'),
            'show_on_home'  => __('discount_box.fields.show_on_home'),
            'cover_image'   => __('discount_box.fields.cover_image'),
            'product_id'    => __('discount_box.fields.product_id'),
            'max_discount_percentage' => __('discount_box.fields.max_discount_percentage'),
        ];
    }
}
