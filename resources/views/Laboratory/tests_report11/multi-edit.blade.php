@extends('lab_layouts.guest')
@section('title', '45')
@section('content')

<div class="container" style="background-color:#fff;" >
    <div class="spacer"></div>
    <div class="row">
        <div class="col-md-12 text-right" >
            <button type="button" class="btn btn-primary no-print" id="print_invoice" 
                 aria-label="Print"><i class="fas fa-print"></i> @lang( 'messages.print' )
            </button>
            @auth
                <a href="{{action('Lab\Multi_ReportController@create')}}" class="btn btn-success no-print" ><i class="fas fa-backward"></i>
                </a>
            @endauth
        </div>
    </div>
    <div class="row" >
        <div class="col-md-9 col-sm-9" style="border: 1px solid #ccc; margin-left:50px">
            <div class="spacer"></div>
            <div id="invoice_content">
                {!! $receipt['html_content'] !!}
            </div>
            <div class="spacer"></div>
        </div>
    </div>
    <div class="spacer"></div>
</div>
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#print_invoice', function(){
            $('#invoice_content').printThis();
        });
    });
    @if(!empty(request()->input('print_on_load')))
        $(window).on('load', function(){
            $('#invoice_content').printThis();
        });
    @endif
</script>
@endsection