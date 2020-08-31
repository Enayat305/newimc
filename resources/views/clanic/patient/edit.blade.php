<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\PatientController@update', [$contact->id]), 'method' => 'PUT', 'id' => 'patient_edit_form']) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang('contact.edit_contact')</h4>
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
                  {!! Form::text('name', $contact->name, ['class' => 'form-control','placeholder' => __('patient.name'), 'required']); !!}
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
                  {!! Form::select('gender', ['Male' =>'Male','Female' =>'Female','Other' =>'Other'], $contact->gender , ['class' => 'form-control', 'id' => '','placeholder' => __('messages.please_select'), 'required']); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3 contact_type_div">
          <div class="form-group">
              {!! Form::label('type', __('patient.ref_by') . ':*' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  {!! Form::select('ref_by', $users, $contact->ref_by , ['class' => 'form-control', 'id' => 'contact_type','placeholder' => __('messages.please_select'), 'required']); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('blood_group', __('patient.blood_group') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-phone"></i>
                  </span>
                  {!! Form::select('blood_group',['A+' =>'A+','A-' =>'A-','B+' =>'B+','B-' =>'B-','AB+' =>'AB+','AB-' =>'AB-','B-' =>'B-','O+' =>'O+','O-' =>'O-'] ,$contact->blood_group, ['class' => 'form-control', 'placeholder' => __('messages.please_select')]); !!}
              </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('marital_status', __('patient.marital_status') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-map-marker"></i>
                  </span>
                  {!! Form::select('marital_status',['single'=>'Single', 'married'=>'Married' , 'other'=>'Other'],$contact->marital_status, ['class' => 'form-control', 'placeholder' => __('messages.please_select')]); !!}
              </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('age', __('patient.age') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-map-marker"></i>
                  </span>
                  {!! Form::text('age', $contact->age, ['class' => 'form-control', 'placeholder' => __('patient.age')]); !!}
              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              {!! Form::label('contact_id', __('lang_v1.contact_id') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-id-badge"></i>
                  </span>
                  <input type="hidden" id="hidden_id" value="{{$contact->id}}">
                  {!! Form::text('contact_id', $contact->contact_id, ['class' => 'form-control','placeholder' => __('lang_v1.contact_id')]); !!}
              </div>
          </div>
        </div>
        {{-- <div class="col-md-3">
          <div class="form-group">
              {!! Form::label('contact_id', __('patient.patient_id') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-id-badge"></i>
                  </span>
                  {!! Form::text('contact_id', $contact->contact_id, ['class' => 'form-control','placeholder' => __('patient.patient_id')]); !!}
              </div>
          </div>
        </div> --}}
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
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('email', __('business.email') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                {!! Form::email('email', $contact->email, ['class' => 'form-control','placeholder' => __('business.email')]); !!}
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
                {!! Form::text('mobile', $contact->mobile, ['class' => 'form-control', 'required', 'placeholder' => __('patient.mobile')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('alternate_number', __('patient.alternate_patient_number') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                {!! Form::text('alternate_number', $contact->alternate_number, ['class' => 'form-control', 'placeholder' => __('patient.alternate_patient_number')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('landline', __('patient.landline') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                {!! Form::text('landline',$contact->landline, ['class' => 'form-control', 'placeholder' => __('patient.landline')]); !!}
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('city', __('business.city') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('city',$contact->city, ['class' => 'form-control', 'placeholder' => __('business.city')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('state', __('business.state') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('state', $contact->state, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('country', __('business.country') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>
                {!! Form::text('country',$contact->country, ['class' => 'form-control', 'placeholder' => __('business.country')]); !!}
            </div>
        </div>
        {!! Form::hidden('landmark', null, ['class' => 'form-control landmark', 
        'placeholder' => __('business.landmark')]); !!}
      </div>
      {{-- <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('landmark', __('business.landmark') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('landmark', null, ['class' => 'form-control landmark', 
                'placeholder' => __('business.landmark')]); !!}
            </div>
        </div>
      </div> --}}
      <div class="clearfix"></div>
      <div class="col-md-12">
              <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                      <ul class="nav navbar-nav" style="font-size:10px">
                        <li><a  data-toggle="collapse" href="#non-pathological" aria-expanded="false" aria-controls="collapseExample">
                          NON-PATHOLOGICAL HISTORY
                        </a></li>
                        <li><a data-toggle="collapse" href="#diet" role="button" aria-expanded="false" aria-controls="collapseExample">
                          DIET
                        </a></li>
                        <li><a  data-toggle="collapse" href="#familyhistory" role="button" aria-expanded="false" aria-controls="collapseExample">
                          FAMILY HISTORY
                        </a></li>
                        
                        <li><a data-toggle="collapse" href="#pathologicalhistory" role="button" aria-expanded="false" aria-controls="collapseExample">
                          PATHOLOGICAL HISTORY</a></li>
                        <li><a data-toggle="collapse" href="#phychiatrichistory" role="button" aria-expanded="false" aria-controls="collapseExample">
                          PSYCHIATRIC HISTORY
                        </a></li>
                        <li><a data-toggle="collapse" href="#allergie" role="button" aria-expanded="false" aria-controls="collapseExample">
                          ALLERGIES
                        </a></li>
                        <li><a data-toggle="collapse" href="#vaccine" role="button" aria-expanded="false" aria-controls="collapseExample">
                          VACCINES 
                        </a></li>
                      </ul>
            
                    </div>
              </nav>
             
              <div class="collapse" id="non-pathological">
                @foreach ($nonpathological as $item)
                <div class="row custom-control custom-radio custom-control-inline">
                <div class="col-md-6">
      
                  <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
                
                </div>
                <div class="col-md-6 ">
                @foreach ($nonpathologicaldata as $items)
                @foreach ($contact->contact_nonpathologicalhistory as $patient_data)
                 @if ($item->id == $items->base_id && $items->id == $patient_data->nonpathological_id)
                 {!!Form::radio('nonpathological[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
                 
                  @endif 
                 @endforeach     
              
                  @endforeach
      
                </div>
                </div>
                @endforeach
                 
              
              </div>
              {{-- end of nonpathological --}}
              <div class="collapse" id="diet">
                @foreach ($diet as $item)
                <div class="row custom-control custom-radio custom-control-inline">
                <div class="col-md-6">
      
                  <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
                
                </div>
                <div class="col-md-6 ">
                @foreach ($diet_data as $items)
                @foreach ($contact->contact_patient_diet as $patient_data)
                 @if ($item->id == $items->base_id && $items->id == $patient_data->diet_id)
                 {!!Form::radio('diet[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
                 
                  @endif 
                 @endforeach     
              
                  @endforeach
      
                </div>
                </div>
                @endforeach
                 
              
              </div>
            
            {{-- end of diet --}}
            
            <div class="collapse" id="familyhistory">
              @foreach ($familyhistory as $item)
              <div class="row custom-control custom-radio custom-control-inline">
              <div class="col-md-6">
    
                <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
              
              </div>
              <div class="col-md-6 ">
              @foreach ($familyhistory_data as $items)
              @foreach ($contact->contact_patient_familyhistory as $patient_data)
               @if ($item->id == $items->base_id && $items->id == $patient_data->family_history_id)
               {!!Form::radio('familyhistory[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
               
                @endif 
               @endforeach     
            
                @endforeach
    
              </div>
              </div>
              @endforeach
               
            
            </div>
          </div>
          {{-- end of familyhistory --}}
          <div class="collapse" id="pathologicalhistory">
            @foreach ($pathologicalhistory as $item)
            <div class="row custom-control custom-radio custom-control-inline">
            <div class="col-md-6">
  
              <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
            
            </div>
            <div class="col-md-6 ">
            @foreach ($pathologicalhistory_data as $items)
            @foreach ($contact->contact_patientpathlogy as $patient_data)
             @if ($item->id == $items->base_id && $items->id == $patient_data->pathologicalhistory_id)
             {!!Form::radio('pathologicalhistory[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
             
              @endif 
             @endforeach     
          
              @endforeach
  
            </div>
            </div>
            @endforeach
             
          
          </div>
        
        {{-- end of pathologicalhistory--}}
        <div class="collapse" id="phychiatrichistory">
          @foreach ($phychiatrichistory as $item)
          <div class="row custom-control custom-radio custom-control-inline">
          <div class="col-md-6">

            <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
          
          </div>
          <div class="col-md-6 ">
          @foreach ($phychiatrichistory_data as $items)
          @foreach ($contact->contact_patientphychiatrichistory as $patient_data)
           @if ($item->id == $items->base_id && $items->id == $patient_data->phychiatrichistorie_id)
           {!!Form::radio('phychiatrichistory[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
           
            @endif 
           @endforeach     
        
            @endforeach

          </div>
          </div>
          @endforeach
           
        
        </div>
      
      {{-- end of phychiatrichistory--}}
      <div class="collapse" id="allergie">
        @foreach ($allergie as $item)
        <div class="row custom-control custom-radio custom-control-inline">
        <div class="col-md-6">

          <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
        
        </div>
        <div class="col-md-6 ">
        @foreach ($allergie_data as $items)
        @foreach ($contact->contact_patientallergie as $patient_data)
         @if ($item->id == $items->base_id && $items->id == $patient_data->allergie_id)
         {!!Form::radio('allergie[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
         
          @endif 
         @endforeach     
      
          @endforeach

        </div>
        </div>
        @endforeach
         
      
      </div>
    
    {{-- end of allergie--}}
    <div class="collapse" id="vaccine">
      @foreach ($vaccine as $item)
      <div class="row custom-control custom-radio custom-control-inline">
      <div class="col-md-4">

        <label class="custom-control-label " style="margin-left:28px;margin-right:28px"for="{{$item->actual_name}}">{{$item->actual_name}}</label>
      
      </div>
      <div class="col-md-8 ">
      @foreach ($vaccine_data as $items)
      @foreach ($contact->contact_patientvaccine as $patient_data)
       @if ($item->id == $items->base_id && $items->id == $patient_data->vaccines_id)
       {!!Form::radio('vaccine[' .$patient_data->base_id.']',$patient_data->id,$patient_data->check_box);!!} {{ __( $items->actual_name ) }}
       
        @endif 
       @endforeach     
    
        @endforeach

      </div>
      </div>
      @endforeach
       
    
    </div>
  
  {{-- end of vaccine--}}
          {{-- end  --}}
        </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>
</div>

    {!! Form::close() !!}
     
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


