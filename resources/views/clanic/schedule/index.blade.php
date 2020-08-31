@extends('lab_layouts.app')
@section('title', __('schedule.schedule'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'schedule.schedule' )</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'schedule.all_your_schedule' )])
        @can('diet.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-primary" id="add_new_schedule_btn"><i class="fa fa-plus"></i> @lang('schedule.add_new_schedule')</button>

                </div>
            @endslot
        @endcan
        @can('diet.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="schedule_table">
                    <thead>
                        <tr>
                            <th>@lang( 'messages.action' )</th>
                            <th>@lang( 'schedule.doctor_name' )</th>
                            <th>@lang( 'schedule.day' )</th>
                            <th>@lang( 'schedule.start_time' )</th>
                            <th>@lang( 'schedule.end_time' )</th>
                            <th>@lang( 'schedule.perpatienttime' )</th>
                            
                           
                            
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

<!-- /.content -->
<div class="modal fade schedule_edit_modal" tabindex="-1" role="dialog" 
aria-labelledby="gridSystemModalLabel">
</div>
@include('clanic/schedule.create')


@endsection

@section('javascript')
    
    <script type="text/javascript">
    $(document).on('click', 'button.schedule_edit_button', function() {
      
        $('div.schedule_edit_modal').load($(this).data('href'), function() {
            $(this).modal('show');
            $('#start_time,#end_time').datetimepicker({
                format: 'LT',
                
                ignoreReadonly: true
            
            });
          
            $('form#schedule_edit_form').submit(function(e) {
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
                            $('div.schedule_edit_modal').modal('hide');
                            toastr.success(result.msg);
                            schedule_table.ajax.reload();
                           
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });
        $(document).ready(function(){
            
        var schedule_table = $('#schedule_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/lab/schedule',

        columns: [
            { data: 'action', name: 'action' },
            { data: 'doctor_id', name: 'doctor_id' },
            { data: 'day', name: 'day' },
            { data: 'start_time', name: 'start_time' },
            { data: 'end_time', name: 'end_time' },
            { data: 'per_patient_time', name: 'per_patient_time' }
           
        ],
    });
            
            $('form#schedule_edit_form #start_time').datetimepicker({
                format: 'LT',
                
                ignoreReadonly: true
            });

            //If location is set then show tables.

            $('#add_schedule_modal').on('shown.bs.modal', function (e) {
               
                $(this).find('select').each( function(){
                    if(!($(this).hasClass('select2'))){
                        $(this).select2({
                            dropdownParent: $('#add_schedule_modal')
                        });
                    }
                });
                booking_form_validator = $('form#add_booking_form').validate({
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

                                    $('div#add_schedule_modal').modal('hide');
                                    toastr.success(result.msg);
                                    schedule_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                                $(form).find('button[type="submit"]').attr('disabled', false);
                            }
                        });
                    }
                });
            });
            $('#add_schedule_modal').on('hidden.bs.modal', function (e) {
                booking_form_validator.destroy();
                reset_booking_form();
            });

            $('form#add_booking_form #start_time').datetimepicker({
                format: 'LT',
                
                ignoreReadonly: true
            });
            
            $('form#add_booking_form #end_time').datetimepicker({
                format: 'LT',
                ignoreReadonly: true,
            });     

            $('button#add_new_schedule_btn').click( function(){
                $('div#add_schedule_modal').modal('show');
            });
            $(document).on('click', 'button.schedule_diet_button', function(){
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
                                schedule_table.ajax.reload();
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
