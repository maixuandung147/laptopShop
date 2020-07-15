@extends('admin.index')
@section('content')
<div style="text-align: center;">
	<h1>Suggests
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
		Status
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<button class="dropdown-item xem" type="button" id="xem" value="1">Đã xem</button>
			<button class="dropdown-item chuaX" type="button" id="chuaX" value="2">Chưa xem</button>
		</div>
	</div>
</div>

<div style="padding-top: 2%" id="table_data">
	@include('admin.suggest.pagin')
</div>	

@include('admin.suggest.detailr')
@include('admin.suggest.delete_suggest')

	
<script src="{{ asset('admin/js/admin/ajaxSuggest/ajax.js') }}"></script>
@endsection
