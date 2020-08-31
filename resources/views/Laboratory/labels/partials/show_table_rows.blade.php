@forelse ($products as $product)
    <tr>
        <td>
            {{$product->tests->name}}
            <br>
            {{$product->report_code}}

    
            <input type="hidden" name="products[{{$loop->index + $index}}][product_id]" value="{{$product->id}}">
            <input type="hidden" name="products[{{$loop->index + $index}}][variation_id]" value="{{$product->id}}">
        </td>
        <td>
            <input type="number" class="form-control" min=1
            name="products[{{$loop->index + $index}}][quantity]" value="1">
        </td>
    </tr>
@empty

@endforelse