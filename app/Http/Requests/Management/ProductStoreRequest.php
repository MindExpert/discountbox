<?php

namespace App\Http\Requests\Management;

use App\Enums\RolesEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class ProductStoreRequest extends FormRequest
{
    use ValidatesMedia;

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string', 'max:5000'],
            'review'          => ['nullable', 'string', 'max:5000'],
            'url'             => ['nullable', 'string', 'url'],
            'status'          => ['nullable', new Enum(StatusEnum::class)],
            'highlighted'     => ['nullable', 'boolean'],
            'show_on_home'    => ['nullable', 'boolean'],
            'featured_image' => [
                'nullable',
                $this
                    ->validateSingleMedia()
                    ->maxItemSizeInKb(2048)
                    ->attribute('featured_image', ['required'])
            ],
            'gallery' => [
                'nullable',
                $this
                    ->validateMultipleMedia()
                    ->maxItemSizeInKb(10240)
                    ->attribute('gallery', ['required'])
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'            => __('product.fields.name'),
            'description'     => __('product.fields.description'),
            'review'          => __('product.fields.review'),
            'url'             => __('product.fields.url'),
            'status'          => __('product.fields.status'),
            'highlighted'     => __('product.fields.highlighted'),
            'show_on_home'    => __('product.fields.show_on_home'),
            'featured_image'  => __('product.fields.featured_image'),
            'gallery'         => __('product.fields.gallery_images'),
        ];
    }
}
