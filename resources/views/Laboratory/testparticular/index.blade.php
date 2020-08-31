@extends('lab_layouts.app')
@section('title', __('test.test_particular'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('test.test_particular')
        <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content no-print">


    @component('components.widget', ['class' => 'box-primary', 'title' => __('test.all_your_test_particular')])
        @can('testparticular.create')
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="{{action('Lab\TestParticularController@create')}}">
                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                </div>
            @endslot
        @endcan
        @can('testparticular.view')
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="test_particulars_table">
                <thead>
                    <tr>
                        <th>@lang( 'messages.action' )</th>
                        <th>@lang( 'Report Heads' )</th>
                        <th>@lang( 'Test Particulars' )</th>
         
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