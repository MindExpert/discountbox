<div id="modal-action-wrapper-cover-image"></div>
@php
    if (request()->route()?->getName() === 'management.discount-boxes.show') {
        $redirectTo = request()->fullUrl();
    } else {
        $redirectTo = null;
    }
@endphp
@push('partial-scripts')
    <script>
        $(document).ready(function () {
            let $ActionWrapper = $('#modal-action-wrapper-cover-image'),
                $body = $('body');

            $body.on('click', '.js-init-dynamic-modal-cover-image', function () {
                let $this = $(this);
                if (!$this.attr('disabled')) {
                    $this.attr('disabled', true);
                    setTimeout(() => $this.attr('disabled', false), 1000);
                    viewModal($(this).data('model-id'));
                }
            });

            function viewModal(modelId) {
                $.ajax({
                    url: '{{ route('management.discount-boxes.image', ['redirect_to' => $redirectTo]) }}',
                    type: 'GET',
                    data: {
                        model_id: modelId,
                    },
                    dataType: 'JSON',
                    cache: false,
                    success: function (response) {
                        // IMPORTANT: This 3 rows should always come first
                        $ActionWrapper.html(response.data.details);
                        let Modal = new bootstrap.Modal(document.getElementById('dynamic-view-cover-image-modal'), {
                            keyboard: false,
                            backdrop: 'static'
                        });
                        Modal.show();

                        // EVERYTHING YOU NEED TO DO SHOULD HAPPEN BEYOND THIS POINT
                        let $modalElement = $('#dynamic-view-cover-image-modal');

                        // Init Select2 for static options
                        $(".js-dynamic-modal-select").select2({
                            allowClear: true,
                            dropdownParent: $modalElement,
                        });

                        document.getElementById('dynamic-view-cover-image-modal').addEventListener('hidden.bs.modal', function () {
                            $ActionWrapper.html('');
                        });
                    },
                    error: function (response) {
                        if (response.status === 404) {
                            toastr.error('{{ __('general.no_data') }}', '{{ __('general.error') }}');
                        } else {
                            toastr.error("{{ __('general.server_error') }}", '{{ __('general.error') }}');
                        }
                    },
                });
            }
        });
    </script>
@endpush
