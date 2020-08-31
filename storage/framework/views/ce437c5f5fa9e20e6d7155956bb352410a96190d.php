<?php 
    $colspan = 15;
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-row"></th>
                <th>&nbsp;</th>
                <th><?php echo app('translator')->getFromJson('messages.action'); ?></th>
                <th><?php echo app('translator')->getFromJson('sale.product'); ?></th>
                <th><?php echo app('translator')->getFromJson('purchase.business_location'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.product_business_location_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_purchase_price')): ?>
                    <?php 
                        $colspan++;
                    ?>
                    <th><?php echo app('translator')->getFromJson('lang_v1.unit_perchase_price'); ?></th>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access_default_selling_price')): ?>
                    <?php 
                        $colspan++;
                    ?>
                    <th><?php echo app('translator')->getFromJson('lang_v1.selling_price'); ?></th>
                <?php endif; ?>
                <th><?php echo app('translator')->getFromJson('report.current_stock'); ?></th>
                <th><?php echo app('translator')->getFromJson('product.product_type'); ?></th>
                <th><?php echo app('translator')->getFromJson('product.category'); ?></th>
                <th><?php echo app('translator')->getFromJson('product.brand'); ?></th>
                <th><?php echo app('translator')->getFromJson('product.tax'); ?></th>
                <th><?php echo app('translator')->getFromJson('product.sku'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.product_custom_field1'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.product_custom_field2'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.product_custom_field3'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.product_custom_field4'); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="<?php echo e($colspan, false); ?>">
                <div style="display: flex; width: 100%;">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lab_product.delete')): ?>
                        <?php echo Form::open(['url' => action('ProductController@massDestroy'), 'method' => 'post', 'id' => 'mass_delete_form' ]); ?>

                        <?php echo Form::hidden('selected_rows', null, ['id' => 'selected_rows']);; ?>

                        <?php echo Form::submit(__('lang_v1.delete_selected'), array('class' => 'btn btn-xs btn-danger', 'id' => 'delete-selected')); ?>

                        <?php echo Form::close(); ?>

                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lab_product.update')): ?>
                    &nbsp;
                        <?php echo Form::open(['url' => action('ProductController@bulkEdit'), 'method' => 'post', 'id' => 'bulk_edit_form' ]); ?>

                        <?php echo Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']);; ?>

                        <button type="submit" class="btn btn-xs btn-primary" id="edit-selected"> <i class="fa fa-edit"></i><?php echo e(__('lang_v1.bulk_edit'), false); ?></button>
                        <?php echo Form::close(); ?>

                        &nbsp;
                        <button type="button" class="btn btn-xs btn-success update_product_location" data-type="add"><?php echo app('translator')->getFromJson('lang_v1.add_to_location'); ?></button>
                        &nbsp;
                        <button type="button" class="btn btn-xs bg-navy update_product_location" data-type="remove"><?php echo app('translator')->getFromJson('lang_v1.remove_from_location'); ?></button>
                    <?php endif; ?>
                    &nbsp;
                    <?php echo Form::open(['url' => action('ProductController@massDeactivate'), 'method' => 'post', 'id' => 'mass_deactivate_form' ]); ?>

                    <?php echo Form::hidden('selected_products', null, ['id' => 'selected_products']);; ?>

                    <?php echo Form::submit(__('lang_v1.deactivate_selected'), array('class' => 'btn btn-xs btn-warning', 'id' => 'deactivate-selected')); ?>

                    <?php echo Form::close(); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.deactive_product_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div><?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/product/partials/product_list.blade.php ENDPATH**/ ?>