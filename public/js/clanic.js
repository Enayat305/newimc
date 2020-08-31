$(document).ready(function() {

    sell_form = $('form#add_press_form');


    $('button#submit_pres').click(function(e) {
        //Check if product is present or not.


        if ($(this).attr('id') == 'save-and-print') {
            $('#is_save_and_print').val(1);
        } else {
            $('#is_save_and_print').val(0);
        }



        if (sell_form.valid()) {
            window.onbeforeunload = null;
            sell_form.submit();
        }
    });




    //Add products
    if ($('#search_medicine').length > 0) {
        $('#search_medicine')
            .autocomplete({
                source: function(request, response) {
                    $.getJSON(
                        '/lab/prescr/get_products', { location_id: $('#location_id').val(), term: request.term },
                        response
                    );
                },
                minLength: 2,
                response: function(event, ui) {
                    if (ui.content.length == 1) {
                        ui.item = ui.content[0];
                        $(this)
                            .data('ui-autocomplete')
                            ._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                    } else if (ui.content.length == 0) {
                        var term = $(this).data('ui-autocomplete').term;
                        swal({
                            title: LANG.no_products_found,
                            text: __translate('add_name_as_new_product', { term: term }),
                            buttons: [LANG.cancel, LANG.ok],
                        }).then(value => {
                            if (value) {
                                var container = $('.quick_add_product_modal');
                                $.ajax({
                                    url: '/lab/products/quick_add?product_name=' + term,
                                    dataType: 'html',
                                    success: function(result) {
                                        $(container)
                                            .html(result)
                                            .modal('show');
                                    },
                                });
                            }
                        });
                    }
                },
                select: function(event, ui) {
                    $(this).val(null);
                    get_purchase_entry_row(ui.item.product_id, ui.item.variation_id);
                },
            })
            .autocomplete('instance')._renderItem = function(ul, item) {
                return $('<li>')
                    .append('<div>' + item.text + '</div>')
                    .appendTo(ul);
            };
    }

    $(document).on('click', '.remove_purchase_entry_row', function() {
        swal({
            title: LANG.sure,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(value => {
            if (value) {
                $(this)
                    .closest('tr')
                    .remove();

            }
        });
    });

    $(document).ready(function() {
        $('button#add_new_appointment_btn').click(function() {
            $('div#add_appointment_modal').modal('show');
        });

        var pres_table = $('#pres_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/lab/prescription',
                data: function(d) {
                    if ($('#doctor_filter_id').length) {
                        d.doctor_id = $('#doctor_filter_id').val();
                    }
                    if ($('#patient_filter_id').length) {

                        d.patient_id = $('#patient_filter_id').val();


                    }


                    var start = '';
                    var end = '';
                    if ($('#appointment_list_filter_date_range').val()) {
                        start = $('input#appointment_list_filter_date_range')
                            .data('daterangepicker')

                        .startDate.format('YYYY-MM-DD');

                        end = $('input#appointment_list_filter_date_range')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                    d.start_date = start;
                    d.end_date = end;

                    d = __datatable_ajax_callback(d);
                },
            },

            columns: [
                { data: 'action', name: 'action', searchable: false, orderable: false },
                { data: 'added_by', name: 'u.first_name' },
                { data: 'name', name: 'contacts.name' },
                { data: 'appointments_id', name: 'appointments_id' },
                { data: 'token_no', name: 'token_no', searchable: false, orderable: false },
                { data: 'date', name: 'date' },
                { data: 'advice', name: 'advice' },
                { data: 'note', name: 'note' },
                { data: 'weight', name: 'weight', searchable: false, orderable: false },
                { data: 'temperature', name: 'temperature', searchable: false, orderable: false }





            ],
            aaSorting: [
                [1, 'desc']
            ],

        });

        $(document).on('click', 'a.delete-purchase', function(e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(willDelete => {
                if (willDelete) {
                    var href = $(this).attr('href');
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                pres_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
        $(document).on(
            'change',
            '#doctor_filter_id, \
                #patient_filter_id,\
                 #appointment_list_filter_status',
            function() {
                pres_table.ajax.reload();
            }
        );
        $('form#appointment_edit_form #start_time').datetimepicker({
            format: 'LT',

            ignoreReadonly: true
        });
        $('#appointment_list_filter_date_range').daterangepicker(
            dateRangeSettings,

            function(start, end) {
                $('#appointment_list_filter_date_range')
                    .val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));

                pres_table.ajax.reload();
            }
        );
        $('#appointment_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#appointment_list_filter_date_range').val('');
            pres_table.ajax.reload();
        });

    });




});

function get_purchase_entry_row(product_id, variation_id) {
    if (product_id) {
        var row_count = $('#row_count').val();
        $.ajax({
            method: 'POST',
            url: '/lab/prescr/get_purchase_entry_row',
            dataType: 'html',
            data: { product_id: product_id, row_count: row_count, variation_id: variation_id },
            success: function(result) {
                $(result)
                    .find('.purchase_quantity')
                    .each(function() {
                        row = $(this).closest('tr');

                        $('#purchase_entry_table tbody').append(
                            update_purchase_entry_row_values(row)
                        );



                    });

                $('#row_count').val(
                    $(result).find('.purchase_quantity').length + parseInt(row_count)
                );

            },
        });
    }
}



function update_purchase_entry_row_values(row) {



    return row;

}