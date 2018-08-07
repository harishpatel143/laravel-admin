<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        @include('admin::includes.head')        
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="form-loader"></div>
        <div id="app" class="wrapper">
            <!-- Include Header-->
            <header class="main-header">
                @include('admin::includes.header')
            </header>            
            <!-- End Header-->
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                @include('admin::includes.sidebar')
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                @include('admin::includes.footer')
            </footer>
        </div>
        <script type="text/javascript">var prefix = "{{ config('app.ADMIN_CONST.ADMIN_PREFIX')}}";</script>
        @include('admin::includes.footer_js')
    </body>
</html>
