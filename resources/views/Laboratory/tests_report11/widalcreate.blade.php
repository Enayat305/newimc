@extends('lab_layouts.app')
@section('title', __('test.test_particular'))

@section('content')
<style type="text/css">



</style>
<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('test.test_particular')
        <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
{!! Form::open(['url' =>  action('Lab\TestReportController@update' , [$query->id] ), 'method' => 'PUT', 'id' => 'add_sell_form', 'files' => true ]) !!}

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
  <div class="col-md-6">
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
                  <button type="submit" class="btn btn-primary pull-right btn-flat">@lang( 'messages.save' )</button>
 				</div>
			</div>
			
	</div>
@endcomponent
{!! Form::close() !!}
</section>

<section id="receipt_section" class="print_section"></section>

<!-- /.content -->
@stop
@section('javascript')
	<script src="{{ asset('js/printer.js?v=' . $asset_v) }}"></script>
	

<script type="text/javascript">
$(document).ready(function(){
   
    sell_form = $('form#add_sell_form');


    $('button#submit-sell, button#save-and-print').click(function(e) {
        //Check if product is present or not.


        if ($(this).attr('id') == 'save-and-print') {
            $('#is_save_and_print').val(1);
        } else {
            $('#is_save_and_print').val(0);
        }



        if (sell_form.valid()) {
            window.onbeforeunload = null;
            sell_form.submit();
        }
    });
	function pos_print(receipt) {
    //If printer type then connect with websocket
    if (receipt.print_type == 'printer') {
        var content = receipt;
        content.type = 'print-receipt';

        //Check if ready or not, then print.
        if (socket != null && socket.readyState == 1) {
            socket.send(JSON.stringify(content));
        } else {
            initializeSocket();
            setTimeout(function() {
                socket.send(JSON.stringify(content));
            }, 700);
        }

    } else if (receipt.html_content != '') {
        //If printer type browser then print content
        $('#receipt_section').html(receipt.html_content);
        __currency_convert_recursively($('#receipt_section'));
        __print_receipt('receipt_section');
    }
}
	$('.inputs').keydown(function (e) {
     	if (e.which === 113) {
			var index = $('.inputs').index(this) + 1;
         $('.inputs').eq(index).focus();
     	}
     });



	$("td:nth-child(3)").change(function () {
	
		   
                    $("#test_particular_entry_table tbody td:nth-child(3) ").each(function (index) {
						
					range=$('td:nth-child(3)').find('input').val();
                    
				    if(range==='+'){
                        $('.test_result').val(0);
                    }
				
				  
                    });
				});
			
                $("td:nth-child(4)").change(function () {
	
		   
    $("#test_particular_entry_table tbody td:nth-child(4) ").each(function (index) {
        
    range=$('td:nth-child(4)').find('input').val();
    if(range==='+'){
        $('.test_result').val(0);
    }

  
    });
});		
$("td:nth-child(5)").change(function () {
	
		   
    $("#test_particular_entry_table tbody td:nth-child(5) ").each(function (index) {
        
    range=$('td:nth-child(5)').find('input').val();
    if(range==='+'){
        $('.test_result').val(0);
    }

  
    });
});
$("td:nth-child(6)").change(function () {
	
		   
    $("#test_particular_entry_table tbody td:nth-child(6) ").each(function (index) {
        
    range=$('td:nth-child(6)').find('input').val();
    if(range==='+'){
        $('.test_result').val(1);
    }

  
    });
});
$("td:nth-child(7)").change(function () {
	
		   
    $("#test_particular_entry_table tbody td:nth-child(7) ").each(function (index) {
        
    range=$('td:nth-child(7)').find('input').val();
    if(range==='+'){
        $('.test_result').val(1);
    }

  
    });
});
$("td:nth-child(8)").change(function () {
	
		   
    $("#test_particular_entry_table tbody td:nth-child(8) ").each(function (index) {
        
    range=$('td:nth-child(8)').find('input').val();
    if(range==='+'){
        $('.test_result').val(1);
    }

  
    });
});

	$(document).on('click', '.print-invoice', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        dataType: 'json',
        success: function(result) {
            if (result.success == 1) {
                //Check if enabled or not
                if (result.receipt.is_enabled) {
                    pos_print(result.receipt);
                }
            } else {
                toastr.error(result.msg);
            }

        },
    });
});
    
});
</script>
@endsection