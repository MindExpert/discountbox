<?php

namespace App\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TransactionStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id'         => ['required', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'amount'          => ['required', 'numeric', 'gt:0', 'max:9999999999'],
            'type'            => ['required', 'string', 'in:credit,debit'],
            'notes'           => ['nullable', 'string', 'max:500'],
            'created_at'      => ['nullable', 'date', 'before_or_equal:'.now()->format('Y-m-d 23:59:59')],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id'     => __('transaction.fields.user_id'),
            'amount'      => __('transaction.fields.amount'),
            'type'        => __('transaction.fields.type'),
            'notes'       => __('transaction.fields.notes'),
            'created_at'  => __('transaction.fields.created_at'),
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        if (! $validator->fails()) {
            $validator->after(function ($validator) {
                //
            });
        }
    }
}
