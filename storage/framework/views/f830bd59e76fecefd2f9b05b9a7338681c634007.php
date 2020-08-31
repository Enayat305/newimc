<div class="table-responsive">
    <table class="table table-bordered table-striped ajax_view" id="purchase_table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-row"></th>
                <th><?php echo app('translator')->getFromJson('messages.action'); ?></th>
                <th><?php echo app('translator')->getFromJson('Report Date'); ?></th>
                <th><?php echo app('translator')->getFromJson('Report Code'); ?></th>
                <th><?php echo app('translator')->getFromJson('test.name'); ?></th>
                <th><?php echo app('translator')->getFromJson('Patient Name '); ?></th>
                <th><?php echo app('translator')->getFromJson('Status'); ?></th>
                <th><?php echo app('translator')->getFromJson('Test Comment'); ?></th>
                <th><?php echo app('translator')->getFromJson('Test Result'); ?></th>
                <th><?php echo app('translator')->getFromJson('Reported Dated'); ?></th>
                <th><?php echo app('translator')->getFromJson('Ref By'); ?></th>
            </tr>
        </thead>
        <tfoot>
        <tr>
            <td>
            <div style="display: flex; width: 100%;">
             
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.update')): ?>
                &nbsp;
                    <?php echo Form::open(['url' => action('Lab\TestReportController@bulkEdit'), 'method' => 'post', 'id' => 'bulk_edit_form' ]); ?>

                    <?php echo Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']);; ?>

                    <button type="submit" class="btn btn-xs btn-primary" id="edit-selected"> <i class="fa fa-print"></i><?php echo e(__('Bulk Print'), false); ?></button>
                    <?php echo Form::close(); ?>

                    &nbsp;
                    
                <?php endif; ?>
            </div>
            </td>
        </tr>
    </tfoot>
    </table>
</div><?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/tests_report/partials/purchase_table.blade.php ENDPATH**/ ?>