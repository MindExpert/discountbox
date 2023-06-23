<?php

namespace App\Http\Requests\Management;

use App\Enums\RolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        //$locales = implode(',', config('app.locales'));

        return [
            'role'            => ['required', new Enum(RolesEnum::class)],
            'first_name'      => ['required', 'string', 'max:150'],
            'last_name'       => ['required', 'string', 'max:150'],
            'nickname'        => ['required', 'string', 'max:150'],
            'email'           => ['required', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'password'        => ['required', 'confirmed', 'min:8'],
            'mobile'          => ['nullable', 'max:25'],
            //'locale'          => ['nullable', 'string', "in:{$locales}"],
            'birth_date'      => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'role'           => __('user.fields.role'),
            'first_name'     => __('user.fields.first_name'),
            'last_name'      => __('user.fields.last_name'),
            'nickname'       => __('user.fields.nickname'),
            'email'          => __('user.fields.email'),
            'password'       => __('user.fields.password'),
            'mobile'         => __('user.fields.mobile'),
            //'locale'         => __('user.fields.locale'),
            'birth_date'     => __('user.fields.birth_date'),
        ];
    }
}
