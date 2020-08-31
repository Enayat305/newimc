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
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'schedule.all_your_appointment' )])
        @can('diet.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-primary" id="add_new_appointment_btn"><i class="fa fa-plus"></i> @lang('schedule.add_new_appointment')</button>

                </div>
            @endslot
        @endcan
        @can('diet.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="appointment_table">
                    <thead>
                        <tr>
                            <th>@lang( 'messages.action' )</th>
                            <th>@lang( 'schedule.doctor_name' )</th>
                            <th>@lang( 'schedule.patient_name' )</th>
                            <th>@lang( 'schedule.appointment_id' )</th>
                            <th>@lang( 'schedule.sequence' )</th>
                            <th>@lang( 'Token No' )</th>
                            <th>@lang( 'schedule.status' )</th>
                            <th>@lang( 'schedule.fee_status' )</th>
                            <th>@lang( 'schedule.date_time' )</th>
                            <th>@lang( 'schedule.note' )</th>
                            <th>@lang( 'schedule.add_user' )</th>
                                           
                            
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
@include('clanic/appointment.create')

<div class="modal fade patient_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('clanic/patient.create', ['quick_add' => true])
</div>
@endsection

@section('javascript')
    
    <script type="text/javascript">

        $(document).ready(function(){

            
    $(document).on('click', '.add_new_customer', function() {
        $('#patient_dropdown').select2('close');
        var name = $(this).data('name');
        $('.patient_modal')
            .find('input#name')
            .val(name);

        $('.patient_modal').modal('show');
    });
    $('form#quick_add_patient')
        .submit(function(e) {
            e.preventDefault();
        })
        .validate({
            rules: {
                contact_id: {
                    remote: {
                        url: '/lab/contacts/check-contact-id',
                        type: 'post',
                        data: {
                            contact_id: function() {
                                return $('#contact_id').val();
                            },
                            hidden_id: function() {
                                if ($('#hidden_id').length) {
                                    return $('#hidden_id').val();
                                } else {
                                    return '';
                                }
                            },
                        },
                    },
                },
            },
            messages: {
                contact_id: {
                    remote: LANG.contact_id_already_exists,
                },
            },
            submitHandler: function(form) {
                $(form)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                var data = $(form).serialize();
                $.ajax({
                    method: 'POST',
                    url: $(form).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('select#patient_dropdown').append(
                                $('<option>', { value: result.data.id, text: result.data.name })
                            );
                            $('select#patient_dropdown')
                                .val(result.data.id)
                                .trigger('change');
                            $('div.patient_modal').modal('hide');
                            toastr.success(result.msg);
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            },
        });
    $('.patient_modal').on('hidden.bs.modal', function() {
        $('form#quick_add_patient')
            .find('button[type="submit"]')
            .removeAttr('disabled');
        $('form#quick_add_patient')[0].reset();
    });
            $('button#add_new_appointment_btn').click( function(){
                $('div#add_appointment_modal').modal('show');
            });
            
            var appointment_table = $('#appointment_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url:'/lab/appointment',
          data: function(d) {
                if ($('#doctor_filter_id').length) {
                    d.location_id = $('#doctor_filter_id').val();
                }
                if ($('#patient_filter_id').length) {
                    d.patient_id = $('#patient_filter_id').val();
                    
                }
             
                if ($('#appointment_list_filter_status').length) {
                    d.status = $('#appointment_list_filter_status').val();
                    
                }

                var start = '';
                var end = '';
                if ($('#appointment_list_filter_date_range').val()) {
                    start = $('input#appointment_list_filter_date_range')
                        .data('daterangepicker')
                        
                        .startDate.format('YYYY-MM-DD');
   
                    end = $('input#appointment_list_filter_date_range')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;

                d = __datatable_ajax_callback(d);
            },
        },
        columns: [
            { data: 'action', name: 'action', searchable: false, orderable: false },
            { data: 'doctor_id', name: 'doctor_id' , searchable: false, orderable: false},
            { data: 'name', name: 'pat.name' },
            { data: 'appointment_id', name: 'appointment_id' },
            { data: 'sequence', name: 'sequence' },
            { data: 'token_no', name: 'token_no' },
            { data: 'status', name: 'status' },
            { data: 'fee_status', name: 'fee_status' },
            { data: 'get_date_time', name: 'get_date_time' },
            { data: 'note', name: 'note' },
            { data: 'user_id', name: 'user_id' , searchable: false, orderable: false}
            
           
        ],
        aaSorting: [
            [1, 'desc']
        ],
    });
            $('form#appointment_edit_form #start_time').datetimepicker({
                format: 'LT',
                
                ignoreReadonly: true
            });
            $(document).on(
        'change',
        '#doctor_filter_id, \
                    #patient_filter_id,\
                     #appointment_list_filter_status',
        function() {
            appointment_table.ajax.reload();
        }
    );
            //If location is set then show tables.

           
         
 
            $('#appointment_list_filter_date_range').daterangepicker(
        dateRangeSettings,
        
        function (start, end) {
            $('#appointment_list_filter_date_range')
            .val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            
           appointment_table.ajax.reload();
        }
    );
    $('#appointment_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#appointment_list_filter_date_range').val('');
        appointment_table.ajax.reload();
    });

            $('form#appointment_add_form #date').datetimepicker({
                format: moment_date_format,
                
                ignoreReadonly: true
            });   
            $(document).on('change', '#doctor_dropdown', function() {
                  $.ajax({
                url: '/lab/get_schedule',
                type: 'GET',
                data: { date: $('#date').val(),doctor: $('#doctor_dropdown').val() },
                success: function(response)
                {
                    var container = $(".schedul");
                    container.html(response);
                }
            });
        });
        $(document).on('click', 'button.appointment_edit_button', function() {
        $('button#add_new_appointment_btn').click( function(){
                $('div#add_appointment_modal').modal('show');

            });
        $('div.appointment_edit_modal').load($(this).data('href'), function() {
            $(this).modal('show');
           
            $('form#appointment_edit_form #date').datetimepicker({
                format: moment_date_format,
                
                ignoreReadonly: true
            });  
            $('form#appointment_edit_form').submit(function(e) {
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
                            $('div.appointment_edit_modal').modal('hide');
                            toastr.success(result.msg);
                            appointment_table.ajax.reload();
                            window.location.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });
 
    $('#add_appointment_modal').on('shown.bs.modal', function (e) {
               
               $(this).find('select').each( function(){
                   if(!($(this).hasClass('select2'))){
                       $(this).select2({
                           dropdownParent: $('#add_appointment_modal'),
                           
                       });
                   }
               });
               booking_form_validator = $('form#appointment_add_form').validate({
                   submitHandler: function(form) {
                       $(form).find('button[type="submit"]').attr('disabled', true);
                       var data = $(form).serialize();

                       $.ajax({
                           method: "POST",
                           url: $(form).attr("action"),
                           dataType: "json",
                           data: data,
                           success: function(result){
                               if(result.success == true){

                                   $('div#add_appointment_modal').modal('hide');
                                   
                                   toastr.success(result.msg);
                                   appointment_table.ajax.reload();
                                    window.location.reload();
                               } else {
                                   toastr.error(result.msg);
                                  
                               }
                               $(form).find('button[type="submit"]').attr('disabled', false);
                           }
                       });
                   }
               });
           });
           
            $(document).on('click', 'a.appointment_delete_button', function(){
            swal({
              title: LANG.sure,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        success: function(result){
                            if(result.success == true){ 
                                toastr.success(result.msg);
                                appointment_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });

        });
       

    
    

    

    </script>
@endsection
