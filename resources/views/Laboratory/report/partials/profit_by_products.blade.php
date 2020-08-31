<div class="table-responsive">
    <table class="table table-bordered table-striped" id="profit_by_products_table">
        <thead>
            <tr>
                <th>@lang('sale.product')</th>
                <th>@lang('Quantity')</th>
                <th>@lang('lang_v1.gross_profit')</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td colspan="2"><strong>@lang('sale.total'):</strong></td>
                {{-- <td><span class="display_currency footer_qty" data-currency_symbol ="true"></span></td> --}}
                <td><span class="display_currency footer_total" data-currency_symbol ="true"></span></td>
            </tr>
        </tfoot>
    </table>
</div>