<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\AppointmentController@update', [$appointment->id]), 'method' => 'PUT', 'id' => 'appointment_edit_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'schedule.edit_appointment' )</h4>
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

							{!! Form::text('date',@format_date($appointment->date), ['class' => 'form-control','placeholder' => __( 'schedule.date' ), 'required', 'id' => 'date',]); !!}
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
							{!! Form::select('doctor_id', $doctor, $appointment->doctor_id, ['class' => 'form-control select2','style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'doctor_dropdown']); !!}
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
							{!! Form::select('patient',$customers,$appointment->contact_id, ['class' => 'form-control select2', 'style' => 'width:100%','placeholder' => __('messages.please_select'), 'required', 'id' => 'patient_dropdown']); !!}
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
							{!! Form::select('status',['Pending Confirmation' => __('Pending Confirmation'), 'Confirmed' => __('Confirmed'), 'Treated' => __('Treated'),  'Cancelled' => __('Cancelled')],!empty($appointment->status) ? $appointment->status : null,  ['class' => 'form-control select2', 'style' => 'width:100%','placeholder' => __('messages.please_select'), 'required', 'id' => '']); !!}
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
							{!! Form::select('fee_status', ['Fee_Paid' => __('Fee Paid'), 'Not_Paid' => __('Not Paid'), 'Half_Paid' => __('Half Paid'),  'Old_Patient' => __('Old Patient'), 'Cancle' => __('Cancle'), 'Free' => __('Free')], !empty($appointment->fee_status) ? $appointment->fee_status : null, ['class' => 'form-control', 'id' => 'type', 'placeholder' => __( 'messages.please_select') ]); !!}
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
							{!! Form::hidden('note', $appointment->note, ['class' => 'form-control',]); !!}
							{!! Form::text('doctor_fee', $transaction->final_total, ['class' => 'form-control input_number', 'required']); !!}

						  </div>
						</div>
					  </div>
					  <div id="sequence" style="color:blue" class="col-md-3 "> You Selected:{{$appointment->sequence .'  Token No '.$appointment->token_no}}</div>
					  <div class="clearfix"></div>
					  
					  <div class="form-group">
						
						<div id="msg_c" >
						</div>
						<label class="col-md-3 control-label">choose_serial :</label>
					   
					
						<div class="col-md-9 schedul"> </div>
					</div>
				 
					</div>
				
					
				
				</div>
				

				<div class="modal-footer">
				<button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
			</div>


    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->