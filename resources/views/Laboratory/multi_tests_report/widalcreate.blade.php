
  
        {!! Form::open(['url' =>  action('Lab\Multi_ReportController@update' , [$query->id] ), 'method' => 'PUT', 'id' => 'add_report_form', 'files' => true ]) !!}

        <!-- Main content -->
        <section class="content no-print">
            @component('components.filters', ['title' => __('Test Info')])
         
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
                                        
                                        <th style="">Types</th>
                                        <th style="text-align: center;">1:20</th>
                                        <th style="text-align: center;">1:40</th>
                                        <th style="text-align: center;">1:80</th>
                                        <th style="text-align: center;">1:160</th>
                                        <th style="text-align: center;">1:320</th>
                                        <th style="text-align: center;">1:640</th>
                                    
                                    
                                </tr>	
                                </thead>
        
                                
                                    @foreach ($query->tests->test_head  as $item)
                                    {{-- <td>{{$item->name}}</td> --}}
                                
                                    @foreach ($query->report_test_particular as $report_test_particular)
                                @if ($item->report_head_id == $report_test_particular->report_head_id)
                                
                                <tr>
                                    
                                <td class="hidden"><input type="hidden" class="form-control" name="particular[{{$report_test_particular->id}}][id]" value="{{$report_test_particular->id}}"></td>
                                <td><input type="text" class="form-control  " readonly name="particular[{{$report_test_particular->id}}][name]" value="{{$report_test_particular->name}}"></td>
                                <td><input type="text" class="form-control " name="particular[{{$report_test_particular->id}}][result]" value="{{$report_test_particular->result}}"></td>
                                <td><input type="text" class="form-control " name="particular[{{$report_test_particular->id}}][unit]" value="{{$report_test_particular->unit}}"></td>
                                <td><input type="text" class="form-control " name="particular[{{$report_test_particular->id}}][malerange]"value="{{$report_test_particular->male}}"></td>
                                <td><input type="text" class="form-control inputs" name="particular[{{$report_test_particular->id}}][femalerange]"value="{{$report_test_particular->female}}"></td>
                                <td><input type="text" class="form-control " name="particular[{{$report_test_particular->id}}][highrange]"value="{{$report_test_particular->high_range}}"></td>
                                <td><input type="text" class="form-control " name="particular[{{$report_test_particular->id}}][lowrange]"value="{{$report_test_particular->low_range}}"></td>
                            </tr> 
                                @endif
                                @endforeach
                            
                            
                            
                            @endforeach
                                  
                                     
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
        
          <div class="col-sm-6">
            <div class="form-group">
              {!! Form::label('description', __('Test Comment ') . ':') !!}
                {!! Form::textarea('test_comment',  $query->test_comment, ['class' => 'form-control']); !!}
            </div>

            
          </div>
          <div class="col-sm-6">
            <div class="form-group">
            {!! Form::label('test', __('Test Result') . ':') !!}
            @if ($query->test_result=='Positive')
            {!! Form::select('test', ['Negative','Positive'] , 1 , ['placeholder' => __('messages.please_select'), 'class' => 'form-control  test_result ','required']); !!}            </div>
      
            @else
            {!! Form::select('test', ['Negative','Positive'] , 0 , ['placeholder' => __('messages.please_select'), 'class' => 'form-control  test_result ','required']); !!}            </div>
       
            @endif
            
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