@extends('layouts.app')
@section('content')

	<div class="container mt-2">
		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-left">
					<h2>Budget Years</h2>
				</div>
				<div class="pull-right mb-2">
					<a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Budget Year</a>
				</div>
			</div>
		</div>
		@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
		@endif
		<div class="card-body">
			<table class="table table-bordered" id="budget-years">
				<thead>
					<tr class="bg-info text-white">
						<th>Id</th>
						<th>Code No</th>
						<th>Budget Year</th>
						<th>From Date</th>
						<th>To Date</th>
						<th>Action</th>
						<th>Updated At</th>
						<th>Updated By</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!-- boostrap company model -->
	<div class="modal fade" id="budget-year-modal" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="BudgetYearModal"></h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" id="BudgetYearForm" name="BudgetYearForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" id="id">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Code No</label>
							<div class="col-sm-12">
								<input type="text" class="form-control" id="CodeNo" name="CodeNo" maxlength="50" required>
							</div>
						</div>  
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Budget Year</label>
							<div class="col-sm-12">
								<input type="text" class="form-control" id="BudgetYear" name="BudgetYear" maxlength="50" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">From Date</label>
							<div class="col-sm-12">
								<input type="date" class="form-control" id="FromDate" name="FromDate" required value="<?php echo date("Y-m-d"); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">To Date</label>
							<div class="col-sm-12">
								<input type="date" class="form-control" id="ToDate" name="ToDate" required value="<?php echo date("Y-m-d"); ?>">
							</div>
						</div>
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary" id="btn-save">Save changes
							</button>
						</div>
					</form>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	$(document).ready( function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$('#budget-years').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ url('budget-years') }}",
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'CodeNo', name: 'budget_years.CodeNo' },
			{ data: 'BudgetYear', name: 'budget_years.BudgetYear' },
			{ data: 'FromDate', name: 'budget_years.FromDate' },
			{ data: 'ToDate', name: 'budget_years.ToDate' },
			{data: 'action', name: 'action', orderable: false},
			{ data: 'updated_at', name: 'budget_years.updated_at' },
			{ data: 'name', name: 'users.name' },
			],
			order: [[0, 'desc']]
		});
	});
	function add(){
		$('#BudgetYearForm').trigger("reset");
		$('#BudgetYearModal').html("Add Budget Year");
		$('#budget-year-modal').modal('show');
		$('#id').val('');
	}   
	function editFunc(id){
		$.ajax({
			type:"POST",
			url: "{{ url('edit-budget-year') }}",
			data: { id: id },
			dataType: 'json',
			success: function(res){
				$('#BudgetYearModal').html("Edit Budget Year");
				$('#budget-year-modal').modal('show');
				$('#id').val(res.id);
				$('#CodeNo').val(res.CodeNo);
				$('#BudgetYear').val(res.BudgetYear);
				$('#FromDate').val(res.FromDate);
				$('#ToDate').val(res.ToDate);
			}
		});
	}  
	function deleteFunc(id){
		if (confirm("Delete Record?") == true) {
			var id = id;
// ajax
$.ajax({
	type:"POST",
	url: "{{ url('delete-budget-year') }}",
	data: { id: id },
	dataType: 'json',
	success: function(res){
		var oTable = $('#budget-years').dataTable();
		oTable.fnDraw(false);
	}
});
}
}
$('#BudgetYearForm').submit(function(e) {
	e.preventDefault();
	var formData = new FormData(this);
	$.ajax({
		type:'POST',
		url: "{{ url('store-budget-year')}}",
		data: formData,
		cache:false,
		contentType: false,
		processData: false,
		success: (data) => {
			$("#budget-year-modal").modal('hide');
			var oTable = $('#budget-years').dataTable();
			oTable.fnDraw(false);
			$("#btn-save").html('Submit');
			$("#btn-save"). attr("disabled", false);
		},
		error: function(data){
			console.log(data);
		}
	});
});
</script>

@endsection