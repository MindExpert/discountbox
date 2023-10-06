<?php

namespace App\Http\Requests\Management;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class ProductUpdateRequest extends FormRequest
{
    use ValidatesMedia;

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string', 'max:5000'],
            'review'          => ['nullable', 'string', 'max:5000'],
            'url'             => ['nullable', 'string'],
            'price'           => ['nullable', 'numeric', 'gte:0', 'lte:999999.99'],
            'featured_image' => [
                'nullable',
                $this
                    ->validateSingleMedia()
                    ->maxItemSizeInKb(2048)
                    ->attribute('featured_image', ['required'])
            ],
            'gallery_images' => [
                'nullable',
                $this
                    ->validateMultipleMedia()
                    ->maxItemSizeInKb(10240)
                    ->attribute('gallery_images', ['required'])
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
            'price'           => __('product.fields.price'),
            'featured_image'  => __('product.fields.featured_image'),
            'gallery_images'  => __('product.fields.gallery_images'),
        ];
    }
}
