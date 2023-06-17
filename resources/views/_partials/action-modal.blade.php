<!-- ACTION MODAL -->
<div id="action-modal" class="modal fade" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header border-bottom border-2 pb-3">
                <h5 class="modal-title" id="logoutModalLabel">
                    <span id="action-title"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <span id="action-message"></span>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer border-top border-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('general.no')</button>
                <form action="javascript:void(0);" id="action-form-modal" method="POST">
                    <div id="action-form-inputs"></div>
                    <button type="submit" class="btn btn-danger" id="action-form-button">
                        @lang('general.yes')
                    </button>
                </form>
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
