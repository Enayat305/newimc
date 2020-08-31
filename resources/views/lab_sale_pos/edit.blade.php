@extends('lab_layouts.app')

@section('title', 'POS')

@section('content')
<section class="content no-print">
	<input type="hidden" id="amount_rounding_method" value="{{$pos_settings['amount_rounding_method'] ?? ''}}">
	@if(!empty($pos_settings['allow_overselling']))
		<input type="hidden" id="is_overselling_allowed">
	@endif
	@if(session('business.enable_rp') == 1)
        <input type="hidden" id="reward_point_enabled">
    @endif
    @php
		$is_discount_enabled = $pos_settings['disable_discount'] != 1 ? true : false;
		$is_rp_enabled = session('business.enable_rp') == 1 ? true : false;
	@endphp
	{!! Form::open(['url' => action('Lab\SellPosController@update', [$transaction->id]), 'method' => 'post', 'id' => 'edit_pos_sell_form' ]) !!}
	{{ method_field('PUT') }}
	<div class="row mb-12">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-solid mb-12">
						<div class="box-body pb-0">
							{!! Form::hidden('location_id', $transaction->location_id, ['id' => 'location_id', 'data-receipt_printer_type' => !empty($location_printer_type) ? $location_printer_type : 'browser', 'data-default_accounts' => $transaction->location->default_payment_accounts]); !!}
							<input type="hidden" id="item_addition_method" value="{{$business_details->item_addition_method}}">
								@include('Laboratory/lab_sale_pos.partials.pos_form_edit')

								@include('Laboratory/lab_sale_pos.partials.pos_form_totals', ['edit' => true])

								@include('Laboratory/lab_sale_pos.partials.payment_modal')

								@if(empty($pos_settings['disable_suspend']))
									@include('Laboratory/lab_sale_pos.partials.suspend_note_modal')
								@endif

								@if(empty($pos_settings['disable_recurring_invoice']))
									@include('Laboratory/lab_sale_pos.partials.recurring_invoice_modal')
								@endif
							</div>
						</div>
					</div>
				{{-- <div class="col-md-5 no-padding">
					@include('Laboratory/lab_sale_pos.partials.pos_sidebar')
				</div> --}}
			</div>
		</div>
	</div>
	@include('Laboratory/lab_sale_pos.partials.pos_form_actions', ['edit' => true])
	{!! Form::close() !!}
</section>

<!-- This will be printed -->
<section class="invoice print_section" id="receipt_section">
</section>
<div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('contact.create', ['quick_add' => true])
</div>
<!-- /.content -->
<div class="modal fade register_details_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

@include('Laboratory/lab_sale_pos.partials.configure_search_modal')

@include('Laboratory/lab_sale_pos.partials.recent_transactions_modal')

@include('Laboratory/lab_sale_pos.partials.weighing_scale_modal')

@stop

@section('javascript')
	<script src="{{ asset('js/labpos.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/printer.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
	@include('Laboratory/lab_sale_pos.partials.keyboard_shortcuts')

	<!-- Call restaurant module if defined -->
    @if(in_array('tables' ,$enabled_modules) || in_array('modifiers' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules))
    	<script src="{{ asset('js/restaurant.js?v=' . $asset_v) }}"></script>
    @endif
@endsection

@section('css')
	<style type="text/css">
		/*CSS to print receipts*/
		.print_section{
		    display: none;
		}
		@media print{
		    .print_section{
		        display: block !important;
		    }
		}
		@page {
		    size: 3.1in auto;/* width height */
		    height: auto !important;
		    margin-top: 0mm;
		    margin-bottom: 0mm;
		}
	</style>
@endsection