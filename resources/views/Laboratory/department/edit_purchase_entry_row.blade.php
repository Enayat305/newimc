@php
    $hide_tax = '';
    if( session()->get('business.enable_inline_tax') == 0){
        $hide_tax = 'hide';
    }
    $currency_precision = config('constants.currency_precision', 2);
    $quantity_precision = config('constants.quantity_precision', 2);
@endphp
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-th-green text-center table-striped" 
    id="purchase_entry_table">
        <thead>
              
              <tr>
				  <th>#</th>
				  <th>@lang( 'product.product_name' )</th>
				  <th>@lang( 'purchase.purchase_quantity' )</th>
				  <th>@lang( 'Unit Cost' )</th>
				  
			  
				
				  <th>@lang( 'purchase.line_total' )</th>
				  
				
				  <th><i class="fa fa-trash" aria-hidden="true"></i></th>
				</tr>
        </thead>
        <tbody>
    <?php $row_count = 0; ?>
    @foreach($test->use_product_tests as $use_product_tests)
        <tr>
            <td><span class="sr_number"></span></td>
            <td>
                {{ $use_product_tests->product->name }} ({{$use_product_tests->variations->sub_sku}})
                @if( $use_product_tests->product->type == 'variable') 
                    <br/>(<b>{{ $use_product_tests->variations->product_variation->name}}</b> : {{ $use_product_tests->variations->name}})
                @endif
            </td>

            <td>
                {!! Form::hidden('purchases[' . $loop->index . '][product_id]', $use_product_tests->product_id ); !!}
                {!! Form::hidden('purchases[' . $loop->index . '][variation_id]', $use_product_tests->variation_id ); !!}
                {!! Form::hidden('purchases[' . $loop->index . '][use_product_tests_id]',
                $use_product_tests->id); !!}

                @php
                    $check_decimal = 'false';
                    if($use_product_tests->product->unit->allow_decimal == 0){
                        $check_decimal = 'true';
                    }
                @endphp
            
                {!! Form::text('purchases[' . $loop->index . '][quantity]', 
                number_format($use_product_tests->quantity, $quantity_precision, $currency_details->decimal_separator, $currency_details->thousand_separator),
                ['class' => 'form-control input-sm purchase_quantity input_number mousetrap', 'required', 'data-rule-abs_digit' => $check_decimal, 'data-msg-abs_digit' => __('lang_v1.decimal_value_not_allowed')]); !!} 

                <input type="hidden" class="base_unit_cost" value="{{$use_product_tests->purchase_price}}">
                @if(!empty($use_product_tests->sub_units_options))
                    <br>
                    <select name="purchases[{{$loop->index}}][sub_unit_id]" class="form-control input-sm sub_unit">
                        @foreach($use_product_tests->sub_units_options as $sub_units_key => $sub_units_value)
                            <option value="{{$sub_units_key}}" 
                                data-multiplier="{{$sub_units_value['multiplier']}}"
                                @if($sub_units_key == $use_product_tests->sub_unit_id) selected @endif>
                                {{$sub_units_value['name']}}
                            </option>
                        @endforeach
                    </select>
                @else
                    {{ $use_product_tests->product->unit->short_name }}
                @endif

                <input type="hidden" name="purchases[{{$loop->index}}][product_unit_id]" value="{{$use_product_tests->product->unit->id}}">

                <input type="hidden" class="base_unit_selling_price" value="{{$use_product_tests->variations->sell_price_inc_tax}}">
            </td>
            <td class="hidden">
                {!! Form::text('purchases[' . $loop->index . '][pp_without_discount]', number_format($use_product_tests->purchase_price, $currency_precision, $currency_details->decimal_separator, $currency_details->thousand_separator), ['class' => 'form-control input-sm purchase_unit_cost_without_discount input_number', 'required']); !!}
            </td>
           
            <td>
                {!! Form::text('purchases[' . $loop->index . '][purchase_price]', 
                number_format($use_product_tests->purchase_price, $currency_precision, $currency_details->decimal_separator, $currency_details->thousand_separator), ['class' => 'form-control input-sm purchase_unit_cost input_number', 'required']); !!}
            </td>
            <td class="{{$hide_tax}}">
                <span class="row_subtotal_before_tax">
                    {{number_format($use_product_tests->quantity * $use_product_tests->purchase_price, $currency_precision, $currency_details->decimal_separator, $currency_details->thousand_separator)}}
                </span>
                <input type="hidden" class="row_subtotal_before_tax_hidden" value="{{number_format($use_product_tests->quantity * $use_product_tests->purchase_price, $currency_precision, $currency_details->decimal_separator, $currency_details->thousand_separator)}}">
            </td>

           
                
            </td>

           

            <td><i class="fa fa-times remove_purchase_entry_row text-danger" title="Remove" style="cursor:pointer;"></i></td>
        </tr>
        <?php $row_count = $loop->index + 1 ; ?>
    @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" id="row_count" value="{{ $row_count }}">