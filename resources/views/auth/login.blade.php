<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>تسجيل الدخول </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('asset/index/assets/img/logo.png')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('asset/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('asset/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <div class="row justify-content-center">
          <h2> <b>تسجيل الدخول</b> </h2>
      </div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div class="row justify-content-center mr-2">
       <!-- <img src="{{asset('asset/index/assets/img/logo.png')}}" height="200px"  width="250px">-->

        </div>
        @include('massege')
        <form class=" mr-auto" action="{{route('authenticate')}}" method="post">
            @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="اسم المستخدم"  name="user_name" required value="{{old('user_name')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="كلمة السر" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

        </div>
          <br>
          <div class="row">

              <button type="submit" class="btn btn-primary btn-block">تسجيل دخول</button>

              <!-- /.col -->
          </div>
            <br />


      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="asset/dist/js/adminlte.min.js"></script>

</body>
</html>
