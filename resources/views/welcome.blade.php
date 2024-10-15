<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laravel + Vue</title>
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/toastr/toastr.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

        <link rel="stylesheet" href="{{ asset('packages/select2/css/select2.min.css') }}">
        <style>
            span.select2-selection__choice__display{
                color: #000;
                padding: 0px 5px !important;
            }
        </style>
    </head>
    <body>
        <div id="app"></div>

        <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('packages/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('packages/select2/js/select2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script>
            window.csrf_token = "{{ csrf_token() }}";
        </script>
        @vite(['resources/js/app.js'])
    </body>
</html>
