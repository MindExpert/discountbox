@can('view', $transaction)
    <a href="{{ route('management.transactions.show', ['transaction' => $transaction->id]) }}" class="link-blue">{{ $transaction->name }}</a>
@else
    {{ $transaction->name }}
@endcan
