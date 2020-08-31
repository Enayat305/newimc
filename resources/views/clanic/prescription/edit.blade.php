@extends('lab_layouts.app')
@section('title', __('edit Prescriptions'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('edit Prescriptions') </h1>
</section>

<!-- Main content -->
<section class="content">	
    {!! Form::open(['url' => action('Lab\PrescriptionController@update', [$pre->id]), 'method' => 'PUT', 'id' => 'add_press_form']) !!}
	@component('components.widget', ['class' => 'box-primary'])
		<div class="row">
			<div class=" col-sm-3 ">
				<div class="form-group">
					{!! Form::label('supplier_id', __('Doctors') . ':*') !!}
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						{!! Form::select('doctor_id',$doctor, $pre->doctor_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'doctor_dropdown']); !!}
						
					</div>
				</div>
			
			</div>
		
			<div class=" col-sm-6 ">
				<div class="form-group">
					{!! Form::label('supplier_id', __('Patients') . ':*') !!}
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						{!! Form::select('contact_id',  $customers, $pre->contact_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'patient_dropdown']); !!}
					
					</div>
				</div>
			</div>
			<div class=" col-sm-3 ">
				<div class="form-group">
				
                    {!! Form::checkbox('validity', 1, $pre->validity, ['id' => 'validity']); !!} For Court</label>
				</div>
			</div>
			<div class="clearfix"></div>

			
		</div>

	
	@endcomponent
	@component('components.widget', ['class' => 'box-primary'])

	<div class="col-md-12">  
		<div class="col-md-2">      
			<div class="portlet light profile-sidebar-portlet bordered">
                <h5 class="text-center ">Patient Info</h5>
				<div class="profile-userpic">
					<img src="http://localhost/imc/public/uploads/business_logos/1585731111_00000208.jpg" class="img-responsive" alt=""> </div>
                <div class="pro"><input type="hidden" name="appointment_id" value="{{$pre->appointment->appointment_id}}">
                <div class="text-center"><h6>{{$pre->contact->name}}</h6> </div>	<div class="" style="padding:20px">
                        <ul class="nav">
                        <li>P_ID<span class="pull-right">{{$pre->contact->contact_id}}</span></li>
                        <li>Age<span class="pull-right">{{$pre->contact->age}}</span></li>
                        <li>Gender<span class="pull-right">{{$pre->contact->gender}}</span></li>
                            <li>Marital<span class="pull-right">{{$pre->contact->marital_status}}</span></li>
                            <li>Address<span class="pull-right"> {{ $pre->contact->city.' '. $pre->contact->state.' '. $pre->contact->country}} </span></li>
                            <hr><li><span class="text-center">{{$pre->appointment->appointment_id}}</span></li></ul>
                        </div>
                    </div>
				
			
			</div>
		</div>
		<div class="col-md-10 profile_right"> 

            @component('components.widget', ['class' => 'box-primary'])
            <div class="row">
                @foreach ($pre->prescription_history as $item)
                    
               
                <div class="col-sm-3">
                  <div class="form-group">
                    {!! Form::label('name', __('Height') ) !!}
                      {!! Form::text('height', $item->height, ['class' => 'form-control',
                      'placeholder' => __('Height')]); !!}
                  </div>
                </div>
              
                <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('name', __('weight') ) !!}
                        {!! Form::text('weight',$item->weight, ['class' => 'form-control',
                        'placeholder' => __('weight')]); !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('name', __('Temperature') ) !!}
                        {!! Form::text('temperature', $item->temperature, ['class' => 'form-control',
                        'placeholder' => __('Temperature')]); !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                  <div class="form-group">
                    {!! Form::label('respiratory_rate', __('Respiratory Rate') ) !!}
                      {!! Form::text('respiratory_rate',  $item->respiratory_rate, ['class' => 'form-control', 
                      'placeholder' => __('respiratory_rate')]); !!}
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('systole', __('Systole') ) !!}
                        {!! Form::text('systole', $item->systole, ['class' => 'form-control', 
                        'placeholder' => __('systole')]); !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('diastole', __('Diastole') ) !!}
                        {!! Form::text('diastole', $item->diastole, ['class' => 'form-control', 
                        'placeholder' => __('diastole')]); !!}
                    </div>
                  </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('heart_rate', __('Heart Rate') ) !!}
                            {!! Form::text('heart_rate', $item->heart_rate, ['class' => 'form-control', 
                            'placeholder' => __('heart_rate')]); !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                            <div class="form-group">
                              {!! Form::label('head_circumference', __('Head Circumference') ) !!}
                                {!! Form::text('head_circumference', $item->head_circumference, ['class' => 'form-control', 
                                'placeholder' => __('head_circumference')]); !!}
                            </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('oxygen_saturiation', __('Oxygen Saturiation') ) !!}
                        {!! Form::text('oxygen_saturiation', $item->oxygen_saturiation, ['class' => 'form-control', 
                        'placeholder' => __('oxygen_saturiation')]); !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('body_mass', __('Body Mass') ) !!}
                        {!! Form::text('body_mass',  $item->body_mass, ['class' => 'form-control', 
                        'placeholder' => __('body_mass')]); !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('lean_body_mass', __('Lean Body Mass') ) !!}
                        {!! Form::text('lean_body_mass',$item->lean_body_mass, ['class' => 'form-control', 
                        'placeholder' => __('lean_body_mass')]); !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      {!! Form::label('body_fat_per', __('Body Fat Per') ) !!}
                        {!! Form::text('body_fat_per', $item->body_fat_per, ['class' => 'form-control', 
                        'placeholder' => __('body_fat_per')]); !!}
                    </div>
                  </div>
                  @endforeach
                  <div class="clearfix"></div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      {!! Form::label('clinical_record', __('Clinical Investgation') . ':') !!}
                        {!! Form::textarea('clinical_record',$pre->clinical_record , ['class' => 'form-control','id'=>'clinical_record']); !!}
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      {!! Form::label('advice', __('Advice') . ':') !!}
                        {!! Form::textarea('advice', $pre->advice, ['class' => 'form-control','id'=>'advice']); !!}
                    </div>
				  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      {!! Form::label('tests', __('Pathlogy Examination Tests') . ':') !!} @show_tooltip(__('lang_v1.product_location_help'))
                        {!! Form::select('test[]',$tests, $pre->test, ['class' => 'form-control select2', 'multiple', 'id' => 'product_locations']); !!}
                    </div>
                  </div>
               
                      
  
            
              
            </div>
            @endcomponent

            @component('components.widget', ['class' => 'box-primary'])
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            {!! Form::text('search_medicine', null, ['class' => 'form-control mousetrap', 'id' => 'search_medicine', 'placeholder' => __('lang_v1.search_product_placeholder')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button tabindex="-1" type="button" class="btn btn-link btn-modal"data-href="{{action('ProductController@quickAdd')}}" 
                    data-container=".quick_add_product_modal"><i class="fa fa-plus"></i> @lang( 'product.add_new_product' ) </button>
                    </div>
                </div>
            </div>
            @php
                $hide_tax = '';
                if( session()->get('business.enable_inline_tax') == 0){
                    $hide_tax = 'hide';
                }
            @endphp
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-th-green text-center table-striped" id="purchase_entry_table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    {{-- <th>Dosage</th> --}}
                                    <th>Frequency</th>
                                    <th>Days</th>
                                    <th>Instruction</th>
                                    <th><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
    @if(!empty($pre->medicine ))
	@foreach ($pre->medicine as $items)						
						
    <tr>
        
        <td>
         {{$items['product_name']}}
         {!! Form::hidden('medicine[' .  $loop->index . '][product_name]',$items['product_name'] , ['class' => 'hidden_variation_id']); !!}

        </td>
       
            {!! Form::hidden('medicine[' . $loop->index. '][product_id]',  $items['product_id'] ); !!}
            {!! Form::hidden('medicine22[' . $loop->index. '][quantity]', number_format(1), ['class' => 'form-control input-sm purchase_quantity input_number mousetrap', 'required',  'data-msg-abs_digit' => __('lang_v1.decimal_value_not_allowed')]); !!}
         
        <td>
            {!! Form::text('medicine[' . $loop->index. '][frequency]', $items['frequency'], ['class' => 'form-control' , 'placeholder' => __('1 + 0 + 1')]); !!}

        </td>  
        <td>
            {!! Form::text('medicine[' . $loop->index. '][day]',$items['day'], ['class' => 'form-control' , 'placeholder' => __(' 7 Days')]); !!}

        </td>  
        <td>
            {!! Form::text('medicine[' . $loop->index. '][instruction]', $items['instruction'], ['class' => 'form-control' , 'placeholder' => __(' After Food')]); !!}

        </td> 
        <td><i class="fa fa-times remove_purchase_entry_row text-danger" title="Remove" style="cursor:pointer;"></i></td>
	</tr>
	<?php $row_count = $loop->index + 1 ; ?>


@endforeach
<input type="hidden" id="row_count" value="{{ $row_count }}">

@else
    <input type="hidden" id="row_count" value="0">

@endif

							</tbody>
                        </table>
                    </div>
                    <hr/>
                    
    
                    
                </div>
            </div>
        @endcomponent
            <div class="row">
				<div class="col-sm-12">
                    <button type="submit" id="submit_pres" class="btn btn-primary pull-right btn-flat">@lang( 'messages.save' )</button>
				</div>
			</div>
		</div>
	</div>
	@endcomponent
{!! Form::close() !!}
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

</section>

@endsection

@section('javascript')
<script src="{{ asset('js/clanic.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/labproduct.js?v=' . $asset_v) }}"></script>

<script  type="text/javascript">
$(document).ready(function() {
	   $(document).on('change', '#patient_dropdown', function() {
                  $.ajax({
                url: '/lab/get_patient',
                type: 'GET',
                data: { patient: $('#patient_dropdown').val(),doctor: $('#doctor_dropdown').val() },
                success: function(response)
                {
                    if(response === ''){
                        toastr.warning('The Patient have no Appointment this day ');
                        $('button#submit_pres').attr('disabled', true);
                    }
                    else{
                        var container = $(".pro");
                    container.html(response);
                    $('button#submit_pres').attr('disabled',false);s
                    }
                }
            });
        });
        if ($('textarea#clinical_record').length > 0) {
        tinymce.init({
            selector: 'textarea#clinical_record',
            height:250
        });
    }
    if ($('textarea#advice').length > 0) {
        tinymce.init({
            selector: 'textarea#advice',
            height:250
        });
    }
    if ($('textarea#test').length > 0) {
        tinymce.init({
            selector: 'textarea#test',
            height:250
        });
    }


});
</script>
<style type="text/css">
.profile-sidebar {
    float: left;
    width: 300px;
    margin-right: 20px
}

.profile-content {
    overflow: hidden
}

.profile-userpic img {
    float: none;
    margin: 0 auto;
    width: 50%;
    height: 50%;
    -webkit-border-radius: 50%!important;
    -moz-border-radius: 50%!important;
    border-radius: 50%!important
}

.profile-usertitle {
    text-align: center;
    margin-top: 20px
}

.profile-usertitle-name {
    color: #5a7391;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 7px
}

.profile-usertitle-job {
    text-transform: uppercase;
    color: #5b9bd1;
    
    margin-bottom: 7px
}

.profile-userbuttons {
    text-align: center;
    margin-top: 10px
}

.profile-userbuttons .btn {
    margin-right: 5px
}

.profile-userbuttons .btn:last-child {
    margin-right: 0
}

.profile-userbuttons button {
    text-transform: uppercase;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 15px
}

.profile-usermenu {
    margin-top: 30px;
    padding-bottom: 20px
}

.profile-usermenu ul li {
    border-bottom: 1px solid #f0f4f7
}

.profile-usermenu ul li:last-child {
    border-bottom: none
}

.profile-usermenu ul li a {
    color: #93a3b5;
    font-size: 16px;
    font-weight: 400
}

.profile-usermenu ul li a i {
    margin-right: 8px;
    font-size: 16px
}

.profile-usermenu ul li a:hover {
    background-color: #fafcfd;
    color: #5b9bd1
}

.profile-usermenu ul li.active a {
    color: #5b9bd1;
    background-color: #f6f9fb;
    border-left: 2px solid #5b9bd1;
    margin-left: -2px
}

.profile-stat {
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f4f7
}

.profile-stat-title {
    color: #7f90a4;
    font-size: 25px;
    text-align: center
}

.profile-stat-text {
    color: #5b9bd1;
    font-size: 11px;
    font-weight: 800;
    text-align: center
}

.profile-desc-title {
    color: #7f90a4;
    font-size: 17px;
    font-weight: 600
}

.profile-desc-text {
    color: #7e8c9e;
    font-size: 14px
}

.profile-desc-link i {
    width: 22px;
    font-size: 19px;
    color: #abb6c4;
    margin-right: 5px
}

.profile-desc-link a {
    font-size: 14px;
    font-weight: 600;
    color: #5b9bd1
}

@media (max-width:991px) {
    .profile-sidebar {
        float: none;
        width: 100%!important;
        margin: 0
    }
    .profile-sidebar>.portlet {
        margin-bottom: 20px
    }
    .profile-content {
        overflow: visible
    }
}


/*portlet*/
.page-portlet-fullscreen {
    overflow: hidden
}

.portlet {
    margin-top: 0;
    margin-bottom: 25px;
    padding: 0;
    border-radius: 4px
}

.portlet.portlet-fullscreen {
    z-index: 10060;
    margin: 0;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: #fff
}

.portlet.portlet-fullscreen>.portlet-body {
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0 10px
}

.portlet.portlet-fullscreen>.portlet-title {
    padding: 0 10px
}

.portlet>.portlet-title {
    border-bottom: 1px solid #eee;
    padding: 0;
    margin-bottom: 10px;
    min-height: 41px;
    -webkit-border-radius: 4px 4px 0 0;
    -moz-border-radius: 4px 4px 0 0;
    -ms-border-radius: 4px 4px 0 0;
    -o-border-radius: 4px 4px 0 0;
    border-radius: 4px 4px 0 0
}

.portlet>.portlet-title:after,
.portlet>.portlet-title:before {
    content: " ";
    display: table
}

.portlet>.portlet-title:after {
    clear: both
}

.portlet>.portlet-title>.caption {
    float: left;
    display: inline-block;
    font-size: 18px;
    line-height: 18px;
    padding: 10px 0
}

.portlet>.portlet-title>.caption.bold {
    font-weight: 400
}

.portlet>.portlet-title>.caption>i {
    float: left;
    margin-top: 4px;
    display: inline-block;
    font-size: 13px;
    margin-right: 5px;
    color: #666
}

.portlet>.portlet-title>.caption>i.glyphicon {
    margin-top: 2px
}

.portlet>.portlet-title>.caption>.caption-helper {
    padding: 0;
    margin: 0;
    line-height: 13px;
    color: #9eacb4;
    font-size: 13px;
    font-weight: 400
}

.portlet>.portlet-title>.actions {
    float: right;
    display: inline-block;
    padding: 6px 0
}
.profile-sidebar-portlet {
	-webkit-box-shadow: -4px 15px 60px 10px rgba(196,207,201,1);
-moz-box-shadow: -4px 15px 60px 10px rgba(196,207,201,1);
box-shadow: -4px 15px 60px 10px rgba(196,207,201,1);
}
.profile_right{
	-webkit-box-shadow: -4px 15px 60px 10px rgba(196,207,201,1);
-moz-box-shadow: -4px 15px 60px 10px rgba(196,207,201,1);
box-shadow: -4px 15px 60px 10px rgba(196,207,201,1);	
}
</style>

@endsection
