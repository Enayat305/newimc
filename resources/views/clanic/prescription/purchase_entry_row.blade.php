@foreach( $variations as $variation)
    <tr>
        
        <td>
            {{ $product->name }} ({{$variation->sub_sku}})
            @if( $product->type == 'variable' )
                <br/>
                (<b>{{ $variation->product_variation->name }}</b> : {{ $variation->name }})
            @endif
        </td>
       
            {!! Form::hidden('medicine[' . $row_count . '][product_id]', $product->id ); !!}
            {!! Form::hidden('medicine[' . $row_count . '][product_name]',$product->name .'('.$product->sku.')'  , ['class' => 'hidden_variation_id']); !!}

            
            {!! Form::hidden('medicine22[' . $row_count . '][quantity]', number_format(1), ['class' => 'form-control input-sm purchase_quantity input_number mousetrap', 'required',  'data-msg-abs_digit' => __('lang_v1.decimal_value_not_allowed')]); !!}
        
   
         
        <td>
            {!! Form::text('medicine[' . $row_count . '][frequency]', null, ['class' => 'form-control' , 'placeholder' => __('1 + 0 + 1')]); !!}

        </td>  
        <td>
            {!! Form::text('medicine[' . $row_count . '][day]', null, ['class' => 'form-control' , 'placeholder' => __(' 7 Days')]); !!}

        </td>  
        <td>
            {!! Form::text('medicine[' . $row_count . '][instruction]', null, ['class' => 'form-control' , 'placeholder' => __(' After Food')]); !!}

        </td>   
     
       
       
    
        
       
        <?php $row_count++ ;?>

        <td><i class="fa fa-times remove_purchase_entry_row text-danger" title="Remove" style="cursor:pointer;"></i></td>
    </tr>
@endforeach

<input type="hidden" id="row_count" value="{{ $row_count }}">