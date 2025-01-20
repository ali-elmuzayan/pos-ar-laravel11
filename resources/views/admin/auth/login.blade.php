<!DOCTYPE html>
<html dir="rtl">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{asset('uploads/no-logo.png')}}" type="image/icon type">
    <title>erp system | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins')}}/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins')}}/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist')}}/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo mt-5">
    <a href=""><b>نظام</b> مبيعات </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg mb-3">قم بتسجيل الدخول</p>



        <form action="{{route('login.store')}}" method="post">
          @csrf
            <div class="form-group mb-3">
        <div class="input-group ">

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <input type="text" name="username" class="form-control" placeholder="اسم المستخدم" required>
            </div>
            @error('username') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <input type="password" name="password" class="form-control" placeholder="كلمة السر" required>
        </div>
            @error('password') <span class=" text-danger">{{$message}}</span> @enderror
        <div class="row justify-content-between align-items-center">

          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">تسجيل الدخول</button>
          </div>
          <!-- /.col -->
            <div class="col-6">
                <p class="mb-1 float-left">
                    <a href="#">نسيت كلمة المرور</a>
                </p>
            </div>

        </div>
      </form>


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins')}}/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
