@props([
    'credits' => $credits ?? []
])
<div class="tab-pane" id="credits-tab">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">@lang('user.fields.invitation_code'): {{ user()?->invitation_code }}</h6>
            <form id="invitation-code-form">
                <div class="row mb-2">
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="invitation_email" id="invitation_email" placeholder="{{ __('user.messages.invite_friend') }}">
                    </div>
                    <button class="col-sm-3 btn btn-primary" type="button"  id="submit-invitation">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none"></span>
                        @lang('general.actions.send')
                    </button>
                </div>
                    <small class="text-muted">
                        <em>{{ __('user.messages.code_helper') }}</em>
                    </small>
            </form>
        </div>
        <!-- end card body -->
    </div>
    <div class="col-lg-12 content">
        <div class="section-title">
            <h4>@lang('user.actual_credit'): {{ $user_credit_balance ?? '' }}</h4>
        </div>
        @foreach($credits as $credit)
            <div class="icon-box aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="icon"><i class="bi {{$credit->type->icon()}} text-{{$credit->type->color()}}"></i></div>
                <h6 class="title" style="margin-left: 60px"><a href="javascript:void(0);">{{ $credit->name }}</a></h6>
                <p class="description">
                    {{ "$credit->notes" }} @if($credit->credit > 0) {{ $credit->credit }} @else {{ $credit->debit }} @endif <br/>
                    @lang('transaction.fields.type'): {{ $credit->type->label() }} <br>
                    {{ $credit->type->description($credit->credit) }}
                </p>
            </div>
        @endforeach
    </div>
</div>

@push('partial-scripts')
    <script>
        $(document).ready(function () {
            $('#submit-invitation').click(function (e) {
                e.preventDefault();
                let $this = $(this);

                $this.attr('disabled', true);
                // show spinner
                $this.find('.spinner-border').show();

                let invitationEmail = $('#invitation_email').val();

                if (invitationEmail) {
                    $.ajax({
                        url: '{{ route('frontend.invitation.send') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            invitation_email: invitationEmail
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#invitation_email').val('');
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }

                            $this.attr('disabled', false);
                            $this.find('.spinner-border').hide();
                        },
                        error: function (response) {
                            toastr.error(response.responseJSON.message, response.statusText);
                            $this.attr('disabled', false);
                            $this.find('.spinner-border').hide();
                        }
                    });
                } else {
                    $this.attr('disabled', false);
                    $this.find('.spinner-border').hide();
                    toastr.error('{{ __('user.messages.email_required') }}');
                }
            });
        });
    </script>
@endpush
