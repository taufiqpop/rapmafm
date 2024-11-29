@foreach ($permissions as $key => $value)
    <input type="hidden" name="{{ $key }}" class="permission_status" data-name="{{ $key }}"
        value="{{ $value ? 1 : 0 }}">
@endforeach

<script src="{{ config('app.theme') }}assets/libs/jquery/jquery.min.js?q={{ Str::random(5) }}"></script>
<script src="{{ config('app.theme') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js?q={{ Str::random(5) }}"></script>
<script src="{{ config('app.theme') }}assets/libs/metismenu/metisMenu.min.js?q={{ Str::random(5) }}"></script>
<script src="{{ config('app.theme') }}assets/libs/simplebar/simplebar.min.js?q={{ Str::random(5) }}"></script>
<script src="{{ config('app.theme') }}assets/libs/node-waves/waves.min.js?q={{ Str::random(5) }}"></script>
<script src="{{ config('app.theme') }}assets/libs/toastr/build/toastr.min.js?q={{ Str::random(5) }}"></script>
<script src="{{ asset('js/plugin/loading-overlay/loadingoverlay.min.js') }}?q={{ Str::random(5) }}"></script>

<script src="{{ asset('js/main.js') }}?q={{ Str::random(5) }}"></script>
<script src="{{ asset('js/app.js') }}?q={{ Str::random(5) }}"></script>
<script src="{{ asset('js/menu.js') }}?q={{ Str::random(5) }}"></script>
<script src="{{ asset('js/page/administrator/change-password/form.js') }}?q={{ Str::random(5) }}"></script>
<script src="{{ asset('js/page/administrator/change-profile/form.js') }}?q={{ Str::random(5) }}"></script>

@if (in_array('datatable', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/datatables.net/js/jquery.dataTables.min.js?q={{ Str::random(5) }}">
    </script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js?q={{ Str::random(5) }}">
    </script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js?q={{ Str::random(5) }}">
    </script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js?q={{ Str::random(5) }}">
    </script>
    <script src="{{ config('app.theme') }}assets/libs/jszip/jszip.min.js?q={{ Str::random(5) }}"></script>
    <script src="{{ config('app.theme') }}assets/libs/pdfmake/build/pdfmake.min.js?q={{ Str::random(5) }}"></script>
    <script src="{{ config('app.theme') }}assets/libs/pdfmake/build/vfs_fonts.js?q={{ Str::random(5) }}"></script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-buttons/js/buttons.html5.min.js?q={{ Str::random(5) }}">
    </script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-buttons/js/buttons.print.min.js?q={{ Str::random(5) }}">
    </script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-buttons/js/buttons.colVis.min.js?q={{ Str::random(5) }}">
    </script>

    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js?q={{ Str::random(5) }}">
    </script>
    <script
        src="{{ config('app.theme') }}assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js?q={{ Str::random(5) }}">
    </script>
    <script>
        $('body').on('draw.dt', function(e, ctx) {
            var api = new $.fn.dataTable.Api(ctx);

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endif

@if (in_array('form_wizard', $plugins))
    <script
        src="{{ config('app.theme') }}assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js?q={{ Str::random(5) }}">
    </script>

    <script src="{{ config('app.theme') }}assets/libs/twitter-bootstrap-wizard/prettify.js?q={{ Str::random(5) }}">
    </script>
@endif

@if (in_array('swal', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/sweetalert2/sweetalert2.min.js?q={{ Str::random(5) }}"></script>
@endif

@if (in_array('apex_chart', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/apexcharts/apexcharts.min.js?q={{ Str::random(5) }}"></script>
@endif

@if (in_array('lightbox', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/magnific-popup/jquery.magnific-popup.min.js?q={{ Str::random(5) }}">
    </script>
@endif

@if (in_array('select2', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/select2/js/select2.min.js?q={{ Str::random(5) }}"></script>
@endif

@if (in_array('tui_chart', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/tui-chart/tui-chart-all.min.js?q={{ Str::random(5) }}"></script>
@endif

@if (in_array('leaflet', $plugins))
    <script src="{{ asset('js/plugin/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('js/plugin/leaflet/leaflet-esri.js') }}"></script>
    <script src="{{ asset('js/plugin/leaflet/leaflet.ajax.js') }}"></script>
@endif

@if (in_array('datepicker', $plugins))
    <script
        src="{{ config('app.theme') }}assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js?q={{ Str::random(5) }}">
    </script>
@endif

@if (in_array('chart_js', $plugins))
    <script src="{{ config('app.theme') }}assets/libs/chart.js/Chart.bundle.min.js?q={{ Str::random(5) }}"></script>
    <script src="{{ config('app.theme') }}assets/js/pages/chartjs.init.js?q={{ Str::random(5) }}"></script>
@endif
