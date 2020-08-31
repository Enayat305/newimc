@extends('lab_layouts.app')
@section('title', __( 'phychiatrichistory.phychiatrichistorys' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'phychiatrichistory.phychiatrichistorys' )
        <small>@lang( 'phychiatrichistory.manage_your_phychiatrichistorys' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'phychiatrichistory.all_your_phychiatrichistorys' )])
        @can('phychiatrichistory.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\PhychiatricHistoryController@create')}}" 
                        data-container=".phychiatrichistory_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('phychiatrichistory.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="phychiatrichistory_table">
                    <thead>
                        <tr>
                            <th>@lang( 'phychiatrichistory.name' )</th>
                            
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade phychiatrichistory_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
