@if($product->show_on_home)
    <span class="badge rounded-pill bg-success text-center">
        @lang('general.yes')
    </span>
@else
    <span class="badge rounded-pill bg-warning text-center">
        @lang('general.no')
    </span>
@endif
