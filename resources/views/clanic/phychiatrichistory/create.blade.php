<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\PhychiatricHistoryController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_phychiatrichistory_form' : 'phychiatrichistory_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'phychiatrichistory.add_phychiatrichistory' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="form-group col-sm-12">
          {!! Form::label('actual_name', __( 'phychiatrichistory.name' ) . ':*') !!}
            {!! Form::text('actual_name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'phychiatrichistory.name' )]); !!}
        </div>

      
        @if(!$quick_add)
          <div class="form-group col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                     {!! Form::checkbox('define_base_phychiatrichistory', 1, false,[ 'class' => 'toggler', 'data-toggle_id' => 'base_phychiatrichistory_div' ]); !!} @lang( 'lang_v1.add_as_multiple_of_base_phychiatrichistory' )
                  </label> 
                </div>
            </div>
          </div>
          <div class="form-group col-sm-12 hide" id="base_phychiatrichistory_div">
            <table class="table">
              <tr>
               
                <td style="vertical-align: middle;">
                  {!! Form::select('base_phychiatrichistory_id', $phychiatrichistorys, null, ['placeholder' => __( 'lang_v1.select_base_phychiatrichistory' ), 'class' => 'form-control']); !!}
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