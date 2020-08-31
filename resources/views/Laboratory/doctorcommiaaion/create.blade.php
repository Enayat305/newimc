@extends('lab_layouts.app')
@section('title', __('Doctor commisssion'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('Doctor commisssion') <i class="fa fa-keyboard-o hover-q text-muted" aria-hidden="true" data-container="body" data-toggle="popover" data-placement="bottom" data-content="@include('purchase.partials.keyboard_shortcuts_details')" data-html="true" data-trigger="hover" data-original-title="" title=""></i></h1>
</section>

<!-- Main content -->
<section class="content">

	@include('layouts.partials.error')

	{!! Form::open(['url' => action('Lab\DoctorCommissionController@store'), 'method' => 'post', 'id' => 'add_purchase_form', 'files' => true ]) !!}
	@component('components.widget', ['class' => 'box-primary'])
	<div class="row">
		<div class="col-sm-2">
			<div class="form-group">
			{!! Form::label('status', __('Start Date') . ':*') !!}
					<div class='input-group date' >
					<span class="input-group-addon">
						  <span class="glyphicon glyphicon-time"></span>
					  </span>
			  {!! Form::text('start-date', null, ['class' => 'form-control','placeholder' => __( 'Start Date' ), 'required', 'id' => 'startdate',]); !!}
			  </div>
			</div>
		  </div>
		  <div class="col-sm-2">
			<div class="form-group">
			{!! Form::label('status', __('End Date') . ':*') !!}
					<div class='input-group date' >
					<span class="input-group-addon">
						  <span class="glyphicon glyphicon-time"></span>
					  </span>
			  {!! Form::text('end-date', null, ['class' => 'form-control','placeholder' => __( 'End Date' ), 'required', 'id' => 'enddate',]); !!}
			  </div>
			</div>
		  </div>

		  <div class="col-sm-2">
			<div class="form-group">
			{!! Form::label('status', __('Commission %') . ':*') !!}
					<div class='input-group date' >
					<span class="input-group-addon">
						  <span class="">%</span>
					  </span>
			  {!! Form::text('comm', null, ['class' => 'form-control input_number','placeholder' => __( 'comm %' ), 'required', 'id' => 'comm',]); !!}
			  </div>
			</div>
		  </div>
		  <div class="col-sm-3">
			<div class="form-group">
				{!! Form::label('carry_out', __('Test Type') . ':*') !!}
			  <div class="input-group">
				<span class="input-group-addon">
				  <i class="fa fa-check-square"></i>
				</span>
				{!! Form::select('type', ['Special' => __('Special'), 'Routine' => __('Routine')],null, ['placeholder' => __('messages.please_select'),'class' => 'form-control', 'id' => 'test-type','required' ]); !!}
		
			  </div>
			</div>
		  </div>
		<div class="col-sm-3">
		  <div class="form-group">
			{!! Form::label('status', __('schedule.doctor') . ':*') !!}
  
			<div class="input-group">
			  <span class="input-group-addon">
				<i class="fa fa-user-md"></i>
			  </span>
			  {!! Form::select('ref_by', $doctor,null , ['class' => 'form-control select2','style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'doctor_dropdown']); !!}
			</div>
		  </div>
		</div>
	</div>
        
	<div class="row">
		<div class="col-sm-12">
			<button type="button" id="submit_commission_form" class="btn btn-primary pull-right btn-flat">@lang('Fillter')</button>
		</div>
	</div>


	<div class="schedul"></div>

	@endcomponent
	@component('components.widget', ['class' => 'box-primary', 'id' => "payment_rows_div", 'title' => __('purchase.add_payment')])
	<div class="payment_row">
		@include('sale_pos.partials.payment_row_form', ['row_index' => 0])
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-right">
					<strong>@lang('purchase.payment_due'):</strong>
					<span id="payment_due">{{@num_format(0)}}</span>
				</div>
			</div>
		</div>
	</div>
	@endcomponent

	<div class="col-sm-12">
		<button type="submit" class="btn btn-primary pull-right">@lang('messages.save')</button>
	</div>




{!! Form::close() !!}
</section>

<!-- /.content -->
@endsection

@section('javascript')
	{{-- <script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script> --}}
	<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
	@include('purchase.partials.keyboard_shortcuts')

	<script type="text/javascript">
		  $('#enddate,#startdate').datetimepicker({
        format: moment_date_format,

        ignoreReadonly: true
    });
    
	$(document).on('click', '#submit_commission_form', function() {
        $.ajax({
            url: '/lab/get_commission',
            type: 'GET',
            data: { start_date: $('#startdate').val(),type:$('#test-type').val(),end_date: $('#enddate').val(),comm: $('#comm').val(),doctor: $('#doctor_dropdown').val() },
            success: function(response) {
				
				var container = $(".schedul");
				container.html(response);
                //container.html(response.html_content);
            }
        });
    });

	$(document).on('change', 'input#final_total, input.payment-amount', function() {
		calculateExpensePaymentDue();
	});

	function calculateExpensePaymentDue() {
		var final_total = __read_number($('input#final_total'));
		var payment_amount = __read_number($('input.payment-amount'));
		var payment_due = final_total - payment_amount;
		$('#payment_due').text(__currency_trans_from_en(payment_due, true, false));
	}
	</script>
@endsection
