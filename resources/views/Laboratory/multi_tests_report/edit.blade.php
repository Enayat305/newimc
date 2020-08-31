
@if($query->tests->id == 82)

{!! Form::open(['url' =>  action('Lab\Multi_ReportController@update' , [$query->id] ), 'method' => 'PUT', 'id' => 'add_report_form', 'files' => true ]) !!}

<!-- Main content -->
<section class="content no-print">
    @component('components.filters', ['title' => __('Test Info')])
    <div class="col-md-3">
        <div class="form-group">
            
                  {!! Form::label('report_time_day', __('Patient Name') . ':') !!} 
                  {!! Form::text('test_name', $query->contact->name, ['class' => 'form-control','readonly'
                    ]); !!}

        </div>   
    </div>
        <div class="col-md-3">
            <div class="form-group">
                
                      {!! Form::label('report_time_day', __('Test Name') . ':') !!} 
                      {!! Form::text('test_name', $query->tests->name, ['class' => 'form-control','readonly'
                        ]); !!}

            </div>   
        </div>
        <div class="col-md-3">
            <div class="form-group">
                 {!! Form::label('report_time_day', __('Department Name') . ':') !!} 
                 {!! Form::text('depart_name', $query->departments->name, ['class' => 'form-control','readonly'
                   ]); !!}

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">

                 {!! Form::label('report_time_day', __('Ref By') . ':') !!} 
                 {!! Form::text('doctor_name',$query->doctor->surname.' '.$query->doctor->first_name.' '.$query->doctor->last_name, ['class' => 'form-control','readonly'
                   ]); !!}

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
            @if($query->tests->id==1)

{!! Form::hidden('sum_value', 1, ['id' => 'sum-value']); !!}

@endif
                 {!! Form::label('report_time_day', __('Report Code') . ':') !!} 
                 {!! Form::text('report_code', $query->report_code, ['class' => 'form-control','readonly'
                   ]); !!}
        {!! Form::hidden('is_save_and_print', 0, ['id' => 'is_save_and_print']); !!}

            </div>
        </div>
    @endcomponent

    
        
    @component('components.widget', ['class' => 'box-primary', 'title' => __('Test Report Particulars Details
    ')])

    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-th-green text-center table-striped" id="test_particular_entry_table">
                
                    <tbody>
                        <thead>
                            <tr>
                                
                            <th>Name</th>
                            <th>Result</th>
                            <th>Unit</th>
                            @if ($query->contact->gender=='Male')
                            <th>Male Range</th>  
                            @else
                            <th>Female Range</th>  
                            @endif
                            <th>High Range</th>
                            <th>Low Range</th>
                            
                            
                        </tr>	
                        </thead>

                        
                            @foreach ($query->tests->test_head as $item)
                            <tr style="height: 15px;">
                                        
                                        
                            </tr>
                            <tr>
                             <th colspan="7">{{$item->reports_head->name}}</th> 
                            </tr>
                            @foreach ($query->report_test_particular as $report_test_particular)
                        @if ($item->report_head_id == $report_test_particular->report_head_id)
                        
                        <tr>
                            
                        <td class="hidden"><input type="hidden" class="form-control" name="particular[{{$report_test_particular->id}}][id]" value="{{$report_test_particular->id}}"></td>
                        <td><input type="text" class="form-control " readonly name="particular[{{$report_test_particular->id}}][name]" value="{{$report_test_particular->name}}"></td>
                        @if($report_test_particular->name=='Cross Matching')
                            <td>
                                <select class="form-control form-control-lg" name="particular[{{$report_test_particular->id}}][result]">
                                <option value="Donor's cells with Recipient's serum in Saline. Commb's and Albumin phase are 'COMPATIBLE' ">Donor's cells with Recipient's serum in Saline. Commb's and Albumin phase are "COMPATIBLE"</option>
                                <option value="Donor's cells with Recipient's serum in Saline. Commb's and Albumin phase are "NOT COMPATIBLE"">Donor's cells with Recipient's serum in Saline. Commb's and Albumin phase are "NOT COMPATIBLE"</option>
                  
                              </select></td>
                           
                        @else
                        @if($report_test_particular->result=="Positive" || $report_test_particular->result=="positive" || $report_test_particular->result=="Negative" || $report_test_particular->result=="negative" )
                        <td>
                            {!! Form::select('particular[' . $report_test_particular->id. '][result]',['Negative'=>'Negative','Positive'=>'Positive'],$report_test_particular->result , ['class' => 'form-control select2', 'required']); !!}

                        </td>
                        @else
                        <td><input type="text" class="form-control inputs" name="particular[{{$report_test_particular->id}}][result]" value="{{$report_test_particular->result}}"></td>
                        @endif
                        @endif
                        <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][unit]" value="{{$report_test_particular->unit}}"></td>
                       
                        @if ($query->contact->gender=='Male')
                        <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][malerange]"value="{{$report_test_particular->male}}"></td>
                        
                        @else
                        <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][femalerange]"value="{{$report_test_particular->female}}"></td>
                        @endif
                        <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][highrange]"value="{{$report_test_particular->high_range}}"></td>
                        <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][lowrange]"value="{{$report_test_particular->low_range}}"></td>
                    </tr> 
                        @endif
                        @endforeach
                    
                    
                    
                    @endforeach
                          
                             
                    </tbody>
                </table>
                <div class="clearfix"></div>

  <div class="col-sm-12">
    <div class="form-group">
      {!! Form::label('description', __('Test Comment ') . ':') !!}
        {!! Form::textarea('test_comment',  $query->test_comment, ['class' => 'form-control']); !!}
    </div>
  </div>
            </div>
            
            </table>
            </div>

            
        </div>
        <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                  <button type="submit" id="save-and-print" class="btn btn-primary pull-right btn-flat">@lang( 'messages.save' )</button>
                 </div>
            </div>
    </div>
@endcomponent
{!! Form::close() !!}
</section>
@else
        {!! Form::open(['url' =>  action('Lab\Multi_ReportController@update' , [$query->id] ), 'method' => 'PUT', 'id' => 'add_report_form', 'files' => true ]) !!}

        <!-- Main content -->
        <section class="content no-print">
            @component('components.filters', ['title' => __('Test Info')])
            <div class="col-md-3">
                <div class="form-group">
                    
                          {!! Form::label('report_time_day', __('Patient Name') . ':') !!} 
                          {!! Form::text('test_name', $query->contact->name, ['class' => 'form-control','readonly'
                            ]); !!}
    
                </div>   
            </div>
                <div class="col-md-3">
                    <div class="form-group">
                        
                              {!! Form::label('report_time_day', __('Test Name') . ':') !!} 
                              {!! Form::text('test_name', $query->tests->name, ['class' => 'form-control','readonly'
                                ]); !!}
        
                    </div>   
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                         {!! Form::label('report_time_day', __('Department Name') . ':') !!} 
                         {!! Form::text('depart_name', $query->departments->name, ['class' => 'form-control','readonly'
                           ]); !!}
        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
        
                         {!! Form::label('report_time_day', __('Ref By') . ':') !!} 
                         {!! Form::text('doctor_name',$query->doctor->surname.' '.$query->doctor->first_name.' '.$query->doctor->last_name, ['class' => 'form-control','readonly'
                           ]); !!}
        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                         @if($query->tests->id==1)

                        {!! Form::hidden('sum_value', 1, ['id' => 'sum-value']); !!}

                        @endif
                         {!! Form::label('report_time_day', __('Report Code') . ':') !!} 
                         {!! Form::text('report_code', $query->report_code, ['class' => 'form-control','readonly'
                           ]); !!}
                {!! Form::hidden('is_save_and_print', 0, ['id' => 'is_save_and_print']); !!}
        
                    </div>
                </div>
            @endcomponent
        
            
                
            @component('components.widget', ['class' => 'box-primary', 'title' => __('Test Report Particulars Details
            ')])
        
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-th-green text-center table-striped" id="test_particular_entry_table">
                        
                            <tbody>
                                <thead>
                                    <tr>
                                        
                                    <th>Name</th>
                                    <th>Result</th>
                                    <th>Unit</th>
                                    @if ($query->contact->gender=='Male')
                                    <th>Male Range</th>  
                                    @else
                                    <th>Female Range</th>  
                                    @endif
                                    <th>High Range</th>
                                    <th>Low Range</th>
                                    
                                    
                                </tr>	
                                </thead>
        
                                
                                    @foreach ($query->tests->test_head as $item)
                                    <tr style="height: 15px;">
                                                
                                                
                                    </tr>
                                    <tr>
                                     <th colspan="7">{{$item->reports_head->name}}</th> 
                                    </tr>
                                    @foreach ($query->report_test_particular as $report_test_particular)
                                @if ($item->report_head_id == $report_test_particular->report_head_id)
                                
                                <tr>
                                    
                                <td class="hidden"><input type="hidden" class="form-control" name="particular[{{$report_test_particular->id}}][id]" value="{{$report_test_particular->id}}"></td>
                                <td><input type="text" class="form-control "  name="particular[{{$report_test_particular->id}}][name]" value="{{$report_test_particular->name}}"></td>

                        @if($report_test_particular->result=="Positive" || $report_test_particular->result=="positive" || $report_test_particular->result=="Negative" || $report_test_particular->result=="negative" )
                        <td>
                            {!! Form::select('particular[' . $report_test_particular->id. '][result]',['Negative'=>'Negative','Positive'=>'Positive'],$report_test_particular->result , ['class' => 'form-control select2', 'required']); !!}

                        </td>
                        @elseif($report_test_particular->name=="Casts" || $report_test_particular->name=="casts" )
                        <td>
                        {!! Form::select('particular[' . $report_test_particular->id. '][result]',[''=>'NIL','Granular Few '=>'Granular Few','Granular Moderate '=>'Granular Moderate ','Granular Many '=>'Granular Many ','Hyline Few'=>'Hyline Few','Vaxy'=>'Vaxy'],$report_test_particular->result , ['class' => 'form-control select2']); !!}
                        </td>
                      
                        @else
                            @if($query->tests->id==1)
                                <td><input type="text" class="form-control inputs" name="particular[{{$report_test_particular->id}}][result]" value="{{$report_test_particular->result}}"></td>
                                @else
                                <td><input type="text"  class="form-control inputs" name="particular[{{$report_test_particular->id}}][result]" value="{{$report_test_particular->result}}"></td>

                                @endif                        @endif                                <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][unit]" value="{{$report_test_particular->unit}}"></td>
                                @if ($query->contact->gender=='Male')
                                <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][malerange]"value="{{$report_test_particular->male}}"></td>
                                
                                @else
                                <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][femalerange]"value="{{$report_test_particular->female}}"></td>
                                @endif
                                <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][highrange]"value="{{$report_test_particular->high_range}}"></td>
                                <td><input type="text" class="form-control" readonly name="particular[{{$report_test_particular->id}}][lowrange]"value="{{$report_test_particular->low_range}}"></td>
                            </tr> 
                                @endif
                                @endforeach
                            
                            
                            
                            @endforeach
                                  
                                     
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        @if($query->tests->id==1)
                        <div class="col-sm-6">
                            <div class="form-group">
                              {!! Form::label('totalvalue', __('Total Count ') . ':') !!}
                              {!! Form::text('totalvalue', null, ['id' => 'total-value']); !!}
                            </div>
                          </div>                      
                        @endif
        
          <div class="col-sm-12">
            <div class="form-group">
              {!! Form::label('description', __('Test Comment ') . ':') !!}
                {!! Form::textarea('test_comment',  $query->test_comment, ['class' => 'form-control']); !!}
            </div>
          </div>
                    </div>
                    
                    </table>
                    </div>
        
                    
                </div>
                <div class="row">
                        <div class="col-sm-12">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                          <button type="submit" id="save-and-print" class="btn btn-primary pull-right btn-flat">@lang( 'messages.save' )</button>
                         </div>
                    </div>
            </div>
        @endcomponent
        {!! Form::close() !!}
        </section>
@endif