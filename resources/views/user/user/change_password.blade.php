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
							<li><a href="{{route('user',$user->id)}}">Xin chào {{Auth::user()->fullname}}</a></li>
							@if(Auth::user()->level == 1)
						<li><a href="{{route('home.index')}}">Admin</a></li>
						@endif
							<li><a href="#">Delivery</a></li>
							<!-- <li><a href="#">Checkout</a></li> -->
							<li><a href="{{route('logout')}}">Đăng xuất</a></li>
							<!-- <li><a href="#">My Account</a></li> -->
						@else
							<li><a href="{{route('register')}}">Register</a></li>
							<li><a href="{{route('login')}}">Login</a></li>
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
						@if(count($errors)>0)
							<div class="alert alert-danger">
								@foreach($errors->all() as $error)
									{{$error}}
								@endforeach
							</div>
						@endif
						@if(Session::has('success'))
							<div class="alert alert-success">{{Session::get('success')}}</div>
							@endif
						<div class="col-sm-3">
							<h2>My Account</h2>
							<ul>
								<li><a href="{{route('user', Auth::user()->id)}}">Account Control Panel</a></li>
								<li  ><a href="{{route('information-user',Auth::user()->id)}}">Personal Information</a></li>
								<li class="active"><a href="{{route('change-password',Auth::user()->id)}}">Change Password</a></li>
								<li><a href="{{route('order-user',Auth::user()->id)}}">My Orders</a></li>
								<li><a href="{{route('product-user',Auth::user()->id)}}">My Products</a></li>
							</ul>
						</div>
						<div class="col-sm-9">
							<h2>Đổi mật khẩu</h2>
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<form method="post" class="cmxform" action="{{route('password-update', $user->id)}}" id="editForm" enctype="multipart/form-data">
										{{ method_field('PUT')  }}
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<div class="form-group row">
											<label for="password" class="col-sm-2 form-control-label">Mật Khẩu Mới:</label>
											<div class="col-sm-8">
												<input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
											</div>
										</div>
										
										<div class="form-group row">
											<label for="confirm_password" class="col-sm-2 form-control-label">Xác Nhận Mật Khẩu Mới:</label>
											<div class="col-sm-8">
												<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Same password previously entered">
											</div>
										</div>
									

										<div class="form-group row">
											<div class="col-sm-offset-2 col-sm-8">
												<input type="submit" class="btn btn-yellow btn-lg" id="submitForm" value="Save" />
											</div>
										</div>
									</form>
								</div>
							</div> <!--End Row-->
						</div>
					</div> <!--End Row-->

				</div>
			</div> <!--End Account page div-->

		</div> <!-- End content Area class -->
	</div>
	@include('user.footer.footer')
@endsection