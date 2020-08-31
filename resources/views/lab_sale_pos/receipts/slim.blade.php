<!-- business information here -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- <link rel="stylesheet" href="style.css"> -->
        <title>Receipt-{{$receipt_details->invoice_no}}</title>
    </head>
    <body style="width: 80mm;max-width: 80mm;">
        
		@if(!empty($receipt_details->logo))
		<img class="logo" src="{{$receipt_details->logo}}" alt="Logo">
	@endif
        <div class="ticket" style="width: 80mm;max-width: 80mm;">
		
        	<div class="text-box">
        
        	<!-- Logo -->
            <p class="@if(!empty($receipt_details->logo)) text-with-image @else centered @endif">
            	<!-- Header text -->
            	@if(!empty($receipt_details->header_text))
            		<span class="headings">{!! $receipt_details->header_text !!}</span>
					<br/>
				@endif

				<!-- business information here -->
				@if(!empty($receipt_details->display_name))
					<span class="headings">
						{{$receipt_details->display_name}}
					</span>
					<br/>
				@endif
				
				@if(!empty($receipt_details->address))
					{!! $receipt_details->address !!}
					<br/>
				@endif

				
				@if(!empty($receipt_details->contact))
					<br/><b>{{ $receipt_details->contact }}</b>
				@endif
				@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
					, 
				@endif
				@if(!empty($receipt_details->website))
					{{ $receipt_details->website }}
				@endif
				@if(!empty($receipt_details->location_custom_fields))
					<br>{{ $receipt_details->location_custom_fields }}
				@endif
				

				@if(!empty($receipt_details->sub_heading_line1))
					{{ $receipt_details->sub_heading_line1 }}<br/>
				@endif
				@if(!empty($receipt_details->sub_heading_line2))
					{{ $receipt_details->sub_heading_line2 }}<br/>
				@endif
				@if(!empty($receipt_details->sub_heading_line3))
					{{ $receipt_details->sub_heading_line3 }}<br/>
				@endif
				@if(!empty($receipt_details->sub_heading_line4))
					{{ $receipt_details->sub_heading_line4 }}<br/>
				@endif		
				@if(!empty($receipt_details->sub_heading_line5))
					{{ $receipt_details->sub_heading_line5 }}<br/>
				@endif

				@if(!empty($receipt_details->tax_info1))
					<b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
				@endif

				@if(!empty($receipt_details->tax_info2))
					<b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
				@endif

				<!-- Title of receipt -->
				@if(!empty($receipt_details->invoice_heading))
					<br/><span class="invoice-headings"><strong>{!! $receipt_details->invoice_heading !!}</strong></span>
				@endif
			</p>
			</div>
			
			<table class="table-info border-top">
				<tr>
					<th>{!! $receipt_details->invoice_no_prefix !!}</th>
					<td style="padding-right: 90px;">
						<b>{{$receipt_details->invoice_no}}</b>
					</td>
				</tr>
				<tr>
					<th>{!! $receipt_details->date_label !!}</th>
					<td >
						<b>{{$receipt_details->invoice_date}}</b>
					</td>
				</tr>

				@if(!empty($receipt_details->due_date_label))
					<tr>
						<th>{{$receipt_details->due_date_label}}</th>
						<b><td>{{$receipt_details->due_date ?? ''}}</td></b>
					</tr>
				@endif

				@if(!empty($receipt_details->sales_person_label))
					<tr>
						<th>Lab Tech</th>
					
					<td style="padding-right: 12px;"><b>{{$receipt_details->sales_person}}</b></td>
					</tr>
				@endif

	        

		        <!-- customer info -->
		        <tr>
		        	<th>
		        		{{$receipt_details->customer_label}}
		        	</th>

		        	<td>
		        		<b>{{ $receipt_details->customer_name }}</b>

		        		{{-- 
		        		@if(!empty($receipt_details->customer_info))
							{!! $receipt_details->customer_info !!}
						@endif
						--}}
		        	</td>
		        </tr>
				
				@if(!empty($receipt_details->client_id_label))
					<tr>
						<th>
							{{ $receipt_details->client_id_label }}
						</th>
						<td>
							{{ $receipt_details->client_id }}
						</td>
					</tr>
				@endif
				
				@if(!empty($receipt_details->customer_tax_label))
					<tr>
						<th>
							{{ $receipt_details->customer_tax_label }}
						</th>
						<td>
							{{ $receipt_details->customer_tax_number }}
						</td>
					</tr>
				@endif

				@if(!empty($receipt_details->customer_custom_fields))
					<tr>
						<td colspan="2">
							{{ $receipt_details->customer_custom_fields }}
						</td>
					</tr>
				@endif
				
				@if(!empty($receipt_details->customer_rp_label))
					<tr>
						<th>
							{{ $receipt_details->customer_rp_label }}
						</th>
						<td>
							{{ $receipt_details->customer_total_rp }}
						</td>
					</tr>
				@endif
			</table>

			<div class="product_area" style="width:100%">
            <table style="padding-top: 5px !important;" class="border-bottom width-100">
                <thead class="border-bottom-dotted">
                    <tr>
                        <th class="serial_number">#</th>
                        <th class="">
                        	Test Name
                        </th>
                        <th class="unit_price text-right" style="padding-right: 20px;">
                        	Price
                        </th>
                    </tr>
                </thead>
                <tbody>
					@forelse($receipt_details->lines as $line)
	                    <tr>
	                        <td class="serial_number">
	                        	{{$loop->iteration}}
	                        </td>
	                        <td class="">
	                        	{{$line->tests->name}}
	                        </td>
							<td class="unit_price">
								<span class="display_currency " data-currency_symbol="true">{{$line->final_total}}</span>	
	                        </td>
	                    </tr>
                    @endforeach
                    <tr>
                    	<td colspan="5">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table class="border-bottom width-100">
            
                <tr>
                    <th class="left text-right sub-headings">
                    	{!! $receipt_details->subtotal_label !!}
                    </th>
                    <td class="width-50 text-right sub-headings">
                    	{{$receipt_details->subtotal}}
                    </td>
                </tr>

                <!-- Shipping Charges -->
				@if(!empty($receipt_details->shipping_charges))
					<tr>
						<td class="left text-right">
							{!! $receipt_details->shipping_charges_label !!}
						</td>
						<td class="width-50 text-right">
							{{$receipt_details->shipping_charges}}
						</td>
					</tr>
				@endif

				<!-- Discount -->
				@if( !empty($receipt_details->discount) )
					<tr>
						<td class="width-50 text-right">
							{!! $receipt_details->discount_label !!}
						</td>

						<td class="width-50 text-right">
							<b>(-) {{$receipt_details->discount}}</b>
						</td>
					</tr>
				@endif

				@if( !empty($receipt_details->tax) )
					<tr>
						<td class="width-50 text-right">
							{!! $receipt_details->tax_label !!}
						</td>
						<td class="width-50 text-right">
							(+) {{$receipt_details->tax}}
						</td>
					</tr>
				@endif

				@if( !empty($receipt_details->round_off_label) )
					<tr>
						<td class="width-50 text-right">
							{!! $receipt_details->round_off_label !!}
						</td>
						<td class="width-50 text-right">
							{{$receipt_details->round_off}}
						</td>
					</tr>
				@endif

				<tr>
					<th class="width-50 text-right sub-headings">
						{!! $receipt_details->total_label !!}
					</th>
					<td class="width-50 text-right sub-headings">
						<b>{{$receipt_details->total}}</b>
					</td>
				</tr>

				@if(!empty($receipt_details->payments))
					@foreach($receipt_details->payments as $payment)
						<tr>
							<td class="width-50 text-right"><b>{{$payment['method']}} ({{$payment['date']}})</b></td>
							<td class="width-50 text-right"><b>{{$payment['amount']}}</b></td>
						</tr>
					@endforeach
				@endif

				<!-- Total Paid-->
				@if(!empty($receipt_details->total_paid))
					<tr>
						<td class="width-50 text-right">
							<b>{!! $receipt_details->total_paid_label !!}</b>
						</td>
						<td class="width-50 text-right">
							<b>{{$receipt_details->total_paid}}</b>
						</td>
					</tr>
				@endif

				<!-- Total Due-->
				@if(!empty($receipt_details->total_due))
					<tr>
						<td class="width-50 text-right">
							{!! $receipt_details->total_due_label !!}
						</td>
						<td class="width-50 text-right">
							<b>{{$receipt_details->total_due}}</b>
						</td>
					</tr>
				@endif

				@if(!empty($receipt_details->all_due))
					<tr>
						<td class="width-50 text-right">
							<b>{!! $receipt_details->all_bal_label !!}</b>
						</td>
						<td class="width-50 text-right">
							<b>{{$receipt_details->all_due}}</b>
						</td>
					</tr>
				@endif
            </table>

            <!-- tax -->
            @if(!empty($receipt_details->taxes))
            	<table class="border-bottom width-100">
            		@foreach($receipt_details->taxes as $key => $val)
            			<tr>
            				<td class="left">{{$key}}</td>
            				<td class="right">{{$val}}</td>
            			</tr>
            		@endforeach
            	</table>
            @endif


            @if(!empty($receipt_details->additional_notes))
	            <p class="centered" >
	            	{{$receipt_details->additional_notes}}
	            </p>
            @endif

            {{-- Barcode --}}
			@if($receipt_details->show_barcode)
				<br/>
				<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
			@endif

			@if(!empty($receipt_details->footer_text))
				<p class="centered">
					{!! $receipt_details->footer_text !!}
				</p>
			@endif
		</div>
        </div>
    </body>
</html>

<style type="text/css">
@page {
    margin: 5mm;
	padding: 1mm;
	* {
    	font-size: 12px;
		max-width: 80mm;
		width:80mm;
    	
	}
	 
}
@media print {
	* {
    	font-size: 12px;
     	
    	max-width: 80mm;
		width: 80mm;
	}


.headings{
	font-size: 18px;
	font-weight: 700;
	text-transform: uppercase;
}

.sub-headings{
	font-size: 15px;
	font-weight: 700;
}

.border-top{
    border-top: 1px solid #242424;
}
.border-bottom{
	border-bottom: 1px solid #242424;
}

.border-bottom-dotted{
	border-bottom: 1px dotted darkgray;
}
.border-bottom-body{
	border-bottom: 1px solid darkgray;
}
td.serial_number, th.serial_number{
	width: 5%;
    max-width: 5%;
}

td.description,
th.description {
    width: 35%;
    max-width: 35%;
   
}

td.quantity,
th.quantity {
    width: 15%;
    max-width: 15%;
   
}
td.unit_price, th.unit_price{
	width: 25%;
    max-width: 25%;
   
}

td.price,
th.price {
    width: 20%;
    max-width: 20%;
   
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 80mm;
    max-width: 80mm;
}


img {
    max-width: inherit;
    width: auto;
}

    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
.table-info {
	width: 100%;
}
.table-info tr:first-child td, .table-info tr:first-child th {
	padding-top: 8px;
}
.table-info th {
	text-align: left;
}
.table-info td {
	text-align: right;
}
.logo {
	float: left;
	width:35%;
	padding: 10px;
}

.text-with-image {
	float: left;
	width:65%;
}
.text-box {
	width: 100%;
	height: auto;
}
</style>