<tr class="product_row" data-row_index="{{$loop->iteration}}">
	<td class="">
		<b>{{$sell_line->tests->name}}
		<br>
		{{$sell_line->tests->test_code}}</b>
		<input type="hidden" name="test[{{$loop->iteration}}][id]" value="{{$sell_line->test_id}}">
		<input type="hidden" name="test[{{$loop->iteration}}][name]" value="{{$sell_line->tests->name}}">
		<input type="hidden" name="test[{{$loop->iteration}}][test_code]" value="{{$sell_line->tests->test_code}}">
		<input type="hidden" name="test[{{$loop->iteration}}][sample_require]" value="{{$sell_line->tests->sample_require}}">
		<input type="hidden" name="test[{{$loop->iteration}}][carry_out]" value="{{$sell_line->tests->carry_out}}">
		<input type="hidden" name="test[{{$loop->iteration}}][test_comment]" value="{{$sell_line->tests->test_comment}}">
		<input type="hidden" name="test[{{$loop->iteration}}][final_total]" value="{{$sell_line->final_total}}">
		<input type="hidden" name="test[{{$loop->iteration}}][test_cast_amount]" value="{{$sell_line->test_cast_amount}}">
		<input type="hidden" name="test[{{$loop->iteration}}][more_amount]" value="{{$sell_line->more_amount}}">
		<input type="hidden" name="test[{{$loop->iteration}}][department_id]" value="{{$sell_line->tests->department_id}}">
	</td>
	<td class="">
		<input type="hidden" data-min="1" class="form-control pos_quantity input_number mousetrap input_quantity">
		<input type="hidden" name="products[{{$loop->iteration}}][unit_price_inc_tax]" class="form-control pos_unit_price_inc_tax input_number" value="{{@num_format($sell_line->final_total)}}">

		<span class="display_currency pos_line_total_text" data-currency_symbol="true">	{{$sell_line->final_total}}</span>
	</td>
	<td>
		<input type="hidden" class="form-control pos_line_total input_number " value="{{@num_format($sell_line->final_total)}}">
		<span class="display_currency pos_line_total_text" data-currency_symbol="true">{{$sell_line->final_total}}</span>
	</td>
	<td class="text-center">
		<i class="fa fa-times text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>
	</td>
</tr>