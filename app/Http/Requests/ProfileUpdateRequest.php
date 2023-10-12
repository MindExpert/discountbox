<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $locales = implode(',', config('app.locales'));

        /** @var User $currentUser */
        $currentUser = $this->route('user');

        return [
            'nickname'        => ['required', 'string', 'max:150', Rule::unique('users', 'nickname')->whereNull('deleted_at')->ignore($currentUser->id)],
            'email'           => ['required', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($currentUser->id)],
            //'first_name'      => ['required', 'string', 'max:150'],
            //'last_name'       => ['required', 'string', 'max:150'],
            'password'        => ['nullable', 'confirmed', 'min:8'],
            //'mobile'          => ['nullable', 'max:25'],
            //'locale'          => ['required', 'string', "in:{$locales}"],
            //'birth_date'      => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
        ];
    }

    public function attributes(): array
    {
        return [
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
