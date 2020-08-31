<table class="table bg-gray">
        <tr class="bg-green">
        <th>#</th>
        <th>{{ __('Test Name') }}</th>
        <th>{{ __('sale.price_inc_tax') }}</th>
        <th>{{ __('sale.subtotal') }}</th>
    </tr>
    @foreach($sell->test_sell as $sell_line)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sell_line->tests->name}}</td>
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->final_total }}</span>
            </td>
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->final_total }}</span>
            </td>
        </tr>
    @endforeach
</table>