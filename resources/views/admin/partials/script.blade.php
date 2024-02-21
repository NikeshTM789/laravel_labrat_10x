<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE-3.2.0/dist/js/demo.js') }}"></script>
<script src="{{ asset('packages/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('assets/js/custom.js') }}"></script>

@stack('pre-js')

@if (session('success'))
<script>
	success("{{ session('success') }}");
</script>
@elseif(session('error'))
<script>
	error("{{ session('error') }}");
</script>
@elseif(session('info'))
<script>
	error("{{ session('error') }}");
</script>
@endif

@stack('post-js')