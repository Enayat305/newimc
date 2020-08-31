<?php $__env->startSection('title', '45'); ?>
<?php $__env->startSection('content'); ?>

<div class="container" style="background-color:#fff;" >
    <div class="spacer"></div>
    <div class="row">
        <div class="col-md-12 text-right" >
            <button type="button" class="btn btn-primary no-print" id="print_invoice" 
                 aria-label="Print"><i class="fas fa-print"></i> <?php echo app('translator')->getFromJson( 'messages.print' ); ?>
            </button>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(action('Lab\TestReportController@index'), false); ?>" class="btn btn-success no-print" ><i class="fas fa-backward"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-9 col-sm-9" style="border: 1px solid #ccc; margin-left:50px">
            <div class="spacer"></div>
            <div id="invoice_content">
                <?php echo $receipt['html_content']; ?>

            </div>
            <div class="spacer"></div>
        </div>
    </div>
    <div class="spacer"></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#print_invoice', function(){
            $('#invoice_content').printThis();
        });
    });
    <?php if(!empty(request()->input('print_on_load'))): ?>
        $(window).on('load', function(){
            $('#invoice_content').printThis();
        });
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('lab_layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/tests_report/multi-edit.blade.php ENDPATH**/ ?>