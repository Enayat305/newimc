@extends('lab_layouts.app')
@section('title', __( 'nonpathologicalhistory.nonpathologicalhistorys' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'nonpathologicalhistory.nonpathologicalhistorys' )
        <small>@lang( 'nonpathologicalhistory.manage_your_nonpathologicalhistorys' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'nonpathologicalhistory.all_your_nonpathologicalhistorys' )])
        @can('nonpathologicalhistory.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\NonPathologicalHistoryController@create')}}" 
                        data-container=".nonpathologicalhistory_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('nonpathologicalhistory.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="nonpathologicalhistory_table">
                    <thead>
                        <tr>
                            <th>@lang( 'nonpathologicalhistory.name' )</th>
                            
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade nonpathologicalhistory_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
