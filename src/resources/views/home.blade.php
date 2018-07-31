@extends('admin::layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Dashboard</h1>    
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">            
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $users ?? '-'}}</h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>        

        <div class="col-lg-3 col-xs-6">            
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $totalAdministrator ?? '-'}}</h3>
                    <p>Administrators</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>        
    </div>    
    <!-- Small boxes end -->
</section>
<!-- End content -->
@endsection
