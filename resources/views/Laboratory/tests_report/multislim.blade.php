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
	margin: 0;
	padding: 0;
	font-family: 'Raleway', sans-serif;
	font-size: 13px;

}


@media print {
	* {
		margin: 0;
    	font-size: 13px;
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
		<div style="height: 1105px;">
		<div id="invoice-top" style=" "  >
			<div class="logo" style="">
				<img src="{{ url( 'uploads/business_logos/Lab_Title.jpg' ) }}" style="
				 width: 100%;
				 margin-top:10px;
				 " alt="Logo">
			</div>
			<div >



			</div><!--End Info-->

		  </div><!--End InvoiceTop-->

		  <img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($code, 'C128', 1,40,array(39, 48, 54), true)}}">
	  <div class="patient_info"  >
			<table class="meta1"style="border-bottom: solid #eee;text-transform: uppercase;"  >

				@foreach($receipt_details as $key => $value)

				@if($key ==0)

				<tr>
				   <th><span >Patient Name</span></th>
				   <td><span >{{$value->contact->name}}</span></td>
				</tr>
				<tr>
				   <th><span >Age/Sex</span></th>
				   <td><span >{{$value->contact->age.'   /  '.$value->contact->gender}}</span></td>
				</tr>
				<tr>
				   <th><span >Address</span></th>
				   <td><span >{{$value->contact->city}}</span></td>
				</tr>
				<tr>
				   <th><span >Contat No</span></th>
				   <td><span >{{$value->contact->mobile}}</span></td>
				</tr>
				<tr>
				   <th><span >MR #</span></th>
				<td><span >{{$value->contact->contact_id}}</span></td>
				</tr>
				</table>
				<table class="meta" style="border-bottom: solid #eee">
				<tr>
				   <th><span >Reported Dated</span></th>
				   <td><span >{{@format_datetime($value->reported_dated)}}</span></td>
				</tr>
				<tr>
				   <th><span >Receipt Date</span></th>
				   <td><span >{{@format_datetime($value->transaction->transaction_date)}}</span></td>
				</tr>
				<tr>

				   <th><span >Invoice #</span></th>
				   <td><span >{{$value->transaction->invoice_no}}</span></td>
				</tr>
				<tr>
				   <th><span >Specimen</span></th>
				   <td><span >{{$value->tests->sample_require}}</span></td>
				</tr>
				<tr>
				   <th><span >Ref By</span></th>
				   <td><span> {{$value->doctor->surname.' '.$value->doctor->first_name.' '.$value->doctor->last_name}}</span></td>
				</tr>

				@endif
				@endforeach

			</table>
	  </div>


	  <div class="clearfix"></div>
	    {{-- 
	  <div class="header" style=" background-color: #eee !important; ">
		<h3>{{ $tests}}</h3>
  </div> --}}
  @php
		$length = count($result);
  @endphp
  @foreach ($result as $item)
  @if ($length == 1)
  <div class="header" style=" background-color: #eee !important; ">
	<h3>{{$item}}</h3>
</div>  
  @endif
  
  @endforeach

  @foreach ($receipt_details  as $values)
		<div class="table-responsive">
			<table style="width: 100%; "id="test_particular_entry_table">
			    
				@foreach ($result as $dep)
				@if ($dep == $values->departments->name)
				
				@else
				<!-- <div class="header" style=" background-color: #eee !important; ">
					<h3>{{$values->departments->name}}</h3>
			  </div> -->
				@endif
				
				@endforeach
			
		  <div class="header" style=" background-color: #eee !important; ">
			<h5><b>{{$values->tests->name}}</b></h5>
	  </div>
				<tbody>
					@if ($values->test_id==34 || $values->test_id==35)
					<thead>
						<tr style="background-color: #eee !important;">
							
						<th style="">Types</th>
						<th style="text-align: center;">1:20</th>
						<th style="text-align: center;">1:40</th>
						<th style="text-align: center;">1:80</th>
						<th style="text-align: center;">1:160</th>
						<th style="text-align: center;">1:320</th>
						<th style="text-align: center;">1:640</th>
						
					</tr>	
					</thead>
					@else
					<thead>
						<tr style="background-color: #eee !important;">

						<th style="rwidth: 30%">Test Descriptions</th>
						<th style="text-align: center;width: 25%">Result</th>
						<th style="text-align: center;width: 20%">Unit</th>
						<th style="text-align: center;width: 25%">Normal Range</th>

					</tr>
					</thead>
					@endif
					
				</tbody>
                @if ($values->test_id==34 || $values->test_id==35)
				@foreach ($values->tests->test_head as $item)
				@foreach ($values->report_test_particular as $report_test_particular)
				@if ($item->report_head_id == $report_test_particular->report_head_id)
				
				@if ($loop->index%2==0)
				@if(!empty($report_test_particular->result))
				<tr  >
				  
					<td >{{$report_test_particular->name}}</td>
					<td  style="text-align: center">{{$report_test_particular->result}}</td>
					<td style="text-align: center">{{$report_test_particular->unit}}</td>
					<td style="text-align: center">{{$report_test_particular->male}}</td>
					<td style="text-align: center">{{$report_test_particular->female}}</td>
					<td style="text-align: center">{{$report_test_particular->high_range}}</td>
					<td style="text-align: center">{{$report_test_particular->low_range}}</td>
				  
				</tr>
				@endif 
				@else
				<tr>
				<td colspan="7"><div class="clearfix"></div>
					<div class="header" style="display:none">
						.
				</div></td>
				</tr>
				@if(!empty($report_test_particular->result))
				<tr style="background-color: #eee !important;" >
			
					<td >{{$report_test_particular->name}}</td>
					<td style="text-align: center">{{$report_test_particular->result}}</td>
					<td style="text-align: center">{{$report_test_particular->unit}}</td>
					<td style="text-align: center">{{$report_test_particular->male}}</td>
					<td style="text-align: center">{{$report_test_particular->female}}</td>
					<td style="text-align: center">{{$report_test_particular->high_range}}</td>
					<td style="text-align: center">{{$report_test_particular->low_range}}</td>

					</tr>	
					@endif
				@endif
			
				@endif
				@endforeach



				@endforeach

				@else
					
				@foreach ($values->tests->test_head  as $item)
				<tr style="height: 3px;">


				</tr>
<tr style="">
	<th colspan="4">  <div class="clearfix"></div>
	<p style="background-color: #eee !important;"><b>{{$item->reports_head->name}}</b></p>

	</th>

</tr>
@foreach ($values->report_test_particular as $report_test_particular)
@if(!empty($report_test_particular->result))
@endif
@if ($item->report_head_id == $report_test_particular->report_head_id)

@if ($loop->index%2==0)
@if(!empty($report_test_particular->result))
<tr style="height: 1px;">


</tr>
<tr  >

	<td >{{$report_test_particular->name}}</td>
	<td style="text-align: center">{{$report_test_particular->result}}</td>
	<td style="text-align: center">{{$report_test_particular->unit}}</td>
	<td style="text-align: center">{{$report_test_particular->low_range.' - '.$report_test_particular->high_range}}</td>
	</tr>

@endif
@else
@if(!empty($report_test_particular->result))
<tr style="height: 2px;">


</tr>
<tr style="background-color: #eee !important;" >

	<td >{{$report_test_particular->name}}</td>
	<td style="text-align: center">{{$report_test_particular->result}}</td>
	<td style="text-align: center">{{$report_test_particular->unit}}</td>
	<td style="text-align: center">{{$report_test_particular->low_range.' - '.$report_test_particular->high_range}}</td>
	</tr>

@endif
@endif

@endif
@endforeach



@endforeach

				@endif



				</tbody>
			</table>
			<table>
		</div>
			@if(!empty($values->test_comment))
	<div class="clearfix"></div>
	<div class="header" style=" background-color: #eee !important; margin-top:20px; ">
		<h6 style="float: left"><b>Remarks</b></h6>
		<h6 style="">{{$values->test_comment}}</h6>
  </div>
  @endif
		@endforeach
	</div>

		<div class="clearfix"></div>
		@if($top_postion== true)
		<div class="class" style="
		max-width: 900px;
		width: 100%;


		position: absolute;
		left: 0;
		right: 0;

		top: 92%;
		bottom:0;
		">
		@else
		   <div class="class" style="
		max-width: 900px;
		width: 100%;
		height: 250px;
		margin: auto;
		position: absolute;
		left: 0;
		right: 0;
		top: 80%;
		bottom:0;
		">
		  @endif
		<div class="clearfix"></div>



		<p style="text-align:center">Electronically verified by,no signature(s) required.</p>



	<div class="clearfix"></div>

	<div class="header-bottom" style="border-top:solid #000;padding-left:35px;	font-size: 12px;">
		<p >
		<span >DR.IHSAN ULLAH (DHMS.MLT)</span>
		<span style="padding-left:100px; ">ADNAN KHAN (M.PHILL BIO TECH)</span>
		<span style="padding-left:90px;">AZANULLAH (BS MICRO)</span>
		</p>
		<p style="font-size: 8px; ">Developed By  SkyLine Websoultion  Contact us:0342892305</p>
  </div>



    </body>
</html>

















