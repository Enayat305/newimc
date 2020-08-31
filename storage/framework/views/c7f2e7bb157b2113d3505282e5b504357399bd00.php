<?php $request = app('Illuminate\Http\Request'); ?>
<!-- Main Header -->
  <header class="main-header no-print">
    <a href="<?php echo e(route('lab_home'), false); ?>" class="logo">
      
      <span class="logo-lg"><?php echo e(Session::get('business.name'), false); ?></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        &#9776;
        <span class="sr-only">Toggle navigation</span>
      </a>
      <a href="<?php echo e(route('lab_home'), false); ?>" class="logo">
      
        <span class="logo-lg">LABORATORY</span>
      </a>
      <?php if(Module::has('Superadmin')): ?>
        <?php if ($__env->exists('superadmin::lab_layouts.partials.active_subscription')) echo $__env->make('superadmin::lab_layouts.partials.active_subscription', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">

        <?php if(Module::has('Essentials')): ?>
          <?php if ($__env->exists('essentials::layouts.partials.header_part')) echo $__env->make('essentials::layouts.partials.header_part', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <button id="btnCalculator" title="<?php echo app('translator')->getFromJson('lang_v1.calculator'); ?>" type="button" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10 popover-default" data-toggle="popover" data-trigger="click" data-content='<?php echo $__env->make("lab_layouts.partials.calculator", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>' data-html="true" data-placement="bottom">
            <strong><i class="fa fa-calculator fa-lg" aria-hidden="true"></i></strong>
        </button>
        
        <?php if($request->segment(1) == 'los'): ?>
          <button type="button" id="register_details" title="<?php echo e(__('cash_register.register_details'), false); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10 btn-modal" data-container=".register_details_modal" 
          data-href="<?php echo e(action('Lab\CashRegisterController@getRegisterDetail'), false); ?>">
            <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
          </button>
          <button type="button" id="close_register" title="<?php echo e(__('cash_register.close_register'), false); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-danger btn-flat pull-left m-8 hidden-xs btn-sm mt-10 btn-modal" data-container=".close_register_modal" 
          data-href="<?php echo e(action('Lab\CashRegisterController@getCloseRegister'), false); ?>">
            <strong><i class="fa fa-window-close fa-lg"></i></strong>
          </button>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lab_sell.create')): ?>
          <a href="<?php echo e(action('Lab\SellPosController@create'), false); ?>" title="POS" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10">
            <strong><i class="fa fa-th-large"></i> &nbsp; <?php echo app('translator')->getFromJson('sale.pos_sale'); ?></strong>
          </a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profit_loss_report.view')): ?>
          <button type="button" id="view_todays_profit" title="<?php echo e(__('home.todays_profit'), false); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10">
            <strong><i class="fas fa-money-bill-alt fa-lg"></i></strong>
          </button>
        <?php endif; ?>

        <!-- Help Button -->
        <?php if(auth()->user()->hasRole('Admin#' . auth()->user()->business_id)): ?>
          <button type="button" id="start_tour" title="<?php echo app('translator')->getFromJson('lang_v1.application_tour'); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10">
            <strong><i class="fa fa-question-circle fa-lg" aria-hidden="true"></i></strong>
          </button>
        <?php endif; ?>

        <div class="m-8 pull-left mt-15 hidden-xs" style="color: #fff;"><strong><?php echo e(\Carbon::createFromTimestamp(strtotime('now'))->format(session('business.date_format')), false); ?></strong></div>

        <ul class="nav navbar-nav">
          <?php echo $__env->make('lab_layouts.partials.header-notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?php
                $profile_photo = auth()->user()->media;
              ?>
              <?php if(!empty($profile_photo)): ?>
                <img src="<?php echo e($profile_photo->display_url, false); ?>" class="user-image" alt="User Image">
              <?php endif; ?>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span><?php echo e(Auth::User()->first_name, false); ?> <?php echo e(Auth::User()->last_name, false); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <?php if(!empty(Session::get('business.logo'))): ?>
                  <img src="<?php echo e(url( 'uploads/business_logos/' . Session::get('business.logo') ), false); ?>" alt="Logo"></span>
                <?php endif; ?>
                <p>
                  <?php echo e(Auth::User()->first_name, false); ?> <?php echo e(Auth::User()->last_name, false); ?>

                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo e(action('UserController@getProfile'), false); ?>" class="btn btn-default btn-flat"><?php echo app('translator')->getFromJson('lang_v1.profile'); ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo e(action('Auth\LoginController@logout'), false); ?>" class="btn btn-default btn-flat"><?php echo app('translator')->getFromJson('lang_v1.sign_out'); ?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header><?php /**PATH C:\xampp\htdocs\newimc\resources\views/lab_layouts/partials/header.blade.php ENDPATH**/ ?>