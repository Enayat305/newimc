@foreach ($sell_details as $item)
	

<tr class="product_row">
	<td>
		<input type="checkbox" class="row-select" value="{{$item->id}}">
	</td>
	<td>
		{{ $item->tests->name }}
	</td>
	<td>
		{{ $item->report_code }}
	</td>
	<td class="text-center">
		<button data-href="{{ action('Lab\Multi_ReportController@edit', [$item->id]) }}" class="btn btn-xs btn-primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
	</td>
</tr>

@endforeach