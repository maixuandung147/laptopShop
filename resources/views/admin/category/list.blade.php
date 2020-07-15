@extends('admin.index')
@section('content')
<div style="text-align: center;">
	<h1>Category
    <small>List</small>
    </h1>
    <hr>
</div>
@if(session('thongbao'))
    <div class="alert alert-success" role="alert">
        {{session('thongbao')}}
    </div>
@endif
<div>
	<nav class="navbar navbar-light bg-light justify-content-between">
	  <form class="form-inline" action="" method="get" id="form-search">
		@csrf
		<input class="form-control mr-sm-2" type="search" id="search" name="search" >
		<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
	  </form>
	</nav>
</div>
<div style="padding-top: 2%" id="table_data">
	@include('admin.category.pagin')
	<input type="hidden" name="hidden_page" id="hidden_page" value="1" /><!-- tạo 1 input ẩn đê ta láy giá trị page mơi làm đk ajax -->
</div>	
@include('admin.category.edit_category')
@include('admin.category.delete_category')
			


<script src="{{ asset('admin/js/admin/ajaxCategory/ajax.js') }}"></script>
@endsection
