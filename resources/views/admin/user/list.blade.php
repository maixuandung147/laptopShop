@extends('admin.index')
@section('content')
<div style="text-align: center;">
	<h1>User
    <small>List</small>
    </h1>
    <hr>
</div>
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
		Level
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<button class="dropdown-item admin" type="button" id="admin" value="1">Admin</button>
			<button class="dropdown-item user" type="button" id="user" value="2">User</button>
		</div>
	</div>
</div>

<div style="padding-top: 2%" id="table_data">
	@include('admin.user.pagin')
</div>	

@include('admin.user.detailr')
@include('admin.user.edit_user')
@include('admin.user.delete_user')

	
<script src="{{ asset('admin/js/admin/ajaxUser/ajax.js') }}"></script>
@endsection
