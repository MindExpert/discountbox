<span class="badge rounded-pill bg-{{ $productDiscountRequest->status->color() }} dt-popover-el" data-bs-original-title="@lang('transaction.fields.notes')" data-bs-content="{{ $html }}">
    {{ $productDiscountRequest->status->label() }}
</span>
