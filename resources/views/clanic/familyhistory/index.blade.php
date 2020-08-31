@extends('lab_layouts.app')
@section('title', __( 'familyhistory.familyhistorys' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'familyhistory.familyhistorys' )
        <small>@lang( 'familyhistory.manage_your_familyhistorys' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'familyhistory.all_your_familyhistorys' )])
        @can('familyhistory.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\FamilyHistoryController@create')}}" 
                        data-container=".familyhistory_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('familyhistory.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="familyhistory_table">
                    <thead>
                        <tr>
                            <th>@lang( 'familyhistory.name' )</th>
                            
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade familyhistory_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
