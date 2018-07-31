<script src="{{ asset(config('admin.public-js-css').'js/jquery.min.js') }}"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
$.widget.bridge('uibutton', $.ui.button);</script>

<script src="{{ asset(config('admin.public-js-css').'plugins/bootstrap/dist/js/bootstrap.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/bootstrap-toastr/toastr.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/jquery-sparkline/dist/jquery.sparkline.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/fastclick/lib/fastclick.js') }}"  type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'dist/js/adminlte.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('admin.public-js-css').'plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>

@yield('js')

<script>
@if (Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
@endif
@if (Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
@endif
</script>