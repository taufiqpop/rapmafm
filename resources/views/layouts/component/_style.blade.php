<!-- Bootstrap Css -->
<link href="{{ config('app.theme') }}assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ config('app.theme') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ config('app.theme') }}assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ config('app.theme') }}assets/libs/toastr/build/toastr.min.css">

@if (in_array('datatable', @$plugins))
    <!-- DataTables -->
    <link href="{{ config('app.theme') }}assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ config('app.theme') }}assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ config('app.theme') }}assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
@endif

@if (in_array('form_wizard', @$plugins))
    <!-- twitter-bootstrap-wizard css -->
    <link rel="stylesheet" href="{{ config('app.theme') }}assets/libs/twitter-bootstrap-wizard/prettify.css">
@endif

@if (in_array('leaflet', @$plugins))
    <!-- leaflet Css -->
    <link href="{{ config('app.theme') }}assets/libs/leaflet/leaflet.css" rel="stylesheet" type="text/css" />
@endif

@if (in_array('swal', @$plugins))
    <!-- Sweet Alert-->
    <link href="{{ config('app.theme') }}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"
        type="text/css" />
@endif

@if (in_array('lightbox', @$plugins))
    <!-- Lightbox css -->
    <link href="{{ config('app.theme') }}assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet"
        type="text/css" />
@endif

@if (in_array('select2', @$plugins))
    <link href="{{ config('app.theme') }}assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endif

@if (in_array('tui_chart', @$plugins))
    <!-- tui charts Css -->
    <link href="{{ config('app.theme') }}assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" />
@endif

@if (in_array('datepicker', @$plugins))
    <link href="{{ config('app.theme') }}assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"
        rel="stylesheet" type="text/css">
@endif
