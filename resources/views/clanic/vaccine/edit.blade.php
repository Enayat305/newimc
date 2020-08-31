<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\VaccineController@update', [$vaccine->id]), 'method' => 'PUT', 'id' => 'vaccine_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'vaccine.edit_vaccine' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="form-group col-sm-12">
          {!! Form::label('actual_name', __( 'vaccine.name' ) . ':*') !!}
            {!! Form::text('actual_name', $vaccine->actual_name, ['class' => 'form-control', 'required', 'placeholder' => __( 'vaccine.name' )]); !!}
        </div>

        <div class="form-group col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                     {!! Form::checkbox('define_base_vaccine', 1, !empty($vaccine->base_id),[ 'class' => 'toggler', 'data-toggle_id' => 'base_vaccine_div' ]); !!} @lang( 'lang_v1.add_as_multiple_of_base_vaccine' )
                  </label> 
                </div>
            </div>
          </div>
        <div class="form-group col-sm-12 @if(empty($vaccine->base_id)) hide @endif" id="base_vaccine_div">
          <table class="table">
            <tr>
              
              <td style="vertical-align: middle;">
                {!! Form::select('base_vaccine_id', $vaccines, $vaccine->base_id, ['placeholder' => __( 'lang_v1.select_base_vaccine' ), 'class' => 'form-control']); !!}
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