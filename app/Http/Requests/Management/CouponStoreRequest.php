<?php

namespace App\Http\Requests\Management;

use App\Enums\DiscountTypeEnum;
use App\Enums\RolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CouponStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'            => ['nullable','string', 'min:8', 'max:12'],
            'type'            => ['required', new Enum(DiscountTypeEnum::class)],
            'discount'        => ['required', 'numeric', 'gte:0', Rule::when($this->input('type') == DiscountTypeEnum::PERCENTAGE->value, ['min:0', 'max:100'])],
            'valid_from'      => ['required', 'date', 'after_or_equal:today'],
            'expires_at'      => ['nullable', 'date', 'after_or_equal:valid_from'],
            'assignee_id'     => ['nullable', 'numeric', Rule::exists('users', 'id')->whereNull('deleted_at')],
        ];
    }

    public function attributes(): array
    {
        return [
            'code'         => __('coupon.fields.code'),
            'type'         => __('coupon.fields.type'),
            'discount'     => __('coupon.fields.discount'),
            'valid_from'   => __('coupon.fields.valid_from'),
            'expires_at'   => __('coupon.fields.expires_at'),
            'assignee_id'  => __('coupon.fields.assignee_id'),
        ];
    }
}
