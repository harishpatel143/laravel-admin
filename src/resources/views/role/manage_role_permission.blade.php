@extends('admin::layouts.app')

@section('content')

@php
$__existingPermissions = [];
@endphp


<section class="content-header">
    <h1>Manage Permissions</h1>    
</section>


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    @if (Multidots\Admin\Traits\CheckRolePermission::hasAccess('roles-listing')) 
                    <a class="btn btn-default pull-right" href="{{ route('roles',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" title="Back">
                        <i class="fa fa-mail-reply"></i> Back
                    </a>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->                
                {!! Form::open(['name' => 'manage-role-permission', 'id' => 'manage-role-permission', 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-6">
                            @php
                            $__existingPermissions = !empty($assignedRolePermissions['Permissions']) ? $assignedRolePermissions['Permissions'] : [];
                            @endphp
                            @if (!empty($permissionList))
                            @foreach ($permissionList as $permission)
                            @php
                            $checked = array_key_exists($permission['id'], $__existingPermissions) ? 'checked' : '';
                            @endphp
                            <div class="row">
                                <div class="checkbox">
                                    <ul class="list-unstyled main-ul">
                                        <li>
                                            <label><input type="checkbox" name="permissions[]" value="{{ $permission['id'] }}" class="m-checkbox--all" {{ $checked }} style="cursor:pointer"><strong>{{ $permission['title'] }}</strong></label>
                                            @if (!empty($permission['childrens']))
                                            @foreach ($permission['childrens'] as $childPermission)
                                            @php
                                            $checked = array_key_exists($childPermission['id'], $__existingPermissions) ? 'checked' : '';
                                            @endphp
                                            <ul class="list-unstyled">
                                                <li><label><input type="checkbox" name="permissions[]" value="{{ $childPermission['id'] }}" class="child-checkbox" {{ $checked }} style="cursor:pointer">{{ $childPermission['title'] }}</label></li>
                                            </ul>
                                            @endforeach        
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach    
                            @else
                            <div class="alert alert-block alert-error">No permissions are available.</div>
                            @endif

                        </div>    
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i>  Save </button>
                        @if (Multidots\Admin\Traits\CheckRolePermission::hasAccess('roles-listing')) 
                        <a href="{{ route('roles',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" class="btn btn-default pull-right margin-r-5" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel </a>
                        @endif
                    </div>
                    <!-- /.box-footer -->
                    {!! Form::close() !!}
                </div>    
            </div>
        </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('.m-checkbox--all').on('click', function () {
            if (this.checked) {
                $(this).parentsUntil('.list-unstyled').find('.child-checkbox').parent().addClass('checked');
                $(this).parentsUntil('.list-unstyled').find('.child-checkbox').prop('checked', true);
            } else {
                $(this).parentsUntil('.list-unstyled').find('.child-checkbox').parent().removeClass('checked');
                $(this).parentsUntil('.list-unstyled').find('.child-checkbox').prop('checked', false);
            }
        });
        $('.child-checkbox').on('click', function () {
            if (this.checked === false) {
                $(this).parentsUntil('.main-ul').find('.m-checkbox--all').parent().removeClass('checked');
                $(this).parentsUntil('.main-ul').find('.m-checkbox--all').prop('checked', false);
            }
        })
    });
</script>
@endSection