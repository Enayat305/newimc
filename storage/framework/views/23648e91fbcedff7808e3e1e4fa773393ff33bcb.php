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


@media  print {
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
				<img src="<?php echo e(url( 'uploads/business_logos/Lab_Title.jpg' ), false); ?>" style="
				 width: 100%;
				 margin-top:10px;
				 " alt="Logo">
			</div>
			<div >



			</div><!--End Info-->

		  </div><!--End InvoiceTop-->

		  <img class="center-block" src="data:image/png;base64,<?php echo e(DNS1D::getBarcodePNG($code, 'C128', 1,40,array(39, 48, 54), true), false); ?>">
	  <div class="patient_info"  >
			<table class="meta1"style="border-bottom: solid #eee;text-transform: uppercase;"  >

				<?php $__currentLoopData = $receipt_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				<?php if($key ==0): ?>

				<tr>
				   <th><span >Patient Name</span></th>
				   <td><span ><?php echo e($value->contact->name, false); ?></span></td>
				</tr>
				<tr>
				   <th><span >Age/Sex</span></th>
				   <td><span ><?php echo e($value->contact->age.'   /  '.$value->contact->gender, false); ?></span></td>
				</tr>
				<tr>
				   <th><span >Address</span></th>
				   <td><span ><?php echo e($value->contact->city, false); ?></span></td>
				</tr>
				<tr>
				   <th><span >Contat No</span></th>
				   <td><span ><?php echo e($value->contact->mobile, false); ?></span></td>
				</tr>
				<tr>
				   <th><span >MR #</span></th>
				<td><span ><?php echo e($value->contact->contact_id, false); ?></span></td>
				</tr>
				</table>
				<table class="meta" style="border-bottom: solid #eee">
				<tr>
				   <th><span >Reported Dated</span></th>
				   <td><span ><?php echo e(\Carbon::createFromTimestamp(strtotime($value->reported_dated))->format(session('business.date_format') . ' ' . 'h:i A'), false); ?></span></td>
				</tr>
				<tr>
				   <th><span >Receipt Date</span></th>
				   <td><span ><?php echo e(\Carbon::createFromTimestamp(strtotime($value->transaction->transaction_date))->format(session('business.date_format') . ' ' . 'h:i A'), false); ?></span></td>
				</tr>
				<tr>

				   <th><span >Invoice #</span></th>
				   <td><span ><?php echo e($value->transaction->invoice_no, false); ?></span></td>
				</tr>
				<tr>
				   <th><span >Specimen</span></th>
				   <td><span ><?php echo e($value->tests->sample_require, false); ?></span></td>
				</tr>
				<tr>
				   <th><span >Ref By</span></th>
				   <td><span> <?php echo e($value->doctor->surname.' '.$value->doctor->first_name.' '.$value->doctor->last_name, false); ?></span></td>
				</tr>

				<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			</table>
	  </div>


	  <div class="clearfix"></div>
	    
  <?php
		$length = count($result);
  ?>
  <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if($length == 1): ?>
  <div class="header" style=" background-color: #eee !important; ">
	<h3><?php echo e($item, false); ?></h3>
</div>  
  <?php endif; ?>
  
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <?php $__currentLoopData = $receipt_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="table-responsive">
			<table style="width: 100%; "id="test_particular_entry_table">
			    
				<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($dep == $values->departments->name): ?>
				
				<?php else: ?>
				<!-- <div class="header" style=" background-color: #eee !important; ">
					<h3><?php echo e($values->departments->name, false); ?></h3>
			  </div> -->
				<?php endif; ?>
				
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
		  <div class="header" style=" background-color: #eee !important; ">
			<h5><b><?php echo e($values->tests->name, false); ?></b></h5>
	  </div>
				<tbody>
					<?php if($values->test_id==34 || $values->test_id==35): ?>
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
					<?php else: ?>
					<thead>
						<tr style="background-color: #eee !important;">

						<th style="rwidth: 30%">Test Descriptions</th>
						<th style="text-align: center;width: 25%">Result</th>
						<th style="text-align: center;width: 20%">Unit</th>
						<th style="text-align: center;width: 25%">Normal Range</th>

					</tr>
					</thead>
					<?php endif; ?>
					
				</tbody>
                <?php if($values->test_id==34 || $values->test_id==35): ?>
				<?php $__currentLoopData = $values->tests->test_head; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php $__currentLoopData = $values->report_test_particular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report_test_particular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($item->report_head_id == $report_test_particular->report_head_id): ?>
				
				<?php if($loop->index%2==0): ?>
				<?php if(!empty($report_test_particular->result)): ?>
				<tr  >
				  
					<td ><?php echo e($report_test_particular->name, false); ?></td>
					<td  style="text-align: center"><?php echo e($report_test_particular->result, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->unit, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->male, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->female, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->high_range, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->low_range, false); ?></td>
				  
				</tr>
				<?php endif; ?> 
				<?php else: ?>
				<tr>
				<td colspan="7"><div class="clearfix"></div>
					<div class="header" style="display:none">
						.
				</div></td>
				</tr>
				<?php if(!empty($report_test_particular->result)): ?>
				<tr style="background-color: #eee !important;" >
			
					<td ><?php echo e($report_test_particular->name, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->result, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->unit, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->male, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->female, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->high_range, false); ?></td>
					<td style="text-align: center"><?php echo e($report_test_particular->low_range, false); ?></td>

					</tr>	
					<?php endif; ?>
				<?php endif; ?>
			
				<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php else: ?>
					
				<?php $__currentLoopData = $values->tests->test_head; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr style="height: 3px;">


				</tr>
<tr style="">
	<th colspan="4">  <div class="clearfix"></div>
	<p style="background-color: #eee !important;"><b><?php echo e($item->reports_head->name, false); ?></b></p>

	</th>

</tr>
<?php $__currentLoopData = $values->report_test_particular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report_test_particular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(!empty($report_test_particular->result)): ?>
<?php endif; ?>
<?php if($item->report_head_id == $report_test_particular->report_head_id): ?>

<?php if($loop->index%2==0): ?>
<?php if(!empty($report_test_particular->result)): ?>
<tr style="height: 1px;">


</tr>
<tr  >

	<td ><?php echo e($report_test_particular->name, false); ?></td>
	<td style="text-align: center"><?php echo e($report_test_particular->result, false); ?></td>
	<td style="text-align: center"><?php echo e($report_test_particular->unit, false); ?></td>
	<td style="text-align: center"><?php echo e($report_test_particular->low_range.' - '.$report_test_particular->high_range, false); ?></td>
	</tr>

<?php endif; ?>
<?php else: ?>
<?php if(!empty($report_test_particular->result)): ?>
<tr style="height: 2px;">


</tr>
<tr style="background-color: #eee !important;" >

	<td ><?php echo e($report_test_particular->name, false); ?></td>
	<td style="text-align: center"><?php echo e($report_test_particular->result, false); ?></td>
	<td style="text-align: center"><?php echo e($report_test_particular->unit, false); ?></td>
	<td style="text-align: center"><?php echo e($report_test_particular->low_range.' - '.$report_test_particular->high_range, false); ?></td>
	</tr>

<?php endif; ?>
<?php endif; ?>

<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php endif; ?>



				</tbody>
			</table>
			<table>
		</div>
			<?php if(!empty($values->test_comment)): ?>
	<div class="clearfix"></div>
	<div class="header" style=" background-color: #eee !important; margin-top:20px; ">
		<h6 style="float: left"><b>Remarks</b></h6>
		<h6 style=""><?php echo e($values->test_comment, false); ?></h6>
  </div>
  <?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>

		<div class="clearfix"></div>
		<?php if($top_postion== true): ?>
		<div class="class" style="
		max-width: 900px;
		width: 100%;


		position: absolute;
		left: 0;
		right: 0;

		top: 92%;
		bottom:0;
		">
		<?php else: ?>
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
		  <?php endif; ?>
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

















<?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/tests_report/multislim.blade.php ENDPATH**/ ?>