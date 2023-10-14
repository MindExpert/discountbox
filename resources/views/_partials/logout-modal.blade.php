<!-- LOGOUT MODAL -->
<div id="partial-logout-modal" class="modal fade" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">@lang('general.actions.logout')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted">@lang('general.logout_message')</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">@lang('general.close')</button>
                <a class="btn btn-primary waves-effect waves-light" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('partial-logout-form').submit();">
                    @lang('general.actions.logout')
                </a>
                <form id="partial-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
