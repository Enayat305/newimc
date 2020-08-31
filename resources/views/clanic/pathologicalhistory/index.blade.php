@extends('lab_layouts.app')
@section('title', __( 'pathologicalhistory.pathologicalhistorys' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'pathologicalhistory.pathologicalhistorys' )
        <small>@lang( 'pathologicalhistory.manage_your_pathologicalhistorys' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'pathologicalhistory.all_your_pathologicalhistorys' )])
        @can('pathologicalhistory.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\PathologicalHistoryController@create')}}" 
                        data-container=".pathologicalhistory_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('pathologicalhistory.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="pathologicalhistory_table">
                    <thead>
                        <tr>
                            <th>@lang( 'pathologicalhistory.name' )</th>
                            
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade pathologicalhistory_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
