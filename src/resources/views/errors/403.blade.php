@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 403 </h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! don’t have permission to access this resource.</h3>

            <p>
               I’m sorry. I know who you are–I believe who you say you are–but you just don’t have permission to access this resource.
            </p>

        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->

@endsection