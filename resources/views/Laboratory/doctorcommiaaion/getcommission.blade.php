
	<div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('transaction_date', __('messages.date') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                {!! Form::text('transaction_date', @format_datetime('now'), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']); !!}
            </div>
        </div>
    </div>
    
<div class="col-sm-4">
    <div class="form-group">
    {!! Form::label('status', __('Total Commission Amount') . ':*') !!}
            <div class='input-group date' >
           
      {!! Form::text('final_total', $commission, ['class' => 'form-control input_number','placeholder' => __( 'comm %' ), 'required', 'id' => 'final_total',]); !!}
      </div>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        {!! Form::label('ref_no', __('purchase.ref_no').':') !!}
        {!! Form::text('ref_no', null, ['class' => 'form-control']); !!}
    </div>
</div>

