@extends('user.master_user')
@section('content')
<div class="wrap">
	@include('user.header.header')
	@include('user.header.header_slide')
<div id="table_data">
	@include("user.product.pagination")
</div>		

			
	
</div>
<script src="{{ asset('js/user/ajax/ajaxProduct.js') }}"></script>
@include("user.footer.footer")
@endsection