@extends('admin.index')
@section('content')
<div style="text-align: center;">
	<h1>Products
    <small>List</small>
    </h1>
    <hr>
</div>
@if(session('thongbao'))
    <div class="alert alert-success" role="alert">
        {{session('thongbao')}}
    </div>
@endif
<div class="minh-fix" style="display: flex; justify-content: flex-start; align-content: center;">
	<div>
		<nav class="navbar navbar-light bg-light justify-content-between">
		  <form class="form-inline" action="" method="get" id="form-search">
			@csrf
			<input class="form-control mr-sm-2" type="search" id="search" name="search" >
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
		  </form>
		</nav>

	</div>

	<div class="dropdown" style="float: left;margin-right: 2%;margin-left: 38%;">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Quantity
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<button class="dropdown-item quantity" type="button" id="remaining" value="1">Quantity_Remaining</button>
			<button class="dropdown-item quantity_out" type="button" id="out" value="2">Quantity_Out</button>
		</div>
	</div>

	<div class="btn-group">
		<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Favourite
		</button>
		<div class="dropdown-menu dropdown-menu-right">
			<button class="dropdown-item love" type="button" id="love" value="3">Like</button>
			<button class="dropdown-item notLove" type="button" id="notLove" value="4">Not Like</button>
		</div>
	</div>
</div>

<div style="padding-top: 2%" id="table_data">
	@include('admin.product.pagin')
</div>	
@include('admin.product.edit_product')
@include('admin.product.delete_product')
			


<script src="{{ asset('admin/js/admin/ajaxProduct/ajax.js') }}"></script>
@endsection
