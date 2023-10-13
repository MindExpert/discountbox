<?php

namespace App\Http\Requests\Management;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use App\Models\DiscountRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class DiscountRequestStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id'          => ['required', 'numeric', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'discount_box_id'  => ['required', 'numeric', Rule::exists('discount_boxes', 'id')->whereNull('deleted_at')],
            'percentage'       => ['required', 'numeric', 'gte:0', 'lte:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id'         => __('discount_request.fields.user_id'),
            'discount_box_id' => __('discount_request.fields.discount_box_id'),
            'percentage'      => __('discount_request.fields.percentage'),
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        if (! $validator->fails()) {
            $validator->after(function ($validator) {

                $userDiscountRequestExists = DiscountRequest::query()
                    ->where('user_id', $this->input('user_id'))
                    ->where('discount_box_id', $this->input('discount_box_id'))
                    ->where('status', '!=', DiscountRequestStatusEnum::REJECTED->value)
                    ->exists();

                if ($userDiscountRequestExists) {
                    $validator->errors()->add('user_id', __('discount_request.validation.already_requested'));
                }

                /** @var DiscountBox $discountBox */
                $discountBox = DiscountBox::query()->find($this->input('discount_box_id'));

                if ($discountBox->status != StatusEnum::IN_PROGRESS) {
                    $validator->errors()->add('discount_box_id', __('discount_request.validation.discount_box_not_in_progress'));
                }

                /** @var User $user */
                $user = User::query()->find($this->input('user_id'));

                if($discountBox->credits > $user->availableBalance()) {
                    $validator->errors()->add('user_id', __('discount_request.validation.user_not_enough_credits'));
                }

            });
        }
    }
}
