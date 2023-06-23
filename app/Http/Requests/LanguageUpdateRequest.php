<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $locales = implode(',', config('app.locales'));

        return [
            'locale' => ['required', "in:{$locales}"],
        ];
    }
}
