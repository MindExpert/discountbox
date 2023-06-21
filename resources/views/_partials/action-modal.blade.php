<!-- ACTION MODAL -->
<div id="action-modal" class="modal fade" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel"><span id="action-title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <span id="action-message"></span>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <form action="javascript:void(0);" id="action-form-modal" method="POST">
                    <div id="action-form-inputs"></div>
                    <button type="submit" class="btn btn-danger" id="action-form-button">
                        @lang('general.yes')
                    </button>
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
