<tr class="product_row" data-row_index="{{$row_count}}">
	<td class="">
		<b>{{$query->name}}
		<br>
		{{$query->test_code}}</b>
		<input type="hidden" name="test[{{$row_count}}][id]" value="{{$query->id}}">
		<input type="hidden" name="test[{{$row_count}}][name]" value="{{$query->name}}">
		<input type="hidden" name="test[{{$row_count}}][test_code]" value="{{$query->test_code}}">
		<input type="hidden" name="test[{{$row_count}}][sample_require]" value="{{$query->sample_require}}">
		<input type="hidden" name="test[{{$row_count}}][carry_out]" value="{{$query->carry_out}}">
		<input type="hidden" name="test[{{$row_count}}][test_comment]" value="{{$query->test_comment}}">
		<input type="hidden" name="test[{{$row_count}}][final_total]" value="{{$query->final_total}}">

		<input type="hidden" name="test[{{$row_count}}][test_cast_amount]" value="{{$query->test_cast_amount}}">
		<input type="hidden" name="test[{{$row_count}}][more_amount]" value="{{$query->more_amount}}">
		<input type="hidden" name="test[{{$row_count}}][department_id]" value="{{$query->department_id}}">
	</td>
	<td class="">
		<input type="hidden" data-min="1" class="form-control pos_quantity input_number mousetrap input_quantity">
		<input type="hidden" name="products[{{$row_count}}][unit_price_inc_tax]" class="form-control pos_unit_price_inc_tax input_number" value="{{@num_format($query->final_total)}}">

		<span class="display_currency pos_line_total_text" data-currency_symbol="true">{{$query->final_total}}</span>
	</td>
	<td>
		<input type="hidden" class="form-control pos_line_total input_number " value="{{@num_format($query->final_total)}}">
		<span class="display_currency pos_line_total_text" data-currency_symbol="true">{{$query->final_total}}</span>
	</td>
	<td class="text-center">
		<i class="fa fa-times text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>
	</td>
</tr>