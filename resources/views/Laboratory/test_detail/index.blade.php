@extends('lab_layouts.app')
@section('title', __('test.test'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('test.test')
        <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content no-print">
    @component('components.filters', ['title' => __('report.filters')])
 
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('department_id', __('test.department') . ':') !!}
                {!! Form::select('department_id', $department, null, ['placeholder' => __('lang_v1.all'), 'class' => 'form-control select2 ','required']); !!}            </div>
        </div>
       
    @endcomponent

    @component('components.widget', ['class' => 'box-primary', 'title' => __('test.all_your_test')])
        @can('test.create')
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="{{action('Lab\TestController@create')}}">
                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                </div>
            @endslot
        @endcan
        @can('test.view')
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="test_table">
                <thead>
                    <tr>
                        <th>@lang( 'messages.action' )</th>
                        <th>@lang( 'test.test_name' )</th>
                        <th>@lang( 'test.test_code' )</th>
                        <th>@lang( 'department.departments' )</th>
                        <th>@lang( 'test.sample_require' )</th>
                        <th>@lang( 'test.charges' )</th>
                        <th>@lang( 'Type' )</th>
                        <th>@lang( 'test.report_time_day' )</th>        
                    </tr>
                </thead>
            </table>
        </div>
        @endcan
    @endcomponent
   
</section>

<section id="receipt_section" class="print_section"></section>

<!-- /.content -->
@stop
@section('javascript')
@endsection