<span class="badge rounded-pill bg-{{ $discountRequest->status->color() }} dt-popover-el" data-bs-original-title="@lang('transaction.fields.notes')" data-bs-content="{{ $html }}">
    {{ $discountRequest->status->label() }}
</span>
