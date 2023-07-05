@can('view', $product)
    <a href="{{ route('management.products.show', ['product' => $product->id]) }}"
       class="btn-link dt-popover-el"
       data-bs-content="{{ $html }}"
       data-bs-original-title="@lang('product.fields.description')">{{ $product->name }}</a>
@else
    <span class="dt-popover-el" data-bs-original-title="@lang('product.fields.description')" data-bs-content="{{ $html }}">
        {{ $product->name }}
    </span>
@endcan
