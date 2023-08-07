@can('view', $transaction)
    <a href="{{ route('management.transactions.show', ['transaction' => $transaction->id]) }}"
       class="btn-link dt-popover-el"
       data-bs-content="{{ $html }}"
       data-bs-original-title="@lang('transaction.fields.notes')">{{ $transaction->name }}</a>
@else
    <span class="dt-popover-el" data-bs-original-title="@lang('transaction.fields.notes')" data-bs-content="{{ $html }}">
        {{ $transaction->name }}
    </span>
@endcan
