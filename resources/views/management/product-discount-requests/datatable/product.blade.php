@can('view', $productDiscountRequest->product)
    <a href="{{ route('management.products.show', ['product' => $productDiscountRequest->product->id]) }}" class="link-blue">{{ $productDiscountRequest->product?->label }}</a>
@else
    {{ $productDiscountRequest->product?->label }}
@endcan
