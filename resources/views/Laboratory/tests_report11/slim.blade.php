<!-- business information here -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- <link rel="stylesheet" href="style.css"> -->
		<title>Receipt-</title>
		<style type="text/css">
	
body {
  margin: 0;
}
@page{
margin-top: 120px;
	padding: 0;
	font-size:12px;
	font-family: 'Raleway', sans-serif;

	
}


@media print {
	
	* {
		margin-top: 120px;
		margin: 0;
	    font-size:12px;
	    padding: 0;
    	
     			font-family: 'Raleway', sans-serif;
       
	}


	
}
.info h3 {
  font-family: 'Raleway', sans-serif;

  margin-bottom: 0;
}
.info h5 {
  font-family: 'Raleway', sans-serif;

  
  line-height: 0px;
 
  margin-top: 10px;
}
.info h6 {
  font-family: 'Raleway', sans-serif;

  
  line-height: 0px;
 
  margin-top: 15px;
  margin-bottom: 0;
}
#invoice-top{min-height:85px;}

.logo{
  float: right;
 
	margin: 0px;
}

.info{
  display: block;
  float:left;
  
  
}
.header{
	margin: 0;	
	
	margin-left: 30px;
	margin-right: 30px;
	
}
.header h3, h5,h6{
	margin-top: 5px;
	text-align: center;
	text-transform: uppercase;
}

.header-bottom h6, h5{
	margin-top: 5px;
	text-align: center;
	text-transform: uppercase;
}
/* article */


table.meta { float: right; width: 36%;
}

/* table meta */


table.meta1 { float: left; width: 36%; }


.patient_info{
	margin-left: 30px;
	margin-right: 30px;
	clear: both;
}
.table-responsive{
	margin-left: 30px;
	margin-right: 30px;
}
 




</style>
    <body>
		
		
		
		  <img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->report_code, 'C128', 1,40,array(39, 48, 54), true)}}">
		  <p style="float: left;font-size:5px">Developed By Skyline WebSolution Contact US:03428927305</p>

		  <div class="patient_info"  >			
			<table class="meta1"style="border-bottom: solid #eee;text-transform: uppercase;"  >
				<tr>
					<th><span >Patient Name</span></th>
					<td><span >{{$receipt_details->contact->name}}</span></td>
				</tr>
				<tr>
					<th><span >Age/Sex</span></th>
					<td><span >{{$receipt_details->contact->age.'   /  '.$receipt_details->contact->gender}}</span></td>
				</tr>
				<tr>
					<th><span >Address</span></th>
					<td><span >{{$receipt_details->contact->city}}</span></td>
				</tr>
				<tr>
					<th><span >Contat No</span></th>
					<td><span >{{$receipt_details->contact->mobile}}</span></td>
				</tr>
				<tr>
					<th><span >MR #</span></th>
				<td><span >{{$receipt_details->contact->contact_id}}</span></td>
				</tr>
			</table>
			<table class="meta" style="border-bottom: solid #eee">
				<tr>
					<th><span >Reported Dated</span></th>
				    <td><span >{{@format_datetime($receipt_details->reported_dated)}}</span></td>
				</tr>
				<tr>
					<th><span >Receipt Date</span></th>
				    <td><span >{{@format_datetime($receipt_details->transaction->transaction_date)}}</span></td>
				</tr>
				<tr>

					<th><span >Invoice #</span></th>
					<td><span >{{$receipt_details->transaction->invoice_no}}</span></td>
				</tr>
				<tr>
					<th><span >Specimen</span></th>
				    <td><span >{{$receipt_details->transaction->spicemen}}</span></td>
				</tr>
				<tr>
					<th><span >Ref By</span></th>
					<td><span> {{$receipt_details->doctor->surname.' '.$receipt_details->doctor->first_name.' '.$receipt_details->doctor->last_name}}</span></td>
				</tr>
				
				
			
			</table>
	  </div>
	  <div class="clearfix"></div>
	
	  <div class="" style=" background-color: #eee !important; ">
		<h3>{{$receipt_details->tests->department->name}}</h3>
  </div>

 
		<div class="table-responsive">
			<table style="width: 100%; "id="test_particular_entry_table">
			
				<tbody>
					<thead>
						<tr style="background-color: #eee !important;">
							
						<th style="rwidth: 25%">Test Descriptions</th>
						<th style="text-align: center;width: 25%">Result</th>
						<th style="text-align: center;width: 25%">Unit</th>
						<th style="text-align: center;width: 25%">Reference Range</th>
						
					</tr>	
					</thead>
				</tbody>
									@foreach ($receipt_details->tests->test_head  as $item)
									<tr style="height: 3px;">
										
										
									</tr>
					<tr style="">
						<th colspan="4">  <div class="clearfix"></div>
							@if ($item->reports_head->is_show==true)
							<p style="background-color: #eee !important;"><b>{{$item->reports_head->name}}</b></p>	
							@endif

						</th>
						
					</tr>
					@foreach ($receipt_details->report_test_particular as $report_test_particular)
				
					@if ($item->report_head_id == $report_test_particular->report_head_id)
					
					@if ($loop->index%2==0)
					 @if(!empty($report_test_particular->result)) 
					<tr style="height: 1px;">
										
										
					</tr>
					<tr  >

						<td >{{$report_test_particular->name}}</td>
						<td style="text-align: center"><b>{{$report_test_particular->result}}</b></td>
						<td style="text-align: center">{{$report_test_particular->unit}}</td>
						@if ($receipt_details->contact->gender=='Male')
						<td style="text-align: center">{{$report_test_particular->male}}</td>
						@else
						<td style="text-align: center">{{$report_test_particular->female}}</td>
						
					</tr>
					@endif	
					@endif
					@else
					@if(!empty($report_test_particular->result))
					<tr style="height: 2px;">
										
										
					</tr>
					<tr style="background-color: #eee !important;" >

						<td >{{$report_test_particular->name}}</td>
						<td style="text-align: center"><b>{{$report_test_particular->result}}</b></td>
						<td style="text-align: center">{{$report_test_particular->unit}}</td>
						@if ($receipt_details->contact->gender=='Male')
						<td style="text-align: center">{{$report_test_particular->male}}</td>
						@else
						<td style="text-align: center">{{$report_test_particular->female}}</td>
						@endif
					</tr>	
				
					@endif
					@endif	
					@endif
					@endforeach



					@endforeach

					 
				</tbody>
			</table>
			<table>		 
		</div>
	</div>
	@if(!empty($receipt_details->test_comment))
	<div class="clearfix"></div>
	<div class="header" style=" background-color: #eee !important; margin-top:200px; ">
		@if($receipt_details->tests->id==1)
		<h6 style="float: left"><b>PERIPHERAL FILM </b></h6>
		<h6 style="">{!! $receipt_details->test_comment!!}</h6>
		@else
		<h6 style="float: left"><b>Remark</b></h6>
		<h6 style="">{!!$receipt_details->test_comment!!}</h6>
		@endif
  </div>
  @endif
</div>
  
		

    </body>
</html>
