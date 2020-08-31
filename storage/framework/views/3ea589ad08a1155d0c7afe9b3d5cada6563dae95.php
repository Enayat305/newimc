<?php $__currentLoopData = $sell_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	

<tr class="product_row">
	<td>
		<input type="checkbox" class="row-select" value="<?php echo e($item->id, false); ?>">
	</td>
	<td>
		<?php echo e($item->tests->name, false); ?>

	</td>
	<td>
		<?php echo e($item->report_code, false); ?>

	</td>
	<td class="text-center">
		<button data-href="<?php echo e(action('Lab\Multi_ReportController@edit', [$item->id]), false); ?>" class="btn btn-xs btn-primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i> <?php echo app('translator')->getFromJson("messages.edit"); ?></button>
	</td>
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/multi_tests_report/product_row.blade.php ENDPATH**/ ?>