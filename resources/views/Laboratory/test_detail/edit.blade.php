@extends('lab_layouts.app')
@section('title', __('test.edit_test'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('test.edit_test') <i class="fa fa-keyboard-o hover-q text-muted" aria-hidden="true" data-container="body" data-toggle="popover" data-placement="bottom" data-content="@include('purchase.partials.keyboard_shortcuts_details')" data-html="true" data-trigger="hover" data-original-title="" title=""></i></h1>
</section>

<!-- Main content -->
<section class="content">

	<!-- Page level currency setting -->
	<input type="hidden" id="p_code" value="{{$currency_details->code}}">
	<input type="hidden" id="p_symbol" value="{{$currency_details->symbol}}">
	<input type="hidden" id="p_thousand" value="{{$currency_details->thousand_separator}}">
	<input type="hidden" id="p_decimal" value="{{$currency_details->decimal_separator}}">

	@include('layouts.partials.error')
	{!! Form::open(['url' =>  action('Lab\TestController@update' , [$test->id] ), 'method' => 'PUT', 'id' => 'add_purchase_form', 'files' => true ]) !!}
	@component('components.widget', ['class' => 'box-primary'])
	<div class="row">
		<div class="col-sm-4">
		  <div class="form-group">
			{!! Form::label('name', __('test.test_name') . ':*') !!}
			  {!! Form::text('name',$test->name,['class' => 'form-control', 'required',
			  'placeholder' => __('test.test_name')]); !!}
		  </div>
		</div>

  {{-- <div class="col-sm-4">
	<div class="form-group">
	  {!! Form::label('test_code', __('test.test_code').':') !!}
	  {!! Form::text('test_code', $test->test_code, ['class' => 'form-control','readonly']); !!}
	</div>
  </div> --}}
  <div class="col-sm-4">
	<div class="form-group">
	  {!! Form::label('sample_require', __('test.sample_require') . ':') !!}
	  {!! Form::text('sample_require', $test->sample_require, ['class' => 'form-control','required',
		'placeholder' => __('test.sample_require')]); !!}
	</div>
  </div>
  <div class="clearfix"></div>
<div class="col-sm-4">
	<div class="form-group">
		{!! Form::label('carry_out', __('Test Type') . ':*') !!}
	  <div class="input-group">
		<span class="input-group-addon">
		  <i class="fa fa-check-square"></i>
		</span>
		{!! Form::select('carry_out', ['Special' => __('Special'), 'Routine' => __('Routine')],$test->carry_out, ['placeholder' => __('messages.please_select'),'class' => 'form-control', 'id' => 'type','required' ]); !!}

	  </div>
	</div>
  </div>
<div class="col-sm-4">
  <div class="form-group">
    {!! Form::label('report_time_day', __('test.report_time_day') . ':') !!} 
    {!! Form::text('report_time_day', $test->report_time_day, ['class' => 'form-control',
      'placeholder' => __('test.report_time_day')]); !!}
  </div>
</div>
<div class="col-sm-4">
  
    <div class="form-group">
      {!! Form::label('department_id', __('test.department') . ':') !!}
        {!! Form::select('department_id', $department, $test->department_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2 ','required']); !!}
    </div>

</div>
<div class="clearfix"></div>
<div class="col-sm-4">
	<div class="form-group">
	  {!! Form::label('description', __('test.test_description') . ':') !!}
		{!! Form::textarea('description',  $test->description, ['class' => 'form-control','id'=>'test_description']); !!}
	</div>
  </div>
  <div class="col-sm-4">
	<div class="form-group">
	  {!! Form::label('description', __('test.test_comment') . ':') !!}
		{!! Form::textarea('test_comment',$test->test_comment, ['class' => 'form-control','id'=>'test_comment']); !!}
	</div>
  </div>
  <div class="col-sm-4">
	<div class="form-group">
	    {!! Form::label('report_head', __('Link Report Heads') . ':') !!} @show_tooltip(__('Link Report Heads'))
		{!! Form::select('report_head[]',$report_head, $test->test_head->pluck('report_head_id'), ['class' => 'form-control select2', 'multiple', 'id' => 'product_locations']); !!}
	</div>
  </div>
	</div>
		

	@endcomponent

	@component('components.widget', ['class' => 'box-primary'])
	@if(count($business_locations) == 1)
	@php 
	  $default_location = current(array_keys($business_locations->toArray()));
	  $search_disable = false; 
	@endphp
  @else
	@php $default_location = null;
	$search_disable = true;
	@endphp
  @endif
  <div class="col-sm-3">
	<div class="form-group">
	  {!! Form::label('location_id', __('purchase.business_location').':*') !!}
	  @show_tooltip(__('tooltip.purchase_location'))
	  {!! Form::select('location_id', $business_locations, $default_location, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
	</div>
  </div>

	
	<div class="row">
	  <div class="col-sm-8 col-sm-offset-2">
	 
		<div class="form-group">
		  <div class="input-group">
			<span class="input-group-addon">
			  <i class="fa fa-search"></i>
			</span>
			{!! Form::text('search_product', null, ['class' => 'form-control mousetrap', 'id' => 'search_product', 'placeholder' => __('lang_v1.search_product_placeholder'), 'disabled']); !!}
		  </div>
		</div>
	
	  </div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			@include('Laboratory/test_detail.edit_purchase_entry_row')

		  <hr/>
		  <div class="pull-right col-md-5">
			<table class="pull-right col-md-12">
			  <tr>
				<th class="col-md-7 text-right">@lang( 'lang_v1.total_items' ):</th>
				<td class="col-md-5 text-left">
				  <span id="total_quantity" class="display_currency"></span>
				</td>
			  </tr>
			  <tr class="hide">
				<th class="col-md-7 text-right">@lang( 'purchase.total_before_tax' ):</th>
				<td class="col-md-5 text-left">
				  <span id="total_st_before_tax" class="display_currency"></span>
				  <input type="hidden" id="st_before_tax_input" value=0>
				</td>
			  </tr>
			  <tr>
				<th class="col-md-7 text-right">@lang( 'purchase.net_total_amount' ):</th>
				<td class="col-md-5 text-left">
				  <span id="total_subtotal" class="display_currency">{{$test->test_cast_amount}}</span>
				  <td class="hidden">
					<span class="row_subtotal_after_tax display_currency">{{$test->test_cast_amount}}</span>
					<input type="hidden" class="row_subtotal_after_tax_hidden" value={{$test->test_cast_amount}}>
				</td><!-- This is total before purchase tax-->
				  <input type="hidden" id="total_subtotal_input" value="{{$test->test_cast_amount}}" name="total_before_tax">
				</td>
			  </tr>
			</table>
		  </div>

		</div>
	</div>
	@endcomponent

	@component('components.widget', ['class' => 'box-primary', 'title' => __('')])
		<div class="box-body payment_row">
			<div class="col-md-4">
				<div class="form-group">
				<label for="amount_0">Test Cast Amount:*</label>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-money-bill-alt"></i>
					</span>
				<input class="form-control payment-amount input_number" readonly required="" id="amount_0" placeholder="Amount" name="test_cast_amount" type="text" value="{{$test->test_cast_amount}}">
				</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label for="amount_0">Add More Test Charge </label>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-money-bill-alt"></i>
					</span>
				<input class="form-control more-test-amount input_number " required  placeholder="Amount" name="more_amount" type="text" value="{{$test->more_amount}}">
				</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label for="amount_0">Total Amount:*</label>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-money-bill-alt"></i>
					</span>
				<input class="form-control total-amount input_number"  readonly required=""  placeholder="Amount" name="final_total" type="text" value="{{$test->final_total}}">
				</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					<button type="button" id="submit_purchase_form" class="btn btn-primary pull-right btn-flat">@lang('messages.save')</button>
				</div>
			</div>
		</div>
	@endcomponent

{!! Form::close() !!}
</section>

@endsection

@section('javascript')
	<script src="{{ asset('js/lab.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
	@include('purchase.partials.keyboard_shortcuts')

	<script type="text/javascript">
			    if ($('textarea#test_comment,textarea#test_description').length > 0) {
        tinymce.init({
            selector: 'textarea#test_comment',
            height:250
        });
    }
        $('.cancel').click(function(){
  		location.reload();
	 	$('#edit_test_examination').hide();
        $('#add_test_examination').show();
        $('input').val('');
})
$('a .remove_micro').on('click', function(e) {
	alert('hh');
		// $(this).parent().parent().remove();
});
$('.add_macroscopic .remove_macro').on('click', function(e) {
	alert('hh');
		// $(this).parent().parent().remove();
});

     $(document).on('click', '.edit_test_examination', function() {
        var stuff = $(this).data('info').split(',');
        var microscopic = $(this).data('microscopic');
        var macroscopic = $(this).data('macroscopic');

        	for (i = 0; i < microscopic.length; i++) { 
        		$('.add_microscopic').append("<tr class='add_more_microscopic'><td><div class='input-group'><input type='text' name='microscopic[]' value='"+ microscopic[i] +"' class='form-control input-md' required=''><span class='input-group-btn'><a class='btn btn-sm btn-danger remove_micro'><span class='glyphicon glyphicon-remove'></span></a></span></td></tr>");
        	}

        	for (i = 0; i < macroscopic.length; i++) {
        		$('.add_macroscopic').append("<tr class='add_more_macroscopic'><td><div class='input-group'><input type='text' name='macroscopic[]' value='"+ macroscopic[i] + "' class='form-control' required=''><span class='input-group-btn'><a class='btn btn-sm btn-danger remove_macro'><span class='glyphicon glyphicon-remove'></span></a></span></td></tr>");
			}
        $('#id_test_examination').val(stuff[0]);
        $('#test_examination_id').val(stuff[1]);

        $('#edit_test_examination').show();
        $('#add_test_examination').hide();

        $('.add_microscopic .remove_micro').on('click', function() {
        	$(this).parent().parent().remove();
        });

         $('.add_macroscopic .remove_macro').on('click', function() {
        	$(this).parent().parent().remove();
        })


    });
 
     $('.add_more_macroscopics').on('click', function(e) {
     	  e.preventDefault();
            newMacroItem();
     });
     function newMacroItem() {
            var newElem = $('tr.add_more_macroscopic').first().clone();
            newElem.find('input').val('');
            newElem.appendTo('.add_macroscopic');
        }
     
     function newMicroItem() {
            var newElem = $('tr.add_more_microscopic').first().clone();
            newElem.find('input').val('');
            newElem.appendTo('.add_microscopic');
        }

	</script>
@endsection
