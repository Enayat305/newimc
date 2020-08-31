<div class="modal fade" id="add_appointment_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			{!! Form::open(['url' => action('Lab\AppointmentController@store'), 'method' => 'post', 'id' =>'appointment_add_form' ]) !!}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">@lang( 'schedule.add_new_appointment' )</h4>
				</div>

				<div class="modal-body">
					
				
					<div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
						  {!! Form::label('status', __('schedule.date') . ':*') !!}
								  <div class='input-group date' >
								  <span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
							{!! Form::text('date', $default_datetime, ['class' => 'form-control','placeholder' => __( 'schedule.date' ), 'required', 'id' => 'date',]); !!}
							</div>
						  </div>
						</div>
					  <div class="col-sm-6">
						<div class="form-group">
						  {!! Form::label('status', __('schedule.doctor') . ':*') !!}
				
						  <div class="input-group">
							<span class="input-group-addon">
							  <i class="fa fa-user-md"></i>
							</span>
							{!! Form::select('doctor_id', $doctor,7 , ['class' => 'form-control select2','style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'doctor_dropdown']); !!}
						  </div>
						</div>
					  </div>
					  <div class="col-sm-6">
						<div class="form-group">
						  {!! Form::label('status', __('Patients') . ':*') !!}
				
						  <div class="input-group">
							<span class="input-group-addon">
							  <i class="fa fa-stethoscope"></i>
							</span>
							{!! Form::select('patient',$customers, null, ['class' => 'form-control select2', 'style' => 'width:100%','placeholder' => __('messages.please_select'), 'required', 'id' => 'patient_dropdown']); !!}
							<span class="input-group-btn">
								<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""  @if(!auth()->user()->can('patient.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
							</span>  
						</div>
						</div>
					  </div>
					  <div class="col-sm-6">
						<div class="form-group">
						  {!! Form::label('status', __('schedule.appointment_status' ) . ':*') !!}
				
						  <div class="input-group">
							<span class="input-group-addon">
							  <i class="fa fa-check-square"></i>
							</span>
							<select class="form-control m-bot15" name="status" value="">
								<option value="Confirmed"> Confirmed </option>
								<option value="Pending Confirmation"> Pending Confirmation </option> 
								<option value="Treated"> Treated </option>
								<option value="Cancelled"> Cancelled </option>
							</select>
						  </div>
						</div>
					  </div>
					
					  <div class="col-sm-6">
						<div class="form-group">
						  {!! Form::label('status', __('schedule.doctorfeestatus ') . ':*') !!}
				
						  <div class="input-group">
							<span class="input-group-addon">
							  <i class="fa fa-check-square"></i>
							</span>
							{!! Form::select('fee_status', ['Fee_Paid' => __('Fee Paid'), 'Not_Paid' => __('Not Paid'), 'Half_Paid' => __('Half Paid'),  'Old_Patient' => __('Old Patient'), 'Cancle' => __('Cancle'), 'Free' => __('Free')],null, ['class' => 'form-control', 'id' => 'type' ]); !!}

						  </div>
						</div>
					  </div>
					  <div class="col-sm-6">
						<div class="form-group">
						  {!! Form::label('status', __('DOCTOR FEE ') . ':*') !!}
				
						  <div class="input-group">
							<span class="input-group-addon">
							  <i class="fa fa-edit"></i>
							</span>
							{!! Form::hidden('note', null, ['class' => 'form-control',]); !!}
							{!! Form::text('doctor_fee', 300, ['class' => 'form-control input_number', 'required']); !!}
						  </div>
						</div>
						
					  </div>
					  <div class="clearfix"></div>
					  <div class="form-group tokenarea">
						<div id="msg_c"></div>
						<label class="col-md-3 control-label">choose_serial :</label>
					   
						<div class="col-md-9 schedul"> </div>
					</div>
				 
				  
					</div>
				
					
				
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
			</div>

		{!! Form::close() !!}

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>