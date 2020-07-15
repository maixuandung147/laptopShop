@extends('admin.index')
@section('content')
<div style="text-align: center;">
	<h1>Promotions
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
		Status
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<button class="dropdown-item khuyen" type="button" id="khuyen" value="1">Khuyến mãi</button>
			<button class="dropdown-item het" type="button" id="het" value="2">Hết khuyến mãi</button>
		</div>
	</div>

</div>

<div style="padding-top: 2%" id="table_data">
	@include('admin.promotion.pagin')
</div>	
@include('admin.promotion.edit_promotion')
@include('admin.promotion.delete_promotion')
			


<script src="{{ asset('admin/js/admin/ajaxPromotion/ajax.js') }}"></script>
@endsection
