@extends('lab_layouts.app')
@section('title', __('Prescriptions'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'Prescriptions' )</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
@component('components.filters', ['title' => __('report.filters')])
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('patient_filter_id',  __('schedule.patients') . ':') !!}
        {!! Form::select('patient_filter_id', $customers, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id'=>'patient_filter_id','placeholder' => __('lang_v1.all')]); !!}
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('doctor_filter_id',  __('schedule.doctor') . ':') !!}
        {!! Form::select('doctor_filter_id', $doctor, null, ['class' => 'form-control select2', 'id'=>'doctor_filter_id','style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('appointment_list_filter_status',  __('schedule.status') . ':') !!}
        {!! Form::select('appointment_list_filter_status', $appointment_status, null, ['class' => 'form-control select2','id'=>'appointment_list_filter_status', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('appointment_list_filter_date_range', __('report.date_range') . ':') !!}
        {!! Form::text('appointment_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
    </div>
</div>
@endcomponent

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'All your Prescriptions' )])
        @can('diet.create')
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="{{action('Lab\PrescriptionController@create')}}">
                        <i class="fa fa-plus"></i> @lang('messages.add')</a>
                </div>
            @endslot
        @endcan
        @can('diet.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="pres_table">
                    <thead>
                        <tr>
                            <th>@lang( 'messages.action' )</th>
                            <th>@lang( 'schedule.doctor_name' )</th>
                            <th>@lang( 'schedule.patient_name' )</th>
                            <th>@lang( 'schedule.appointment_id' )</th>
                            <th>@lang( 'Token No' )</th>
                            <th>@lang( 'prescription.date' )</th>
                            <th>@lang( 'prescription.advice' )</th>
                            <th>@lang( 'prescription.note' )</th>
                            <th>@lang( 'prescription.weight' )</th>
                            <th>@lang( 'prescription.temperature' )</th>
                            
                                           
                            
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

<!-- /.content -->
<div class="modal fade appointment_edit_modal" tabindex="-1" role="dialog" 
aria-labelledby="gridSystemModalLabel">
</div>



@endsection

@section('javascript')
<script src="{{ asset('js/clanic.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
    </script>
@endsection
