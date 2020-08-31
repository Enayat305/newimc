@extends('lab_layouts.app')
@section('title', __( 'report.profit_loss' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'report.profit_loss' )
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="print_section"><h2>{{session()->get('business.name')}} - @lang( 'report.profit_loss' )</h2></div>
    
    <div class="row no-print">
        <div class="col-md-3 col-md-offset-7 col-xs-6">
            <div class="input-group">
                <span class="input-group-addon bg-light-blue"><i class="fa fa-map-marker"></i></span>
               
                {!! Form::select('location_id', $business_locations, 2, ['class' => 'form-control select2' ,'id'=>'profit_loss_location_filter', 'placeholder' => __('messages.please_select'), 'required']); !!}

            </div>
        </div>
        <div class="col-md-2 col-xs-6">
            <div class="form-group pull-right">
                <div class="input-group">
                  <button type="button" class="btn btn-primary" id="profit_loss_date_filter">
                    <span>
                      <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="pl_data_div">
        </div>
    </div>
    

    <div class="row no-print">
        <div class="col-sm-12">
            <button type="button" class="btn btn-primary pull-right" 
            aria-label="Print" onclick="window.print();"
            ><i class="fa fa-print"></i> @lang( 'messages.print' )</button>
        </div>
    </div>
    <br>
    <div class="row no-print">
        <div class="col-xs-12">
            <div class="form-group pull-right">
                <div class="input-group">
                  <button type="button" class="btn btn-primary" id="profit_tabs_filter">
                    <span>
                      <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#profit_by_products" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> @lang('lang_v1.profit_by_products')</a>
                    </li>

                  

                    <li>
                        <a href="#profit_by_brands" data-toggle="tab" aria-expanded="true"><i class="fa fa-diamond" aria-hidden="true"></i> @lang('lang_v1.profit_by_brands')</a>
                    </li>

                    <li>
                        <a href="#profit_by_locations" data-toggle="tab" aria-expanded="true"><i class="fa fa-map-marker" aria-hidden="true"></i> @lang('lang_v1.profit_by_locations')</a>
                    </li>

                    <li>
                        <a href="#profit_by_invoice" data-toggle="tab" aria-expanded="true"><i class="fa fa-file-alt" aria-hidden="true"></i> @lang('lang_v1.profit_by_invoice')</a>
                    </li>

                    <li>
                        <a href="#profit_by_date" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar" aria-hidden="true"></i> @lang('lang_v1.profit_by_date')</a>
                    </li>
                    <li>
                        <a href="#profit_by_customer" data-toggle="tab" aria-expanded="true"><i class="fa fa-user" aria-hidden="true"></i> @lang('lang_v1.profit_by_customer')</a>
                    </li>
                    <li>
                        <a href="#profit_by_day" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar" aria-hidden="true"></i> @lang('lang_v1.profit_by_day')</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="profit_by_products"> 
                        @include('Laboratory/report.partials.profit_by_products')
                    </div>

                    <div class="tab-pane" id="profit_by_categories">
                        @include('Laboratory/report.partials.profit_by_categories')
                    </div>

                    <div class="tab-pane" id="profit_by_brands">
                        @include('Laboratory/report.partials.profit_by_brands')
                    </div>

                    <div class="tab-pane" id="profit_by_locations">
                        @include('Laboratory/report.partials.profit_by_locations')
                    </div>

                    <div class="tab-pane" id="profit_by_invoice">
                        @include('Laboratory/report.partials.profit_by_invoice')
                    </div>

                    <div class="tab-pane" id="profit_by_date">
                        @include('Laboratory/report.partials.profit_by_date')
                    </div>

                    <div class="tab-pane" id="profit_by_customer">
                        @include('Laboratory/report.partials.profit_by_customer')
                    </div>

                    <div class="tab-pane" id="profit_by_day">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
	

</section>
<!-- /.content -->
@stop
@section('javascript')
<script src="{{ asset('js/labreport.js?v=' . $asset_v) }}"></script>

<script type="text/javascript">
    $(document).ready( function() {
        $('#profit_tabs_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#profit_tabs_filter span').html(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            $('.nav-tabs li.active').find('a[data-toggle="tab"]').trigger('shown.bs.tab');
        });
        $('#profit_tabs_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#profit_tabs_filter').html(
                '<i class="fa fa-calendar"></i> ' + LANG.filter_by_date
            );
            $('.nav-tabs li.active').find('a[data-toggle="tab"]').trigger('shown.bs.tab');
        });

        profit_by_products_table = $('#profit_by_products_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "/lab/reports/get-profit/product",
                    "data": function ( d ) {
                        d.start_date = $('#profit_tabs_filter')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        d.end_date = $('#profit_tabs_filter')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                },
                columns: [
                    { data: 'test_name', name: 'P.name'  },
                    { data: 'total_quantity', "searchable": false},
                    { data: 'gross_profit', "searchable": false},
                ],
                fnDrawCallback: function(oSettings) {
                    var total_profit = sum_table_col($('#profit_by_products_table'), 'gross-profit');
                    // var total_qty = sum_table_col($('#profit_by_products_table'), 'total_quantity');
                    
                    $('#profit_by_products_table .footer_total').text(total_profit);
                    // $('#profit_by_products_table .footer_qty').text(total_qty);
                    __currency_convert_recursively($('#profit_by_products_table'));
                },
            });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr('href');
        if (target == '#profit_by_brands') {
                if(typeof profit_by_brands_datatable == 'undefined') {
                    profit_by_brands_datatable = $('#profit_by_brands_table').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": {
                            "url": "/lab/reports/get-profit/brand",
                            "data": function ( d ) {
                                d.start_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.end_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .endDate.format('YYYY-MM-DD');
                            }
                        },
                        columns: [
                            { data: 'brand', name: 'B.name'  },
                            { data: 'gross_profit', "searchable": false},
                        ],
                        fnDrawCallback: function(oSettings) {
                            var total_profit = sum_table_col($('#profit_by_brands_table'), 'gross-profit');
                            $('#profit_by_brands_table .footer_total').text(total_profit);

                            __currency_convert_recursively($('#profit_by_brands_table'));
                        },
                    });
                } else {
                    profit_by_brands_datatable.ajax.reload();
                }
            } else if (target == '#profit_by_locations') {
                if(typeof profit_by_locations_datatable == 'undefined') {
                    profit_by_locations_datatable = $('#profit_by_locations_table').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": {
                            "url": "/lab/reports/get-profit/location",
                            "data": function ( d ) {
                                d.start_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.end_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .endDate.format('YYYY-MM-DD');
                            }
                        },
                        columns: [
                            { data: 'location', name: 'L.name'  },
                            { data: 'gross_profit', "searchable": false},
                        ],
                        fnDrawCallback: function(oSettings) {
                            var total_profit = sum_table_col($('#profit_by_locations_table'), 'gross-profit');
                            $('#profit_by_locations_table .footer_total').text(total_profit);

                            __currency_convert_recursively($('#profit_by_locations_table'));
                        },
                    });
                } else {
                    profit_by_locations_datatable.ajax.reload();
                }
            } else if (target == '#profit_by_invoice') {
                if(typeof profit_by_invoice_datatable == 'undefined') {
                    profit_by_invoice_datatable = $('#profit_by_invoice_table').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": {
                            "url": "/lab/reports/get-profit/invoice",
                            "data": function ( d ) {
                                d.start_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.end_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .endDate.format('YYYY-MM-DD');
                            }
                        },
                        columns: [
                            { data: 'invoice_no', name: 'transactions.invoice_no'  },
                            { data: 'gross_profit', "searchable": false},
                        ],
                        fnDrawCallback: function(oSettings) {
                            var total_profit = sum_table_col($('#profit_by_invoice_table'), 'gross-profit');
                            $('#profit_by_invoice_table .footer_total').text(total_profit);

                            __currency_convert_recursively($('#profit_by_invoice_table'));
                        },
                    });
                } else {
                    profit_by_invoice_datatable.ajax.reload();
                }
            } else if (target == '#profit_by_date') {
                if(typeof profit_by_date_datatable == 'undefined') {
                    profit_by_date_datatable = $('#profit_by_date_table').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": {
                            "url": "/lab/reports/get-profit/date",
                            "data": function ( d ) {
                                d.start_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.end_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .endDate.format('YYYY-MM-DD');
                            }
                        },
                        columns: [
                            { data: 'transaction_date', name: 'transactions.transaction_date'  },
                            { data: 'gross_profit', "searchable": false},
                        ],
                        fnDrawCallback: function(oSettings) {
                            var total_profit = sum_table_col($('#profit_by_date_table'), 'gross-profit');
                            $('#profit_by_date_table .footer_total').text(total_profit);
                            __currency_convert_recursively($('#profit_by_date_table'));
                        },
                    });
                } else {
                    profit_by_date_datatable.ajax.reload();
                }
            } else if (target == '#profit_by_customer') {
                if(typeof profit_by_customers_table == 'undefined') {
                    profit_by_customers_table = $('#profit_by_customer_table').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": {
                            "url": "/lab/reports/get-profit/customer",
                            "data": function ( d ) {
                                d.start_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.end_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .endDate.format('YYYY-MM-DD');
                            }
                        },
                        columns: [
                            { data: 'customer', name: 'CU.name'  },
                            { data: 'gross_profit', "searchable": false},
                        ],
                        fnDrawCallback: function(oSettings) {
                            var total_profit = sum_table_col($('#profit_by_customer_table'), 'gross-profit');
                            $('#profit_by_customer_table .footer_total').text(total_profit);
                            __currency_convert_recursively($('#profit_by_customer_table'));
                        },
                    });
                } else {
                    profit_by_customers_table.ajax.reload();
                }
            } else if (target == '#profit_by_day') {
                var start_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');

                var end_date = $('#profit_tabs_filter')
                                    .data('daterangepicker')
                                    .endDate.format('YYYY-MM-DD');
                var url = '/lab/reports/get-profit/day?start_date=' + start_date + '&end_date=' + end_date;
                $.ajax({
                        url: url,
                        dataType: 'html',
                        success: function(result) {
                           $('#profit_by_day').html(result); 
                            profit_by_days_table = $('#profit_by_day_table').DataTable({
                                    "searching": false,
                                    'paging': false,
                                    'ordering': false,
                            });
                            var total_profit = sum_table_col($('#profit_by_day_table'), 'gross-profit');
                           $('#profit_by_day_table .footer_total').text(total_profit);
                            __currency_convert_recursively($('#profit_by_day_table'));
                        },
                    });
            } else if (target == '#profit_by_products') {
                profit_by_products_table.ajax.reload();
            }
        });
    });
</script>

@endsection