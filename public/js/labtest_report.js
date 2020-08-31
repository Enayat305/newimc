$(document).ready(function() {


    sell_form = $('form#add_report_form');

    $('button#submit-sell, button#save-and-print').click(function(e) {
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


    function pos_print(receipt) {
        //If printer type then connect with websocket
        if (receipt.print_type == 'printer') {
            var content = receipt;
            content.type = 'print-receipt';

            //Check if ready or not, then print.
            if (socket != null && socket.readyState == 1) {
                socket.send(JSON.stringify(content));
            } else {
                initializeSocket();
                setTimeout(function() {
                    socket.send(JSON.stringify(content));
                }, 700);
            }

        } else if (receipt.html_content != '') {
            //If printer type browser then print content
            $('#receipt_section').html(receipt.html_content);
            __currency_convert_recursively($('#receipt_section'));
            __print_receipt('receipt_section');

        }
    }
    $('.inputs').keydown(function(e) {
        if (e.which === 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
    });

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13 && e.target.tagName != 'TEXTAREA') {
            e.preventDefault();
            return false;
        }
    });

    $(".inputs").change(function() {

        result = $(this).val();
        results = $(this);
        var row = $('.inputs').index(this);

        $("#test_particular_entry_table tbody tr ").each(function(index) {

            high_range = $('tr:gt(' + row + ')  td:nth-child(7)').find('input').val();
            low_range = $('tr:gt(' + row + ')  td:nth-child(8)').find('input').val();
            check_low_range = $.isNumeric(low_range);
            check_high_range = $.isNumeric(high_range);
            if (check_high_range === false && check_low_range === false) {
                if (result === high_range) {
                    //alert(result);
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
                    //alert(result);
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



    $(document).on('click', '.print-invoice', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json',
            success: function(result) {
                if (result.success == 1) {
                    //Check if enabled or not
                    if (result.receipt.is_enabled) {
                        pos_print(result.receipt);


                    }
                } else {
                    toastr.error(result.msg);
                }

            },
        });
    });
    //Purchase table
    purchase_table = $('#purchase_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/lab/test_reports',
            data: function(d) {
                if ($('#test_id').length) {
                    d.test_id = $('#test_id').val();
                }
                if ($('#patient_id').length) {
                    d.patient_id = $('#patient_id').val();
                }
                if ($('#purchase_list_filter_payment_status').length) {
                    d.payment_status = $('#purchase_list_filter_payment_status').val();
                }
                if ($('#status').length) {
                    d.status = $('#status').val();
                }

                var start = '';
                var end = '';
                if ($('#purchase_list_filter_date_range').val()) {
                    start = $('input#purchase_list_filter_date_range')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#purchase_list_filter_date_range')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;

                d = __datatable_ajax_callback(d);
            },
        },
        aaSorting: [
            [3, 'desc']
        ],
        columns: [
            { data: 'mass_delete', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'report_date', name: 'report_date', },
            { data: 'report_code', name: 'report_code' },
            { data: 'test_name', name: 'tv.name' },
            { data: 'patient_name', name: 'p.name' },
            { data: 'status', name: 'status' },
            { data: 'test_comment', name: 'test_comment' },
            { data: 'test_result', name: 'test_result' },
            { data: 'reported_dated', name: 'reported_dated', },
            { data: 'ref_by', name: 'pv.first_name' },
        ],


    });

    $(document).on(
        'change',
        '#test_id, \
                    #patient_id, #purchase_list_filter_payment_status,\
                     #status',
        function() {
            purchase_table.ajax.reload();
        }
    );


});