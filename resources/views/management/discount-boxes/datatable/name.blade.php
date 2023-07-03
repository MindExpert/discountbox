@can('view', $product)
    <a href="{{ route('management.products.show', ['product' => $product->id]) }}" class="btn-link">{{ $product->name }}</a>
@else
    {{ $product->name }}
@endcan
