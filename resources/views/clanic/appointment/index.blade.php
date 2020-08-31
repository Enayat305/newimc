@extends('lab_layouts.app')
@section('title', __('schedule.appointment'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'schedule.appointment' )</h1>
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
        {!! Form::label('appointment_list_filter_date_range', __('report.date_range') . ':') !!}
        {!! Form::text('appointment_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('purchase_list_filter_payment_status',  __('purchase.payment_status') . ':') !!}
        {!! Form::select('purchase_list_filter_payment_status', ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial'), 'overdue' => __('lang_v1.overdue')], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
    </div>
</div>
@endcomponent


    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'schedule.all_your_appointment' )])
        @can('appointment.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-primary" id="add_new_appointment_btn"><i class="fa fa-plus"></i> @lang('schedule.add_new_appointment')</button>

                </div>
            @endslot
        @endcan
        @can('appointment.view')
        <div class="table-responsive">
            <table class="table table-bordered table-striped ajax_view" id="appointment_table">
                <thead>
                    <tr>
                        <th>@lang('messages.action')</th>
                        <th>@lang('messages.date')</th>
                        <th>@lang( 'schedule.doctor_name' )</th>
                        <th>@lang( 'schedule.patient_name' )</th>
                        <th>@lang( 'schedule.appointment_id' )</th>
                        <th>@lang( 'Token No' )</th>
                        <th>@lang( 'schedule.status')</th>
                        <th>@lang( 'schedule.fee_status' )</th>
                        <th>@lang('purchase.payment_status')</th>
                        <th>@lang('purchase.grand_total')</th>
                        <th>@lang('purchase.payment_due') &nbsp;&nbsp;<i class="fa fa-info-circle text-info no-print" data-toggle="tooltip" data-placement="bottom" data-html="true" data-original-title="{{ __('messages.purchase_due_tooltip')}}" aria-hidden="true"></i></th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr class="bg-gray font-17 text-center footer-total">
                        <td colspan="6"><strong>@lang('sale.total'):</strong></td>
                        <td id="footer_status_count"></td>
                        <td id="footer_payment_status_count"></td>
                        <td><span class="display_currency" id="footer_purchase_total" data-currency_symbol ="true"></span></td>
                        <td class="text-left"><small>@lang('report.purchase_due') - <span class="display_currency" id="footer_total_due" data-currency_symbol ="true"></span><br>
                        @lang('lang_v1.purchase_return') - <span class="display_currency" id="footer_total_purchase_return_due" data-currency_symbol ="true"></span>
                        </small></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endcan
    @endcomponent
<!-- /.content -->
<div class="modal fade product_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>
<div class="modal fade appointment_edit_modal" tabindex="-1" role="dialog" 
aria-labelledby="gridSystemModalLabel">
</div>
@include('clanic/appointment.create')

<div class="modal fade patient_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('clanic/patient.create', ['quick_add' => true])
</div>



<!-- /.content -->
@stop
@section('javascript')
<script src="{{ asset('js/labappointment.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/labpayment.js?v=' . $asset_v) }}"></script>
<script>
    
    $(document).on('click', '.update_status', function(e){
        e.preventDefault();
        $('#update_purchase_status_form').find('#status').val($(this).data('status'));
        $('#update_purchase_status_form').find('#purchase_id').val($(this).data('purchase_id'));
        $('#update_purchase_status_modal').modal('show');
    });

    $(document).on('submit', '#update_purchase_status_form', function(e){
        e.preventDefault();
        $(this)
            .find('button[type="submit"]')
            .attr('disabled', true);
        var data = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result.success == true) {
                    $('#update_purchase_status_modal').modal('hide');
                    toastr.success(result.msg);
                    appointment_table.ajax.reload();
                    $('#update_purchase_status_form')
                        .find('button[type="submit"]')
                        .attr('disabled', false);
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
</script>
	
@endsection