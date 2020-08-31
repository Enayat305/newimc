@extends('lab_layouts.app')
@section('title', __('Patients'))


@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'patient.patient' )
        <small>@lang( 'patient.manage_your_patient' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'patient.all_your_patients' )])
        @can('diet.create')
            @slot('tool')
                <div class="box-tools">
                    
                        <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Lab\PatientController@create')}}" 
                        data-container=".patient_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('diet.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="patient_table">
                    <thead>
                        <tr>
                            
                            <th>@lang('messages.action')</th>
                             <th>@lang('patient.patient_id')</th>
                          <th>@lang('patient.name')</th>
                            <th>@lang('patient.mobile')</th>
                            <th>@lang('business.email')</th>
                            <th>@lang('patient.gender')</th>
                            <th>@lang('patient.age')</th>
                            <th>@lang('patient.marital_status')</th>
                            <th>@lang('patient.blood_group')</th>
                            <th>@lang('business.address')</th> 
                           
                        
           
                     
                       
                        </tr>
                    </thead>
                </table>
                
                  
            </div>
        @endcan
    @endcomponent

    <div class="modal fade patient_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
</div>

</section>
<!-- /.content -->

@endsection

