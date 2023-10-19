<div class="modal fade" id="dynamic-modal-edit-discount-box" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('discount_box.actions.update_winner')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajax-form" method="POST" action="{{ route('management.discount-boxes.update-partial', ['discountBox' => $discountBox, 'redirect_to' => $redirectTo]) }}">
                @csrf
                @method('PUT')
                <!-- MODAL BODY -->
                <div class="modal-body">
                    <div class="row">
                        <!-- USER_REQUEST_LIST -->
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="winner_user_id" class="form-label">@lang('discount_box.fields.winner_user_id')</label>
                                <select class="form-control js-dynamic-modal-select" name="winner_user_id" id="winner_user_id"
                                        data-allow-clear="true"
                                        data-placeholder="@lang('discount_box.fields.select_winner_user')" style="width: 100%">
                                    <option value="">@lang('discount_box.fields.select_winner_user')</option>
                                    @foreach($discountRequestsUser as $requestUser)
                                        <option value="{{ $requestUser->user_id }}" @selected($currentWinnerId == $requestUser->user_id)>{{ "{$requestUser->nickname} - {$requestUser->percentage}%" }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER MODAL -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-soft-primary submit-btn">
                        <i class="fas fa-check"></i> @lang('discount_box.actions.update') <i class="fa fa-spinner fa-spin d-none"></i>
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> @lang('general.close')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
