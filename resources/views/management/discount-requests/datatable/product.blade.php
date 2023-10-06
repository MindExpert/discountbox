@can('view', $discountRequest->product)
    <a href="{{ route('management.products.show', ['product' => $discountRequest->product->id]) }}" class="link-blue">{{ $discountRequest->product?->label }}</a>
@else
    {{ $discountRequest->product?->label }}
@endcan
