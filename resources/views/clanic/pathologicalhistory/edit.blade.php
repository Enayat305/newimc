<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Lab\PathologicalHistoryController@update', [$pathologicalhistory->id]), 'method' => 'PUT', 'id' => 'pathologicalhistory_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'pathologicalhistory.edit_pathologicalhistory' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="form-group col-sm-12">
          {!! Form::label('actual_name', __( 'pathologicalhistory.name' ) . ':*') !!}
            {!! Form::text('actual_name', $pathologicalhistory->actual_name, ['class' => 'form-control', 'required', 'placeholder' => __( 'pathologicalhistory.name' )]); !!}
        </div>

        <div class="form-group col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                     {!! Form::checkbox('define_base_pathologicalhistory', 1, !empty($pathologicalhistory->base_id),[ 'class' => 'toggler', 'data-toggle_id' => 'base_pathologicalhistory_div' ]); !!} @lang( 'lang_v1.add_as_multiple_of_base_pathologicalhistory' )
                  </label> 
                </div>
            </div>
          </div>
        <div class="form-group col-sm-12 @if(empty($pathologicalhistory->base_id)) hide @endif" id="base_pathologicalhistory_div">
          <table class="table">
            <tr>
              
              <td style="vertical-align: middle;">
                {!! Form::select('base_pathologicalhistory_id', $pathologicalhistorys, $pathologicalhistory->base_id, ['placeholder' => __( 'lang_v1.select_base_pathologicalhistory' ), 'class' => 'form-control']); !!}
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