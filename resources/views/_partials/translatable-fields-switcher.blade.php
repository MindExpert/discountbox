<div class="container-fluid">
    <div class="translatable-fields-switcher inside-pages">
        <div class="btns-ef-inline" role="group">
            @foreach(config('app.locales') as $locale)
                <button type="button" class="translatable-fields-switcher-btn translatable-fields-switcher-btn-{{ $locale }} {{ ($locale === locale()) ? 'active' : '' }}" data-locale="{{ $locale }}">
                    @lang("general.locales.$locale")
                </button>
            @endforeach
        </div>
    </div>
</div>

@push('partial-scripts')
    <script>
        $(document).ready(function () {
            $('.translatable-fields-switcher-btn').click(function (e) {
                e.preventDefault();

                $('.translatable-fields-switcher-btn').removeClass('active');
                $(`.translatable-fields-switcher-btn-${$(this).data('locale')}`).addClass('active');

                $('.translatable-field-container').addClass('d-none');
                $(`.translatable-field-container-${$(this).data('locale')}`).removeClass('d-none');
            });
        });
    </script>
@endpush
