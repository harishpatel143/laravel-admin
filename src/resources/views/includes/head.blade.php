<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ 'Laravel-admin' }} | {{ config('admin.name') }} </title>

<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/font-awesome/css/font-awesome.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/Ionicons/css/ionicons.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/select2/css/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/bootstrap-toastr/toastr.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/iCheck/square/blue.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'dist/css/AdminLTE.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'dist/css/skins/_all-skins.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'css/custom.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset(config('admin.public-js-css').'plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" type="text/css"/>  
@yield('css')

<script> var routePrefix = 'admin';</script>