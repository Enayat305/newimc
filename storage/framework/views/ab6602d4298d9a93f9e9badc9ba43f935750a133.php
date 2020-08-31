<?php $__env->startSection('title', __('test.test_particular')); ?>

<?php $__env->startSection('content'); ?>
<style type="text/css">



</style>
<div class="row mb-12">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box box-solid mb-12">
                    <div class="box-body pb-0">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="width: 100% !important">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                         
                                        <?php echo Form::text('contact_id', 
             null, ['class' => 'form-control mousetrap', 'id' => 'customer_id2', 'placeholder' => 'Enter invoice No', 'required', 'style' => 'width: 100%;']);; ?>

                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""  <?php if(!auth()->user()->can('customer.create')): ?> disabled <?php endif; ?>><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                         
                        </div>
            
                        <div class="row">
                            <div class="col-sm-4 pos_product_div">
                       
                                <table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all-row"></th>
                                            <th class="tex-center col-md-3">	
                                                <?php echo app('translator')->getFromJson('Test Name'); ?>
                                            </th>
                                            
                                            <th class="text-center col-md-2">
                                                Report Code
                                            </th>
                                            
                                           
                                            <th class="text-center"><i class="fas fa-times" aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('multi_report.update')): ?>
                                        &nbsp;
                                            <?php echo Form::open(['url' => action('Lab\TestReportController@bulkEdit'), 'method' => 'post', 'id' => 'bulk_edit_form' ]); ?>

                                            <?php echo Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']);; ?>

                                            <button type="submit" class="btn  btn-primary" id="edit-selected"> <i class="fa fa-print"></i><?php echo e(__('Print'), false); ?></button>
                                            <?php echo Form::close(); ?>

                                            &nbsp;
                                            
                                        <?php endif; ?> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('multi_report.update')): ?>
                                        &nbsp;
                                            <?php echo Form::open(['url' => action('Lab\TestReportController@bulkprint'), 'method' => 'post', 'id' => 'bulk_print_form' ]); ?>

                                            <?php echo Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']);; ?>

                                             <button type="button" class="btn  btn-primary" id="edit-print"> <i class="fa fa-print"></i><?php echo e(__('Continuous Print'), false); ?></button>
                                            <?php echo Form::close(); ?>

                                            &nbsp;
                                            
                                        <?php endif; ?> 
                                    </div>
                                 
                                </div>
                            </div>

                            <div class="col-sm-8 test_div">
                       
                                
                                
                            </div>
                        </div>
                  
                        </div>
                   
                    </div>
                    
                </div>
        </div>
        
        </div>
    </div>
</div>


</section>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>


<script>

$(document).ready(function() {
 //get customer
  
    //Add Product
    $('#customer_id2')
        .autocomplete({
            source: function(request, response) {
                

                $.getJSON(
                    '/lab/list/get_invoice', {
                    
                        term: request.term,
                
                    },
                    response
                );
            },
            minLength: 2,
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    
                    ui.item = ui.content[0];
                    if (ui.item.id > 0) {
                        $(this)
                            .data('ui-autocomplete')
                            ._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                    }
                } else if (ui.content.length == 0) {
                    toastr.error('Not Found');
                    $('input#customer_id2').select();
                }
            },
            focus: function(event, ui) {
                if (ui.item.id <= 0) {
                    return false;
                }
            },
            select: function(event, ui) {
                pos_product_row(ui.item.id, 1);
            },
        })
        .autocomplete('instance')._renderItem = function(ul, item) {

            
            var string = '<div>' + item.name;




            string += '<br> Invoice No: ' + item.final_total;

            string += '</div>';

            return $('<li>')
                .append(string)
                .appendTo(ul);

        };
 $(document).on('click', '#edit-print', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_products_for_edit').val(selected_rows);
                    $('form#bulk_print_form').submit();
                } else{
                    $('input#selected_products').val('');
                    swal('<?php echo app('translator')->getFromJson("lang_v1.no_row_selected"); ?>');
                }    
            });
 $(document).on('click', '#edit-selected', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_products_for_edit').val(selected_rows);
                    $('form#bulk_edit_form').submit();
                } else{
                    $('input#selected_products').val('');
                    swal('<?php echo app('translator')->getFromJson("lang_v1.no_row_selected"); ?>');
                }    
            });
            
        function getSelectedRows() {
            var selected_rows = [];
            var i = 0;
            $('.row-select:checked').each(function () {
                selected_rows[i++] = $(this).val();
            });

            return selected_rows; 
        }


    $(document).on('click', 'button.edit_brand_button', function() {
        $('div.test_div').load($(this).data('href'), function() {
           
            $('.inputs').keydown(function(e) {
        if (e.which === 13) {

            var sum_value=$('#sum-value').val();
            
            if(parseFloat(sum_value)===1){
            var a=$('.inputs').eq(13).val();
            var b= $('.inputs').eq(14).val();
            var c=$('.inputs').eq(15).val();
            var d=$('.inputs').eq(16).val();

            sum = parseFloat(a)+parseFloat(b)+parseFloat(c)+parseFloat(d);
            $('#total-value').val(sum);
            
            }
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }

        if(e.which === 18 || e.which === 13){
            $('form#add_report_form').submit();
        }
    });

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13 && e.target.tagName != 'TEXTAREA') {
            e.preventDefault();
            return false;
        }
        
        if (keyCode === 18 && e.target.tagName != 'TEXTAREA') {
            e.preventDefault();
            return false;
        }
    });
    $( ".inputs" ).last().change(function() {
        $('form#add_report_form').submit();
        
    });
    $( ".inputs" ).first().change(function() {
        $('form#add_report_form').submit();
        
    });
    $(".inputs").change(function() {

        result = $(this).val();
        results = $(this);
        var row = $('.inputs').index(this);
      
        $("#test_particular_entry_table tbody tr ").each(function(index) {
            $('form#add_report_form').submit();
            high_range = $('tr:gt(' + row + ')  td:nth-child(7)').find('input').val();
            low_range = $('tr:gt(' + row + ')  td:nth-child(8)').find('input').val();
            check_low_range = $.isNumeric(low_range);
            check_high_range = $.isNumeric(high_range);
            
            if (check_high_range === false && check_low_range === false) {
                if (result === high_range) {
                    
                    results.css("background-color", "red");
                    return false;

                }
                if (result === low_range) {


                    results.css("background-color", "yellow");
                    return false;
                    if (result != high_range || result != low_range) {


                        results.css("background-color", "white");
                        return false;

                    }
                }
            } else {

                
                if (result === high_range || result >= high_range) {
                   
                    results.css("background-color", "red");
                    return false;

                } else if (result === low_range || result <= low_range) {


                    results.css("background-color", "yellow");
                    return false;

                } else if (result != high_range || result != low_range) {


                    results.css("background-color", "white");
                    return false;

                }
            }
            return false;
        });
    });
    
            $('form#add_report_form').submit(function(e) {
                e.preventDefault();
                $(this)
                    .find('button[type="submit"]');
                    // .attr('disabled', true);
                var data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            
                            toastr.success(result.msg);
                            
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });              
            //variation_id is null when weighing_scale_barcode is used.
            function pos_product_row(variation_id = null, purchase_line_id = null, weighing_scale_barcode = null) {
                       
                
                $.ajax({
                    method: 'GET',
                    url: '/lab/multi/get_row/' + variation_id,
                    async: false,
                    data: {
                        
                        variation_id:variation_id,
                    
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success) {
                            $('table#pos_table tbody tr').remove();
                            $('table#pos_table tbody')
                                .append(result.html_content);
                        }
                    },
                });

        }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('lab_layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\newimc\resources\views/Laboratory/multi_tests_report/create.blade.php ENDPATH**/ ?>