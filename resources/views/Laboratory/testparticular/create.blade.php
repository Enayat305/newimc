@extends('lab_layouts.app')
@section('title', __('test.test_particular'))

@section('content')
<style type="text/css">

.table-wrapper {
		width: 700px;
		margin: 30px auto;
        background: #fff;
        padding: 20px;	
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
		height: 30px;
		font-weight: bold;
		font-size: 12px;
		text-shadow: none;
		min-width: 100px;
		border-radius: 50px;
		line-height: 13px;
    }
	.table-title .add-new i {
		margin-right: 4px;
	}
   
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
		cursor: pointer;
        display: inline-block;
        margin: 0 5px;
		min-width: 24px;
    }    
	table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table td a.add i {
        font-size: 24px;
    	margin-right: -1px;
        position: relative;
        top: 3px;
    }    
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
	table.table .form-control.error {
		border-color: #f50000;
	}
	table.table td .add {
		display: none;
	}

</style>
<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('test.test_particular')
        <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
{!! Form::open(['url' => action('Lab\TestParticularController@store'), 'method' => 'post', 'id' => 'ssgd', 'files' => true ]) !!}

<!-- Main content -->
<section class="content no-print">
    @component('components.filters', ['title' => __('report.filters')])
 
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('repothead_id', __('Report Head') . ':') !!}
                {!! Form::text('name',null, ['placeholder' => __('Report Head'), 'class' => 'form-control','required']); !!}            </div>
        </div>
		<div class="col-md-3" >
            <div class="form-group">

				{!! Form::label('is_show', __('Is Shows In Print') . ':') !!}
				<br>
				
                {!! Form::checkbox('is_show','1',true , 
                [ 'class' => 'input-icheck']); !!}
            
			</div>
		</div>
    @endcomponent

	
        
	@component('components.widget', ['class' => 'box-primary'])
	
		<div class="table-title">
			<div class="row">
				<div class="col-sm-8"><h2>Test Particular <b>Details</b></h2></div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
				</div>
			</div>
		</div>
	
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-condensed table-bordered table-th-green text-center table-striped" id="test_particular_entry_table">
					<thead>
						<tr>
						<th>Name</th>
                        <th>Result</th>
						<th>Unit</th>
						<th>Male Range</th>
                        <th>Female Range</th>
						<th>High Range</th>
						<th>Low Range</th>
						<th>Actions</th>
						
                    </tr>	
					</thead>
					<tbody>
					
						<tr>
							<td><input type="text" class="form-control" required name="particular[0][name]" ></td>
							<td><textarea type="text" class="form-control" name="particular[0][result]" rows="7"></textarea></td>
							<td><input type="text" class="form-control" name="particular[0][unit]"></td>
							<td><input type="text" class="form-control" name="particular[0][malerange]"></td>
							<td><input type="text" class="form-control" name="particular[0][femalerange]"></td>
							<td><input type="text" class="form-control" name="particular[0][highrange]"></td>
							<td><input type="text" class="form-control" name="particular[0][lowrange]"></td>
							<td>
								
								<a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
							</td>
						</tr>      
					</tbody>
				</table>
			</div>
			
			</table>
			</div>

		
		</div>
		<div class="row">
				<div class="col-sm-12">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
                  <button type="submit" class="btn btn-primary pull-right btn-flat">@lang( 'messages.save' )</button>
 				</div>
			</div>
	</div>
@endcomponent
{!! Form::close() !!}
</section>

<section id="receipt_section" class="print_section"></section>

<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var actions = $("table td:last-child").html();
	// Append table with add row form on add new button click
    $(".add-new").click(function(){
	
		var index = $("table tbody tr:last-child").index();
		var rowCount = $('#test_particular_entry_table tr').length;
		rowindex=rowCount-1;
		
        var row = '<tr>' +
			               '<td><input type="text" class="form-control" required id="name"name="particular['+rowindex+'][name]" ></td>'+
							'<td><textarea type="text" class="form-control" name="particular['+rowindex+'][result]" rows=7></textarea></td>'+
							'<td><input type="text" class="form-control" name="particular['+rowindex+'][unit]"></td>'+
							'<td><input type="text" class="form-control" name="particular['+rowindex+'][malerange]"></td>'+
							'<td><input type="text" class="form-control" name="particular['+rowindex+'][femalerange]"></td>'+
							'<td><input type="text" class="form-control" name="particular['+rowindex+'][highrange]"></td>'+
							'<td><input type="text" class="form-control" name="particular['+rowindex+'][lowrange]"></td>'+
			              
					
			'<td>' + actions + '</td>' +
        '</tr>';
    	$("table").append(row);		
		$("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });
	// Add row on add button click
	$(document).on("click", ".add", function(){
		var empty = false;
		var input = $(this).parents("tr").find('#name');
        input.each(function(){
			if(!$('#name').val()){
				$(this).addClass("error");
				empty = true;
			} else{
                $(this).removeClass("error");
            }
		});
		$(this).parents("tr").find(".error").first().focus();
		if(!empty){
			input.each(function(){
				$(this).parent("td").html($(this).val());
			});			
			
		}		
    });

	// Delete row on delete button click
	$(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
		$(".add-new").removeAttr("disabled");
    });
});
</script>
@endsection