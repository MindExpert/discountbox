@if(isset($permissions['view']) && $permissions['view'])
    <a href="{{ route('management.coupons.show', ['coupon' => $id]) }}" class="btn btn-outline-info btn-sm dt-tippy-btn" title="@lang('coupon.actions.view')">
        <i class="fa fa-eye"></i>
    </a>
@endif
{{--@if(isset($permissions['update']) && $permissions['update'])--}}
{{--    <a href="{{ route('management.users.edit', ['user' => $id]) }}" class="btn btn-outline-warning btn-sm dt-tippy-btn" title="@lang('user.actions.edit')">--}}
{{--        <i class="fa fa-pen"></i>--}}
{{--    </a>--}}
{{--@endif--}}
@if(isset($permissions['delete']) && $permissions['delete'])
    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm dt-tippy-btn action-button" title="@lang('coupon.actions.delete')"
       data-action="{{ route('management.coupons.destroy', ['coupon' => $id]) }}"
       data-method="DELETE"
       data-title="@lang('coupon.actions.delete')"
       data-message="@lang('coupon.actions.ask_delete')"
       data-is-danger="true"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
