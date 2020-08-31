<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\AllergieController@update', [$allergie->id]), 'method' => 'PUT', 'id' => 'allergie_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'allergie.edit_allergie' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="form-group col-sm-12">
          {!! Form::label('actual_name', __( 'allergie.name' ) . ':*') !!}
            {!! Form::text('actual_name', $allergie->actual_name, ['class' => 'form-control', 'required', 'placeholder' => __( 'allergie.name' )]); !!}
        </div>

        <div class="form-group col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                     {!! Form::checkbox('define_base_allergie', 1, !empty($allergie->base_id),[ 'class' => 'toggler', 'data-toggle_id' => 'base_allergie_div' ]); !!} @lang( 'lang_v1.add_as_multiple_of_base_allergie' )
                  </label> 
                </div>
            </div>
          </div>
        <div class="form-group col-sm-12 @if(empty($allergie->base_id)) hide @endif" id="base_allergie_div">
          <table class="table">
            <tr>
              
              <td style="vertical-align: middle;">
                {!! Form::select('base_allergie_id', $allergies, $allergie->base_id, ['placeholder' => __( 'lang_v1.select_base_allergie' ), 'class' => 'form-control']); !!}
              </td>
            </tr>
      
          </table>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->