<div class="row">
	<div class="col-md-12">
		@component('components.widget', ['title' => __('essentials::lang.hrm_details')])
			<div class="col-md-4">
				<div class="form-group">
		              {!! Form::label('essentials_department_id', __('essentials::lang.department') . ':') !!}
		              <div class="form-group">
		                  {!! Form::select('essentials_department_id', $departments, !empty($user->essentials_department_id) ? $user->essentials_department_id : null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select') ]); !!}
		              </div>
		          </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
		            {!! Form::label('essentials_designation_id', __('essentials::lang.designation') . ':') !!}
		            <div class="form-group">
		                {!! Form::select('essentials_designation_id', $designations, !empty($user->essentials_designation_id) ? $user->essentials_designation_id : null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select') ]); !!}
		            </div>
		        </div>
			</div>
		@endcomponent
	</div>
</div>