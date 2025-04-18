<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" href="{{asset($setting->logo) ? asset($setting->logo) : asset('uploads/no-logo.png')}}" type="image/icon type">

  <title>@yield('title')</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset("dist/css/adminlte.min.css")}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset("fonts/SansPro/SansPro.min.css")}}">
  <link rel="stylesheet" href="{{asset("css/bootstrap_rtl-v4.2.1/bootstrap.min.css")}}">
  <link rel="stylesheet" href="{{asset("css/bootstrap_rtl-v4.2.1/custom_rtl.css")}}">
  <link rel="stylesheet" href="{{asset("css/mycustomstyle.css")}}">
@stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
    @include('admin.includes.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('admin.includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
    @include('admin.includes.content')
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
    @include('admin.includes.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("dist/js/adminlte.min.js")}}"></script>

{{--  for a specific action --}}
<script src="{{asset("js/actions.js")}}"></script>
{{-- routes --}}
<script>
    const posRoute = "{{route('pos.index')}}";
    const orderRoute = "{{route('orders.index')}}";
    const categoryRoute = "{{route('categories.index')}}";
    const categories = "{{route('categories.index')}}";
</script>
@stack('js')
</body>
</html>
