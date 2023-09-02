@if(isset($permissions['view']) && $permissions['view'])
    <a href="{{ route('management.product-discount-requests.show', ['productDiscountRequest' => $id]) }}" class="btn btn-outline-info btn-sm dt-tippy-btn" title="@lang('general.actions.view')">
        <i class="fa fa-eye"></i>
    </a>
@endif

@if(isset($permissions['delete']) && $permissions['delete'])
    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm dt-tippy-btn action-button" title="@lang('general.actions.delete')"
       data-action="{{ route('management.product-discount-requests.destroy', ['productDiscountRequest' => $id]) }}"
       data-method="DELETE"
       data-title="@lang('general.actions.delete')"
       data-message="@lang('product_discount_request.actions.ask_delete')"
       data-is-danger="true"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
