<div class="modal-dialog" role="document">
  <div class="modal-content">
    
    {!! Form::open(['url' => action('Lab\VaccineController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_vaccine_form' : 'vaccine_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'vaccine.add_vaccine' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="form-group col-sm-12">
          {!! Form::label('actual_name', __( 'vaccine.name' ) . ':*') !!}
            {!! Form::text('actual_name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'vaccine.name' )]); !!}
        </div>

      
        @if(!$quick_add)
          <div class="form-group col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                     {!! Form::checkbox('define_base_vaccine', 1, false,[ 'class' => 'toggler', 'data-toggle_id' => 'base_vaccine_div' ]); !!} @lang( 'lang_v1.add_as_multiple_of_base_vaccine' )
                  </label> 
                </div>
            </div>
          </div>
          <div class="form-group col-sm-12 hide" id="base_vaccine_div">
            <table class="table">
              <tr>
               
                <td style="vertical-align: middle;">
                  {!! Form::select('base_vaccine_id', $vaccines, null, ['placeholder' => __( 'lang_v1.select_base_vaccine' ), 'class' => 'form-control']); !!}
                </td>
              </tr>
            </table>
          </div>
        @endif
      </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->