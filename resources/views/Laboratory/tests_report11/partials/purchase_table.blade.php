<div class="table-responsive">
    <table class="table table-bordered table-striped ajax_view" id="purchase_table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-row"></th>
                <th>@lang('messages.action')</th>
                <th>@lang('Report Date')</th>
                <th>@lang('Report Code')</th>
                <th>@lang('test.name')</th>
                <th>@lang('Patient Name ')</th>
                <th>@lang('Status')</th>
                <th>@lang('Test Comment')</th>
                <th>@lang('Test Result')</th>
                <th>@lang('Reported Dated')</th>
                <th>@lang('Ref By')</th>
            </tr>
        </thead>
        <tfoot>
        <tr>
            <td>
            <div style="display: flex; width: 100%;">
             
                @can('multi_report.update')
                &nbsp;
                    {!! Form::open(['url' => action('Lab\TestReportController@bulkEdit'), 'method' => 'post', 'id' => 'bulk_edit_form' ]) !!}
                    {!! Form::hidden('selected_products', null, ['id' => 'selected_products_for_edit']); !!}
                    <button type="submit" class="btn btn-xs btn-primary" id="edit-selected"> <i class="fa fa-print"></i>{{__('Bulk Print')}}</button>
                    {!! Form::close() !!}
                    &nbsp;
                    
                @endcan
            </div>
            </td>
        </tr>
    </tfoot>
    </table>
</div>