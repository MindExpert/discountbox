@if(isset($permissions['view']) && $permissions['view'])
    <a href="{{ route('management.discount-boxes.show', ['discountBox' => $id]) }}" class="btn btn-outline-info btn-sm dt-tippy-btn" title="@lang('discount_box.actions.view')">
        <i class="fa fa-eye"></i>
    </a>
@endif
@if(isset($permissions['update']) && $permissions['update'])
    <a href="{{ route('management.discount-boxes.edit', ['discountBox' => $id]) }}" class="btn btn-outline-warning btn-sm dt-tippy-btn" title="@lang('discount_box.actions.edit')">
        <i class="fa fa-edit"></i>
    </a>
@endif
@if(isset($permissions['update_partial']) && $permissions['update_partial'])
    <a href="javascript:void(0)"
       data-model-id="{{$id}}"
       class="btn btn-outline-info btn-sm dt-tippy-btn js-init-dynamic-modal-edit-discount-box"
       title="@lang('discount_box.actions.update_winner')"
    >
        <i class="fas fa-gift"></i>
    </a>
@endif
@if(isset($permissions['delete']) && $permissions['delete'])
    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm dt-tippy-btn action-button" title="@lang('discount_box.actions.delete')"
       data-action="{{ route('management.discount-boxes.destroy', ['discountBox' => $id]) }}"
       data-method="DELETE"
       data-title="@lang('discount_box.actions.delete')"
       data-message="@lang('discount_box.actions.ask_delete')"
       data-is-danger="true"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
