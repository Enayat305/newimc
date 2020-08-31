<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\ScheduleController@update', [$Schedule->id]), 'method' => 'PUT', 'id' => 'schedule_edit_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'schedule.edit_schedule' )</h4>
      </div>
      
				<div class="modal-body">
				
					<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							{!! Form::label('status', __('schedule.doctor') . ':*') !!}

							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-user"></i>
								</span>
								{!! Form::select('doctor_id', $users, $Schedule->doctor_id, ['class' => 'form-control', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'booking_location_id']); !!}
							</div>
						</div>
					</div>
          <div class="col-sm-6">
						<div class="form-group">
							{!! Form::label('status', __('Select Day') . ':*') !!}

							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calender"></i>
								</span>
								{!! Form::select('day', $day, $Schedule->day, ['class' => 'form-control', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'booking_location_id']); !!}
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					
			
					<div class="clearfix"></div>
					<hr>
					<div id="restaurant_module_span"></div>
					<div class="clearfix"></div>
					<div class="col-sm-6">
						<div class="form-group">
						{!! Form::label('status', __('schedule.start_time') . ':*') !!}
	            			<div class='input-group date' >
	            			<span class="input-group-addon">
	                    		<span class="glyphicon glyphicon-time"></span>
	                		</span>
							{!! Form::text('start_time', $Schedule->start_time, ['class' => 'form-control','placeholder' => __( 'restaurant.start_time' ), 'required', 'id' => 'start_time','readonly']); !!}
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							{!! Form::label('status', __('schedule.end_time') . ':*') !!}
	            			<div class='input-group date' >
	            			<span class="input-group-addon">
	                    		<span class="glyphicon glyphicon-time"></span>
	                		</span>
							{!! Form::text('end_time', $Schedule->end_time, ['class' => 'form-control','placeholder' => __( 'restaurant.end_time' ), 'required', 'id' => 'end_time', 'readonly']); !!}
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							{!! Form::label('status', __('schedule.perpatienttime') . ':*') !!}
	            			<div class='input-group date' >
	            			<span class="input-group-addon">
	                    		<span class="glyphicon glyphicon-time"></span>
	                		</span>
							{!! Form::number('per_patient_time', $Schedule->per_patient_time, ['class' => 'form-control','placeholder' => __( 'schedule.perpatienttime' ), 'required', 'id' => '', ]); !!}
							</div>
						</div>
					</div>
				
					<div class="col-sm-6">
						<div class="form-group">
							{!! Form::label('status', __('schedule.visibility') . ':*') !!}
	            			<div class='input-group mt-5' >
								<input type="radio" id="checkbox2_5" value="1" name="visible" @if ($Schedule->visibility==1)
                    checked
                @endif value="1" class="md-radiobtn">
								<label for="checkbox2_5" >Yes</label>
						   
								<input style="margin-left:10px" type="radio" id="checkbox2_10" value="0" name="visible" @if ($Schedule->visibility==0)
                checked
            @endif class="md-radiobtn" >
								<label for="checkbox2_10">NO</label>
							
							</div>
						</div>
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