<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>
  <?php $layout = 'admin.partials.'; ?>
  @include($layout.'style')
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  @include($layout.'nav')

  @include($layout.'sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  @include($layout.'breadcrumb')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  @include($layout.'footer')

</div>
<!-- ./wrapper -->

@include($layout.'script')

</body>
</html>
