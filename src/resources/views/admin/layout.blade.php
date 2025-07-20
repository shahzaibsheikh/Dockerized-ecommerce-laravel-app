<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Dashboard - LearnVern Store Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet"/>
    <link href="{{asset('admin_assests').'/css/styles.css'}}" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    @include('admin.layout_partials.header')
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    @include('admin.layout_partials.sidebar_navigation')
  </div>
  <div id="layoutSidenav_content">
    @yield('content')
    @include('admin.layout_partials.footer')
  </div>
</div>

</body>
</html>