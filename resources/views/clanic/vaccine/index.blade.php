@extends('lab_layouts.app')
@section('title', __( 'vaccine.vaccines' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'vaccine.vaccines' )
        <small>@lang( 'vaccine.manage_your_vaccines' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'vaccine.all_your_vaccines' )])
        @can('vaccine.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\VaccineController@create')}}" 
                        data-container=".vaccine_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('vaccine.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="vaccine_table">
                    <thead>
                        <tr>
                            <th>@lang( 'vaccine.name' )</th>
                            
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade vaccine_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
