@if(isset($permissions['view']) && $permissions['view'])
    <a href="{{ route('management.products.show', ['product' => $id]) }}" class="btn btn-outline-info btn-sm dt-tippy-btn" title="@lang('product.actions.view')">
        <i class="fa fa-eye"></i>
    </a>
@endif
@if(isset($permissions['update']) && $permissions['update'])
    <a href="{{ route('management.products.edit', ['product' => $id]) }}" class="btn btn-outline-warning btn-sm dt-tippy-btn" title="@lang('product.actions.edit')">
        <i class="fa fa-pen"></i>
    </a>
@endif
@if(isset($permissions['delete']) && $permissions['delete'])
    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm dt-tippy-btn action-button" title="@lang('product.actions.delete')"
       data-action="{{ route('management.products.destroy', ['product' => $id]) }}"
       data-method="DELETE"
       data-title="@lang('product.actions.delete')"
       data-message="@lang('product.actions.ask_delete')"
       data-is-danger="true"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
