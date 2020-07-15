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
						@if(Session::has('success'))
							<div class="alert alert-success">{{Session::get('success')}}</div>
							@endif
						<div class="col-sm-3">
							<h2>My Account</h2>
							<ul>
								<li><a href="{{route('user', Auth::user()->id)}}">Account Control Panel</a></li>
								<li  class="active"><a href="{{route('information-user',Auth::user()->id)}}">Personal Information</a></li>
								<li ><a href="{{route('change-password',Auth::user()->id)}}">Change Password</a></li>
								<li><a href="{{route('order-user',Auth::user()->id)}}">My Orders</a></li>
								<li><a href="{{route('product-user',Auth::user()->id)}}">My Products</a></li>
							</ul>
						</div>
						<div class="col-sm-9">
							<h2>Edit Account</h2>
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<form method="post" class="cmxform" action="{{route('update-user', $user->id)}}" id="editForm" enctype="multipart/form-data">
										{{ method_field('PUT')  }}
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<div class="form-group row">
											<label for="fullname" class="col-sm-2 form-control-label">Full Name:</label>
											<div class="col-sm-8">
												<input type="text" name="fullname" class="form-control" id="firstname" value="{{$user->fullname}}" minlength="2" required >
											</div>
										</div>
									
										<div class="form-group row">
											<label for="email" class="col-sm-2 form-control-label">Email:</label>
											<div class="col-sm-8">
												<input type="email" name="email" class="form-control email" id="email" value="{{$user->email}}" readonly="">
											</div>
										</div>

										<div class="form-group row">
											<label for="username" class="col-sm-2 form-control-label">Username:</label>
											<div class="col-sm-8">
												<input type="text" name="username" class="form-control" id="username" value="{{$user->username}}" readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label  class="col-sm-2 form-control-label">Ảnh đại diện</label>
											<div class="col-sm-8">
												<input type="file" class="form-control" name="image" id="image" >
												<img src="/avatar/{{$user->image}}" alt="" width="18%"></img>
											</div>
										</div>
										<div class="form-group row">
											<label for="telephone" class="col-sm-2 form-control-label">Phone Number:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="telephone" id="telephone" value="{{$user->telephone}}" required>
											</div>
										</div>

										<fieldset class="form-group">
											<div class="row">
												<label class="col-md-2">Gender:</label>
												<div class="col-md-6">
													
													<input type=radio name="sex" value="0" {{ $user->sex == '0' ? 'checked' : ''}}>Male</option>
													
													<input type=radio name="sex" value="1" {{ $user->sex == '1	' ? 'checked' : ''}}>Female</option>            
													
												</div>



											</div>
										</fieldset>

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