@extends('admin::layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 401 </h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! unauthorized access.</h3>

            <p>
               I’m sorry. you are have unauthorized person to access this resource.
            </p>

        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->

@endsection