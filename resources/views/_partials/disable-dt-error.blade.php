@if(app()->environment('production'))
    <script>
        if ($.fn.DataTable) {
            $.fn.dataTable.ext.errMode = 'none';
        }
    </script>
@endif
<script>
    $(function () {
        if ($.fn.DataTable) {
            let languages = {
                'it': '{{ asset('datatable/it.json') }}',
                'en': '{{ asset('datatable/en.json') }}',
                'sq': '{{ asset('datatable/sq.json') }}',
            };
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
            });
        }
    });
</script>
