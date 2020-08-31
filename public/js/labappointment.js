$(document).ready(function() {

    //Purchase table
    appointment_table = $('#appointment_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/lab/appointment',
            data: function(d) {
                if ($('#doctor_filter_id').length) {
                    d.doctor_id = $('#doctor_filter_id').val();
                }
                if ($('#patient_filter_id').length) {
                    d.patient_id = $('#patient_filter_id').val();

                }


                if ($('#purchase_list_filter_payment_status').length) {
                    d.payment_status = $('#purchase_list_filter_payment_status').val();
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
        aaSorting: [
            [1, 'desc']
        ],
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'transaction_date', name: 'transaction_date' },
            { data: 'added_by', name: 'u.first_name' },
            { data: 'name', name: 'contacts.name' },
            { data: 'ref_no', name: 'ref_no' },
            { data: 'location_name', name: 'APPO.token_no' },
            { data: 'status', name: 'status' },
            { data: 'fee_status', name: 'fee_status' },
            { data: 'payment_status', name: 'payment_status' },
            { data: 'final_total', name: 'final_total' },
            { data: 'payment_due', name: 'payment_due', orderable: false, searchable: false },

        ],
        fnDrawCallback: function(oSettings) {
            var total_purchase = sum_table_col($('#appointment_table'), 'final_total');
            $('#footer_purchase_total').text(total_purchase);

            var total_due = sum_table_col($('#appointment_table'), 'payment_due');
            $('#footer_total_due').text(total_due);

            var total_purchase_return_due = sum_table_col($('#appointment_table'), 'purchase_return');
            $('#footer_total_purchase_return_due').text(total_purchase_return_due);

            $('#footer_status_count').html(__sum_status_html($('#appointment_table'), 'status-label'));

            $('#footer_payment_status_count').html(
                __sum_status_html($('#appointment_table'), 'payment-status-label')
            );

            __currency_convert_recursively($('#appointment_table'));
        },
        createdRow: function(row, data, dataIndex) {
            $(row)
                .find('td:eq(5)')
                .attr('class', 'clickable_td');
        },
    });


    $('form#appointment_edit_form #start_time').datetimepicker({
        format: 'LT',

        ignoreReadonly: true
    });
    $(document).on(
        'change',
        '#doctor_filter_id, \
            #patient_filter_id,\
         #purchase_list_filter_payment_status',
        function() {
            appointment_table.ajax.reload();
        }
    );


    $(document).on('click', '.add_new_customer', function() {
        $('#patient_dropdown').select2('close');
        var name = $(this).data('name');
        $('.patient_modal')
            .find('input#name')
            .val(name);

        $('.patient_modal').modal('show');
    });
    $('form#quick_add_patient')
        .submit(function(e) {
            e.preventDefault();
        })
        .validate({
            rules: {
                contact_id: {
                    remote: {
                        url: '/lab/contacts/check-contact-id',
                        type: 'post',
                        data: {
                            contact_id: function() {
                                return $('#contact_id').val();
                            },
                            hidden_id: function() {
                                if ($('#hidden_id').length) {
                                    return $('#hidden_id').val();
                                } else {
                                    return '';
                                }
                            },
                        },
                    },
                },
            },
            messages: {
                contact_id: {
                    remote: LANG.contact_id_already_exists,
                },
            },
            submitHandler: function(form) {
                $(form)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                var data = $(form).serialize();
                $.ajax({
                    method: 'POST',
                    url: $(form).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('select#patient_dropdown').append(
                                $('<option>', { value: result.data.id, text: result.data.name })
                            );
                            $('select#patient_dropdown')
                                .val(result.data.id)
                                .trigger('change');
                            $('div.patient_modal').modal('hide');
                            toastr.success(result.msg);
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            },
        });
    $('.patient_modal').on('hidden.bs.modal', function() {
        $('form#quick_add_patient')
            .find('button[type="submit"]')
            .removeAttr('disabled');
        $('form#quick_add_patient')[0].reset();
    });
    $('button#add_new_appointment_btn').click(function() {
        $('div#add_appointment_modal').modal('show');
    });


    //If location is set then show tables.




    $('#appointment_list_filter_date_range').daterangepicker(
        dateRangeSettings,

        function(start, end) {
            $('#appointment_list_filter_date_range')
                .val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));

            appointment_table.ajax.reload();
        }
    );
    $('#appointment_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#appointment_list_filter_date_range').val('');
        appointment_table.ajax.reload();
    });

    $('form#appointment_add_form #date').datetimepicker({
        format: moment_date_format,

        ignoreReadonly: true
    });
    doctor_dropdown = $(document).on('change', '#doctor_dropdown', function() {
        $.ajax({
            url: '/lab/get_schedule',
            type: 'GET',
            data: { date: $('#date').val(), doctor: $('#doctor_dropdown').val() },
            success: function(response) {
                var container = $(".schedul");
                container.html(response);
            }
        });
    });
    $(document).on('click', '#date', function() {
        $.ajax({
            url: '/lab/get_schedule',
            type: 'GET',
            data: { date: $('#date').val(), doctor: $('#doctor_dropdown').val() },
            success: function(response) {
                var container = $(".schedul");
                container.html(response);
            }
        });
    });
    $(document).on('click', 'a.appointment_edit_button', function() {
        $('button#add_new_appointment_btn').click(function() {
            $('div#add_appointment_modal').modal('show');

        });
        $('div.appointment_edit_modal').load($(this).data('href'), function() {
            $(this).modal('show');

            $('form#appointment_edit_form #date').datetimepicker({
                format: moment_date_format,

                ignoreReadonly: true
            });
            $('form#appointment_edit_form').submit(function(e) {
                e.preventDefault();
                $(this)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                var data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('div.appointment_edit_modal').modal('hide');
                            toastr.success(result.msg);
                            appointment_table.ajax.reload();

                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });

    $('#add_appointment_modal').on('shown.bs.modal', function(e) {

        $(this).find('select').each(function() {
            if (!($(this).hasClass('select2'))) {
                $(this).select2({
                    dropdownParent: $('#add_appointment_modal'),

                });
            }
        });
        booking_form_validator = $('form#appointment_add_form').validate({
            submitHandler: function(form) {
                $(form).find('button[type="submit"]').attr('disabled', true);

                var data = $(form).serialize();

                $.ajax({
                    method: "POST",
                    url: $(form).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('select#patient_dropdown')
                                .val('')
                                .trigger('change');
                            $('div#add_appointment_modal').modal('hide');
                            $(form)[0].reset();
                            toastr.success(result.msg);
                            appointment_table.ajax.reload();
                            $(form)[0].reset();
                            $('select#doctor_dropdown')
                                .val('')
                                .trigger('change');
                            doctor_dropdown.ajax.reload();
                        } else {
                            toastr.error(result.msg);

                        }
                        $(form).find('button[type="submit"]').attr('disabled', false);
                    }
                });
            }
        });

    });
    $('table#appointment_table tbody').on('click', 'a.appointment_delete_button', function(e) {
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
                            appointment_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });


});