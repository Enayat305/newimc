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
	font-family: 'Arial Black', 'Gadget', sans-serif;
	
	
}


@media print {
	* {

		
		font-family: 'Arial Black', 'Gadget', sans-serif;
       
	}
	
	


	
}


#invoice-top{min-height:85px;}




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
 

.box {
        display: flex;
		
      }

      .history {
        flex: 1 1 0;
	        
    }


    .three {
        flex: 3 1 0;
       

	   
    }
  




</style>
    <body>
		<div style="height: 1105px;">
		<div id="invoice-top" style=""  >
			
			<img src="{{ url( 'uploads/business_logos/dr attaullah final 22.jpg' ) }}" style="width:100% " alt="Logo">
			
			
		  </div><!--End InvoiceTop-->
		  <h6 ><b>{{'Token No:  '.$receipt_details->appointment->token_no}}</b></h6>
		  <img class="center-block"  src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->contact->contact_id, 'C128', 1,40,array(39, 48, 54), true)}}">
	  <div class="patient_info"  >			
			<table class="meta1"style=""  >
				<tr>
					<th><span >Patient Name</span></th>
					<td ><span class="foo" style="text-transform: uppercase; font-size:16px !important;"><b>{{$receipt_details->contact->name}}</b></span></td>
				</tr>
				
				<tr>
					<th><span >Address</span></th>
					<td><span style="text-transform: uppercase; font-size:16px !important;" >{{$receipt_details->contact->city}}</span></td>
				</tr>
				
				<tr>
					<th><span >Appointment id</span></th>
				<td><span >{{$receipt_details->appointment->appointment_id}}</span></td>
				</tr>
			</table>
			<table class="meta" style="border-bottom: solid #eee">
				<tr>
					<th><span > Date</span></th>
				    <td><span >{{@format_datetime($receipt_details->date)}}</span></td>
				</tr>
				<tr>
					<th><span >Age/Sex</span></th>
					<td><span >{{$receipt_details->contact->age.'   /  '.$receipt_details->contact->gender}}</span></td>
				</tr>
				
				<tr>
					<th><span >Contat No</span></th>
					<td><span >{{$receipt_details->contact->mobile}}</span></td>
				</tr>
				
				
			
			</table>
	  </div>
	
	  <div class="box" style="margin-top: 10px;">
		<div style=" background-color:#B6CBDC !important;height:700px;" class="history">
		  <div  style="padding-left:25px; margin-top: 10px; font-size:20px !important;">
			

				@foreach ($receipt_details->prescription_history as $item)
			  <table >
			  @if(!empty($item->oxygen_saturiation))

				<tr >
					<th ><span >SPO2</span></th>
					<td><span style="padding-left:25px;" ><b>{{''.$item->oxygen_saturiation}}</b></span></td>
				</tr>
				@endif
			    @if(!empty($item->head_circumference))
				<tr style="background-color: #eee !important;">
					<th><span >Head Circumference:</span></th>
					<td><span style="padding-left:25px;"><b>{{''.$item->head_circumference}}</b></span></td>
				</tr>
				@endif
				@if(!empty($item->respiratory_rate))
				<tr >
					<th><span >Respiratory Rate:</span></th>
					<td><span style="padding-left:25px;"><b>{{''.$item->respiratory_rate}}</b></span></td>
				</tr>
				@endif
				<tr style="background-color: #eee !important;">
					<th><span >Temp:</span></th>
					<td><span style="padding-left:25px;"><b>{{$item->temperature.' F'}}</b></span></td>
				</tr>
				@if(!empty($item->height))

				<tr >
					<th><span >Height:</span></th>
					<td><span style="padding-left:25px;"><b>{{''.$item->height.'FT'}}</b></span></td>
				</tr>
				@endif
				<tr style="">
					<th><span >Weight:</span></th>
					<td><span style="padding-left:25px;"><b>{{''.$item->weight.' KG'}}</b></span></td>
				</tr>
				@if(!empty($item->heart_rate))
				<tr>
					<th><span >P.Rate:</span></th>
					<td><span style="padding-left:25px;"><b>{{' '.$item->heart_rate.'BPM'}}</b></span></td>
				</tr>
				@endif
				@if(!empty($item->$item->body_mass))

				<tr style="background-color: #eee !important;"> 
					<th><span >Body Mass:</span></th>
					<td><span style="padding-left:25px;"><b>{{''.$item->body_mass.'KG'}}</b></span></td>
				</tr>
				@endif
				@if(!empty($item->$item->body_fat_per))

				<tr  >
					<th><span >Body Fat Per:</span></th>
					<td><span >{{''.$item->body_fat_per}}</span></td>
				</tr>
				@endif
				@if(!empty($item->systole ))

				<tr style="background-color: #eee !important;">
					<th ><span style="text-align: center ;" >BP </span></th>
					<td><span style="padding-left:15px;"><b>{{''.$item->systole .' /'.$item->diastole}}</b></span></td>

				</tr>
			
				@endif
			  </table>

				@endforeach
				
				<div style="margin-top:20px ;
				width: 200px;
				overflow-wrap: break-word;
			   ">
					<span style=""><b>Clanical Record</b></span>
					{!!$receipt_details->clinical_record !!}
				</div>
			@if (!empty($receipt_details->test))
			  <div style="margin-top:20px ">
				<table >
					<tr >
						<th><span style="">Pathology examination</span></th>
						</tr>
					@foreach ($receipt_details->test as $test)
					@foreach ($tests as $item)
						
					
					@if ($test ==$item->id)
					
					<tr >
						<td style="border: solid #eee !important;"><span style="font-size: 10px">{{$item->name}}</span></td>
						</tr>
					
					
	
					@endif
					
					@endforeach
					@endforeach
					

				</table>
			</div>
			@endif
			</div>	
		</div>
        
        <div class="three">
			@if (!empty($receipt_details->validity))		
    	<div class="header" style=" background-color: #eee !important; margin-top:5px;">
				<h6>Not Valid For Medico Legal Purpose</h6>
		  </div>
		  @endif
		
			  
		 
		<div class="yellow-square" style=";
			margin-top:30px;
			">
			
			<div class="table-responsive">
				@if (!empty($receipt_details->medicine)) 
				<table style="width: 100%; "id="test_particular_entry_table">
				
					<tbody>
						<thead>
							<tr style="background-color: #B6CBDC !important;">
								
							<th style="rwidth: 25%">Medicine</th>
							<th style="text-align: center;width: 25%">Frequency</th>
							<th style="text-align: center;width: 25%">Days</th>
							<th style="text-align: center;width: 25%">Instruction</th>
							
						</tr>	
						</thead>
					</tbody>
					@foreach ($receipt_details->medicine  as $items)

					<tr class="blank_row" style="height: 10px !important;">
						<td colspan="4"></td>
					</tr>	
						
			<tr style="background-color: #eee !important;">
        
        <td>
         {{$items['product_name']}}
        </td>
       
			<td style="text-align: center">{{ $items['frequency']}}</td>

        
			<td style="text-align: center">{{ $items['day']}}</td>

       
        
			<td style="text-align: center">{{$items['instruction']}}</td>

        
        
	</tr>	
					@endforeach
					
			
			
				</table>

				@endif
			
				@if (!empty($receipt_details->advice))
				<div class="header" style=" background-color: #B6CBDC !important; margin-top:50px;">
					<h3>Advice</h3>
			  </div>
			  <div class="header">
				{!! $receipt_details->advice !!}
			 </div>
			 
			 @endif
			 
		</div>
	
		</div>
      </div>

	  <div class="class" style=" 
	  max-width: 900px;
	  width: 100%;
	  position: absolute;
	  left: 0;
	  right: 0;
	  top: 85%;
	  bottom:0;
	  background-color: #B6CBDC !important
	  ">
	
	<img src="{{ url( 'uploads/business_logos/dr attaullah final333.jpg' ) }}" style="width:100%;  " alt="Logo">
	  <h6 style="background-color: #B6CBDC !important">Developed by Ayan softlimited Contact us:0342892305</h6>
	  </div>
	</body>
</html>
