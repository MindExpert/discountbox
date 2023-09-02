@can('view', $productDiscountRequest->user)
    <a href="{{ route('management.users.show', ['user' => $productDiscountRequest->user->id]) }}" class="link-blue">{{ $productDiscountRequest->user?->full_name }}</a>
@else
    {{ $productDiscountRequest->user?->full_name }}
@endcan
