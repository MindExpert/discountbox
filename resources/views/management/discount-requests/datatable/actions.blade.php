@if(isset($permissions['view']) && $permissions['view'])
    <a href="{{ route('management.discount-requests.show', ['discountRequest' => $id]) }}" class="btn btn-outline-info btn-sm dt-tippy-btn" title="@lang('general.actions.view')">
        <i class="fa fa-eye"></i>
    </a>
@endif

@if(isset($permissions['toggleStatus']) && $permissions['toggleStatus'])
    <a href="javascript:void(0);" class="btn btn-outline-success btn-sm dt-tippy-btn action-button" title="@lang('general.actions.approve')"
       data-action="{{ route('management.discount-requests.approve', ['discountRequest' => $id]) }}"
       data-method="POST"
       data-title="@lang('general.actions.approve')"
       data-message="@lang('discount_request.actions.ask_approve')"
       data-is-danger="true"
    >
        <i class="bx bx-check-circle"></i>
    </a>
    <a href="javascript:void(0);" class="btn btn-outline-warning btn-sm dt-tippy-btn action-button" title="@lang('general.actions.reject')"
       data-action="{{ route('management.discount-requests.reject', ['discountRequest' => $id]) }}"
       data-method="POST"
       data-title="@lang('general.actions.reject')"
       data-message="@lang('discount_request.actions.ask_reject')"
       data-is-danger="true"
    >
        <i class="bx bx-error-alt"></i>
    </a>
@endif

@if(isset($permissions['delete']) && $permissions['delete'])
    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm dt-tippy-btn action-button" title="@lang('general.actions.delete')"
       data-action="{{ route('management.discount-requests.destroy', ['discountRequest' => $id]) }}"
       data-method="DELETE"
       data-title="@lang('general.actions.delete')"
       data-message="@lang('discount_request.actions.ask_delete')"
       data-is-danger="true"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
