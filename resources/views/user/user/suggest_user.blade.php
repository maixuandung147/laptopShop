@extends('user.master_user')
@section('content')
	<div class="wrap">
		<div class="header">
			<div class="headertop_desc">
				<div class="call">
					<a href="{{route('home')}}"><button type="button" class="btn btn-danger">TRANG CHỦ</button></a>
				</div>
				<div class="account_desc">
					<ul>
						@if(Auth::check())
							<li><a href="{{route('user',Auth::user()->id)}}">Xin chào {{Auth::user()->fullname}}</a></li>
							<li><a href="#">Delivery</a></li>
							<!-- <li><a href="#">Checkout</a></li> -->
							<li><a href="{{route('logout')}}">Đăng xuất</a></li>
							<!-- <li><a href="#">My Account</a></li> -->
						@else
							<li><a href="{{route('register')}}">Đăng ký</a></li>
							<li><a href="{{route('login')}}">Đăng nhập</a></li>
							<li><a href="#">Delivery</a></li>
							<!-- <li><a href="#">Checkout</a></li> -->
							<!-- <li><a href="#">My Account</a></li> -->
						@endif
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="header_top">
				<div class="logo">
					<a href="{{route('home')}}"><img src="{{ asset('images/logo.png') }}"></a>
				</div>

				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="wrap">
	<div class="content-area">

		<div class="account-page">
			<div class="container">

				<div class="row">
					<div class="col-sm-4">
						<h2>Tài khoản của tôi</h2>
						<ul>
							<li  class="active"><a href="{{route('user',$user->id)}}">Bảng điều khiển tài khoản</a></li>
							<li ><a href="{{route('order-user',$user->id)}}">Tất cả đơn hàng của tôi</a></li>
							<li><a href="{{route('product-user',$user->id)}}">Tất cả sản phẩm đã mua</a></li>
						</ul>
					</div>
					<div class="col-sm-8">
						<h2>Danh sách đề nghị</h2>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th scope="col">STT</th>
									<th scope="col">Email</th>
									<th scope="col">Name_Product</th>
									<th scope="col">Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($suggests as $value)
								<tr>
									<td>{{$value->id}}</td>
						            <td>{{$value->email}}</td>
						            <td>{{$value->name_product}}</td>
						            <td class="status_{{$value->id}}">
						            	@if($value->status == 0)
						            		{!! "Chưa xem" !!}
						            	@else
						            		{!! "Đã xem" !!}
						            	@endif
						            </td>

								</tr>
								@endforeach
							</tbody>
						</table>


						
					</div>
				</div> <!--End Row-->

			</div>
		</div> <!--End Account page div-->

	</div> <!-- End content Area class -->
	</div>
	@include('user.footer.footer')
@endsection