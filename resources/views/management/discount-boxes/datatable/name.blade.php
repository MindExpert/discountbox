@can('view', $discountBox)
    <a href="{{ route('management.discount-boxes.show', ['discountBox' => $discountBox->id]) }}" class="btn-link">{{ $discountBox->name }}</a>
@else
    {{ $discountBox->name }}
@endcan
