<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('asset/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('asset/datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/toastr/toastr.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('asset/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">


    <script src="{{ asset('asset/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('asset/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('asset/toastr/toastr.min.js') }}"></script>
    <title>@yield('title')</title>
    @yield('script')
    @yield('css')
</head>
