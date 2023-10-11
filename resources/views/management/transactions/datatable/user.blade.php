@can('view', $transaction->user)
    <a href="{{ route('management.users.show', ['user' => $transaction->user->id]) }}" class="link-blue">{{ $transaction->user?->label }}</a>
@else
    {{ $transaction->user?->label }}
@endcan
