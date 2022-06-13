<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<body class="hold-transition sidebar-mini" style="background-color: #eeeeee">
<div class="wrapper">
<!-- Site wrapper -->
@include('layout.navbar')
@include('layout.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="padding: 20px">

        @yield('padding page')
    <!-- /.content -->
    </div>
@include('layout.footer')
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('asset/dist/js/adminlte.min.js')}}"></script>
<script>
    @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.error("{{ session('error') }}");
    @endif
</script>
</body>
</html>
