<div class="modal fade" id="update_purchase_status_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

		{!! Form::open(['url' => action('Lab\AppointmentController@updateStatus'), 'method' => 'post', 'id' => 'update_purchase_status_form' ]) !!}

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">@lang( 'lang_v1.update_status' )</h4>
		</div>

		<div class="modal-body">
			<div class="form-group">
				{!! Form::label('status', __('purchase.purchase_status') . ':*') !!} 
				<select class="form-control m-bot15" name="status" value="">
					<option value="Pending Confirmation"> Pending Confirmation </option> 
					<option value="Confirmed"> Confirmed </option>
					<option value="Treated"> Treated </option>
					<option value="Cancelled"> Cancelled </option>
				</select>
				{!! Form::hidden('purchase_id', null, ['id' => 'purchase_id']); !!}
			</div>
		</div>

		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
		</div>

		{!! Form::close() !!}

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>