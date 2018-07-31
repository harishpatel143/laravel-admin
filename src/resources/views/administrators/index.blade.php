@extends('admin::layouts.app')
@section('content')

<section class="content-header">
    <h1>Admins</h1>    
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">                    
                    @if (Multidots\Admin\Traits\CheckRolePermission::hasAccess('add-administrator')) 
                    <a href="{{ route('administrators-add') }}" class="btn btn-primary pull-right" title="Add Administrator">
                        <i class="fa fa-plus"></i> Add Admin
                    </a>   
                    @endif
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="administrator-list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0">
                            <thead>
                                <tr class="heading">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control form-filter input-sm" name="first_name" id="first_name"></td>
                                    <td><input type="text" class="form-control form-filter input-sm" name="username" id="username"></td>
                                    <td><input type="text" class="form-control form-filter input-sm" name="email" id="email"></td>
                                    <td>
                                        {{ Form::select('role', $roles, null, ["id" => "role", 'placeholder' => 'Select Role', 'class' => 'form-control form-filter-dropdown']) }}
                                    </td>
                                    <td>
                                        {{ Form::select('status', $statusList, null, ["id" => "status", 'class' => 'form-control form-filter-dropdown']) }}
                                    </td>                              
                                    <td>                                    
                                        <button class="btn btn-sm btn-default filter-submit" title="Search"><i class="fa fa-search"></i> <?= __('Search'); ?></button>
                                        <button class="btn btn-sm btn-default filter-cancel" title="Reset"><i class="fa fa-times"></i> <?= __('Reset'); ?></button>
                                    </td>                                
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
@endsection

@section('css')
{{ Html::style(config('admin.public-js-css').'/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'/plugins/select2/js/select2.full.min.js') }}
{{ Html::script(config('admin.public-js-css').'/plugins/datatables.net/js/jquery.dataTables.min.js') }}
{{ Html::script(config('admin.public-js-css').'/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
{{ Html::script(config('admin.public-js-css').'/js/datatables-ajax.js') }}

@endSection