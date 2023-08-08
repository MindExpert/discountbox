@can('view', $transaction->user)
    <a href="{{ route('management.users.show', ['user' => $transaction->user->id]) }}" class="link-blue">{{ $transaction->user?->full_name }}</a>
@else
    {{ $transaction->user?->full_name }}
@endcan
