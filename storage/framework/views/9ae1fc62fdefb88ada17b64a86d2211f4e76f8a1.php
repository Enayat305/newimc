<?php $__env->startSection('title', __('home.home')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1><?php echo e(__('home.welcome_message', ['name' => Session::get('user.first_name')]), false); ?>

    </h1>
</section>
<?php if(auth()->user()->can('lab_dashboard.data')): ?>
<!-- Main content -->
<section class="content content-custom no-print">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="btn-group pull-right" data-toggle="buttons">
				<label class="btn btn-info active">
    				<input type="radio" name="date-filter"
    				data-start="<?php echo e(date('Y-m-d'), false); ?>" 
    				data-end="<?php echo e(date('Y-m-d'), false); ?>"
    				checked> <?php echo e(__('home.today'), false); ?>

  				</label>
  				<label class="btn btn-info">
    				<input type="radio" name="date-filter"
    				data-start="<?php echo e($date_filters['this_week']['start'], false); ?>" 
    				data-end="<?php echo e($date_filters['this_week']['end'], false); ?>"
    				> <?php echo e(__('home.this_week'), false); ?>

  				</label>
  				<label class="btn btn-info">
    				<input type="radio" name="date-filter"
    				data-start="<?php echo e($date_filters['this_month']['start'], false); ?>" 
    				data-end="<?php echo e($date_filters['this_month']['end'], false); ?>"
    				> <?php echo e(__('home.this_month'), false); ?>

  				</label>
  				<label class="btn btn-info">
    				<input type="radio" name="date-filter" 
    				data-start="<?php echo e($date_filters['this_fy']['start'], false); ?>" 
    				data-end="<?php echo e($date_filters['this_fy']['end'], false); ?>" 
    				> <?php echo e(__('home.this_fy'), false); ?>

  				</label>
            </div>
		</div>
	</div>
	<br>
	<div class="row row-custom">
    	<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon bg-aqua"><i class="ion ion-cash"></i></span>

	        <div class="info-box-content">
	          <span class="info-box-text"><?php echo e(__('home.total_purchase'), false); ?></span>
	          <span class="info-box-number total_purchase"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

	        <div class="info-box-content">
	          <span class="info-box-text"><?php echo e(__('home.total_sell'), false); ?></span>
	          <span class="info-box-number total_sell"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon bg-yellow">
	        	<i class="fa fa-dollar"></i>
				<i class="fa fa-exclamation"></i>
	        </span>

	        <div class="info-box-content">
	          <span class="info-box-text"><?php echo e(__('home.purchase_due'), false); ?></span>
	          <span class="info-box-number purchase_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->

	    <!-- fix for small devices only -->
	    <!-- <div class="clearfix visible-sm-block"></div> -->
	    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon bg-yellow">
	        	<i class="ion ion-ios-paper-outline"></i>
	        	<i class="fa fa-exclamation"></i>
	        </span>

	        <div class="info-box-content">
	          <span class="info-box-text"><?php echo e(__('home.invoice_due'), false); ?></span>
	          <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
  	</div>
  	<div class="row row-custom">
        <!-- expense -->
        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
          <div class="info-box info-box-new-style">
            <span class="info-box-icon bg-red">
              <i class="fas fa-minus-circle"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">
                <?php echo e(__('lang_v1.expense'), false); ?>

              </span>
              <span class="info-box-number total_expense"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    </div>
    <?php if(!empty($widgets['after_sale_purchase_totals'])): ?>
      <?php $__currentLoopData = $widgets['after_sale_purchase_totals']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $widget; ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  	<!-- sales chart start -->
  	<div class="row">
  		<div class="col-sm-12">
            <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')]); ?>
              <?php echo $sells_chart_1->container(); ?>

            <?php echo $__env->renderComponent(); ?>
  		</div>
  	</div>
    <?php if(!empty($widgets['after_sales_last_30_days'])): ?>
      <?php $__currentLoopData = $widgets['after_sales_last_30_days']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $widget; ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  	
  	
  	<!-- products less than alert quntity -->
  	<div class="row">

      <div class="col-sm-6">
        <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
          <?php $__env->slot('icon'); ?>
            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
          <?php $__env->endSlot(); ?>
          <?php $__env->slot('title'); ?>
            <?php echo e(__('lang_v1.sales_payment_dues'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.tooltip_sales_payment_dues') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
          <?php $__env->endSlot(); ?>
          <table class="table table-bordered table-striped" id="sales_payment_dues_table">
            <thead>
              <tr>
                <th><?php echo app('translator')->getFromJson( 'contact.customer' ); ?></th>
                <th><?php echo app('translator')->getFromJson( 'sale.invoice_no' ); ?></th>
                <th><?php echo app('translator')->getFromJson( 'home.due_amount' ); ?></th>
              </tr>
            </thead>
          </table>
        <?php echo $__env->renderComponent(); ?>
      </div>

  		<div class="col-sm-6">

        <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
          <?php $__env->slot('icon'); ?>
            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
          <?php $__env->endSlot(); ?>
          <?php $__env->slot('title'); ?>
            <?php echo e(__('lang_v1.purchase_payment_dues'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.payment_dues') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
          <?php $__env->endSlot(); ?>
          <table class="table table-bordered table-striped" id="purchase_payment_dues_table">
            <thead>
              <tr>
                <th><?php echo app('translator')->getFromJson( 'purchase.supplier' ); ?></th>
                <th><?php echo app('translator')->getFromJson( 'purchase.ref_no' ); ?></th>
                        <th><?php echo app('translator')->getFromJson( 'home.due_amount' ); ?></th>
              </tr>
            </thead>
          </table>
        <?php echo $__env->renderComponent(); ?>

  		</div>
    </div>

    <div class="row">
      
      <div class="col-sm-6">
        <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
          <?php $__env->slot('icon'); ?>
            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
          <?php $__env->endSlot(); ?>
          <?php $__env->slot('title'); ?>
            <?php echo e(__('home.product_stock_alert'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.product_stock_alert') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
          <?php $__env->endSlot(); ?>
          <table class="table table-bordered table-striped" id="stock_alert_table">
            <thead>
              <tr>
                <th><?php echo app('translator')->getFromJson( 'sale.product' ); ?></th>
                <th><?php echo app('translator')->getFromJson( 'business.location' ); ?></th>
                        <th><?php echo app('translator')->getFromJson( 'report.current_stock' ); ?></th>
              </tr>
            </thead>
          </table>
        <?php echo $__env->renderComponent(); ?>
      </div>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lab_stock_report.view')): ?>
        <?php if(session('business.enable_product_expiry') == 1): ?>
          <div class="col-sm-6">
              <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                  <?php $__env->slot('icon'); ?>
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                  <?php $__env->endSlot(); ?>
                  <?php $__env->slot('title'); ?>
                    <?php echo e(__('home.stock_expiry_alert'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.stock_expiry_alert', [ 'days' =>session('business.stock_expiry_alert_days', 30) ]) . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                  <?php $__env->endSlot(); ?>
                  <input type="hidden" id="stock_expiry_alert_days" value="<?php echo e(\Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d'), false); ?>">
                  <table class="table table-bordered table-striped" id="stock_expiry_alert_table">
                    <thead>
                      <tr>
                          <th><?php echo app('translator')->getFromJson('business.product'); ?></th>
                          <th><?php echo app('translator')->getFromJson('business.location'); ?></th>
                          <th><?php echo app('translator')->getFromJson('report.stock_left'); ?></th>
                          <th><?php echo app('translator')->getFromJson('product.expires_in'); ?></th>
                      </tr>
                    </thead>
                  </table>
              <?php echo $__env->renderComponent(); ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
  	</div>

    <?php if(!empty($widgets['after_dashboard_reports'])): ?>
      <?php $__currentLoopData = $widgets['after_dashboard_reports']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $widget; ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</section>
<!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(asset('js/labhome.js?v=' . $asset_v), false); ?>"></script>
    <?php echo $sells_chart_1->script(); ?>

    <?php echo $sells_chart_2->script(); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('lab_layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/home/index.blade.php ENDPATH**/ ?>