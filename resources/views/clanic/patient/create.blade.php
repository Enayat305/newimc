<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
  @php
    $form_id = 'patient_add_form';
    if(isset($quick_add)){
    $form_id = 'quick_add_patient';
    }
  @endphp
    {!! Form::open(['url' => action('Lab\PatientController@store'), 'method' => 'post', 'id' => $form_id ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang('patient.add_patient')</h4>
    </div>

    <div class="modal-body">
      <div class="row">
       
      <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('name', __('patient.name') . ':*') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('patient.name'), 'required']); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3 contact_type_div">
          <div class="form-group">
              {!! Form::label('type', __('patient.gender') . ':*' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  {!! Form::select('gender', ['Male' =>'Male','Female' =>'Female','Other' =>'Other'], null , ['class' => 'form-control', 'id' => '','placeholder' => __('messages.please_select'), 'required']); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('mobile', __('patient.mobile') . ':*') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-mobile"></i>
                  </span>
                  {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('patient.mobile'),'required']); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('city', __('business.city') . ':*') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-map-marker"></i>
                  </span>
                  {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('business.city')]); !!}
              </div>
          </div>
        </div>
        {{-- <div class="col-md-3 contact_type_div">
          <div class="form-group">
              {!! Form::label('type', __('patient.ref_by') . ':*' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  {!! Form::select('ref_by', $users, null , ['class' => 'form-control', 'id' => '12','placeholder' => __('messages.please_select'), 'required']); !!}
              </div>
          </div>
        </div> --}}
        {{-- <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('blood_group', __('patient.blood_group') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-phone"></i>
                  </span>
                  {!! Form::hidden('blood_group',['A+' =>'A+','A-' =>'A-','B+' =>'B+','B-' =>'B-','AB+' =>'AB+','AB-' =>'AB-','B-' =>'B-','O+' =>'O+','O-' =>'O-'],null, ['class' => 'form-control', 'placeholder' => __('messages.please_select')]); !!}
              </div>
          </div>
        </div> --}}
        <div class="clearfix"></div>
        {{-- <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('marital_status', __('patient.marital_status') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-map-marker"></i>
                  </span> --}}
                  {{-- {!! Form::hidden('marital_status',['single'=>'Single', 'married'=>'Married' , 'other'=>'Other'],'single', ['class' => 'form-control', 'placeholder' => __('messages.please_select')]); !!} --}}
              {{-- </div>
          </div>
        </div> --}}
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('age', __('patient.age') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-map-marker"></i>
                  </span>
                  {!! Form::text('age', null, ['class' => 'form-control', 'placeholder' => __('patient.age')]); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('contact_id', __('patient.patient_id') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-id-badge"></i>
                  </span>
                  {!! Form::text('contact_id', null, ['class' => 'form-control','placeholder' => __('patient.patient_id')]); !!}
              </div>
          </div>
        </div>
        {{-- <div class="col-md-3">
          <div class="form-group">
            {!! Form::label('image', __('lang_v1.product_image') . ':') !!}
              <div class="input-group">
                  {!! Form::file('image', ['id' => 'upload_image', 'accept' => 'image/*']); !!}
                  <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>
             
              </div>
          </div>
        </div> --}}
      <div class="col-md-12">
        <hr/>
      </div>
      {{-- <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('email', __('business.email') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span> --}}
                {!! Form::hidden('email', null, ['class' => 'form-control','placeholder' => __('business.email')]); !!}
            {{-- </div>
        </div>
      </div> --}}

      {{-- <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('alternate_number', __('patient.alternate_patient_number') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span> --}}
                {!! Form::hidden('alternate_number', null, ['class' => 'form-control', 'placeholder' => __('patient.alternate_patient_number')]); !!}
            {{-- </div>
        </div>
      </div> --}}
      {{-- <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('landline', __('patient.landline') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span> --}}
                {!! Form::hidden('landline', null, ['class' => 'form-control', 'placeholder' => __('patient.landline')]); !!}
            {{-- </div>
        </div>
      </div> --}}
      <div class="clearfix"></div>
 
      {{-- <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('state', __('business.state') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span> --}}
                {!! Form::hidden('state', null, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
            {{-- </div>
        </div>
      </div> --}}
      {{-- <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('country', __('business.country') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span> --}}
                {!! Form::hidden('country', null, ['class' => 'form-control', 'placeholder' => __('business.country')]); !!}
            {{-- </div>
        </div>
      </div> --}}
      {!! Form::hidden('landmark', null, ['class' => 'form-control landmark', 
      'placeholder' => __('business.landmark')]); !!}
      </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>
    
    {!! Form::close() !!}
     
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


