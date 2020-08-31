@extends('lab_layouts.app')
@section('title', __( 'department.departments' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'department.departments' )
        <small>@lang( 'department.manage_your_departments' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'department.all_your_departments' )])
        @can('lab_department.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\DepartmentController@create')}}" 
                        data-container=".department_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('lab_department.view')
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="departments_table">
                <thead>
                    <tr>
                        <th>@lang( 'department.departments' )</th>
                        <th>@lang( 'department.short_description' )</th>
                        <th>@lang( 'messages.action' )</th>
                    </tr>
                </thead>
            </table>
        </div>
        @endcan
    @endcomponent

    <div class="modal fade department_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
