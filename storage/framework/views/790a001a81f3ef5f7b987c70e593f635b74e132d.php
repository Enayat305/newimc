<link rel="stylesheet" href="<?php echo e(asset('css/vendor.css?v='.$asset_v), false); ?>">

<?php if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ): ?>
	<link rel="stylesheet" href="<?php echo e(asset('css/rtl.css?v='.$asset_v), false); ?>">
<?php endif; ?>

<?php echo $__env->yieldContent('css'); ?>

<!-- app css -->
<link rel="stylesheet" href="<?php echo e(asset('css/app.css?v='.$asset_v), false); ?>">

<?php if(isset($pos_layout) && $pos_layout): ?>
	<style type="text/css">
		.content{
			padding-bottom: 0px !important;
		}
	</style>
<?php endif; ?>

<?php if(!empty($__system_settings['additional_css'])): ?>
    <style type="text/css">
        <?php echo $__system_settings['additional_css']; ?>

    </style>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newimc\resources\views/lab_layouts/partials/css.blade.php ENDPATH**/ ?>