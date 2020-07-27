<div class="header">
		<div class="headertop_desc">
			<div class="call">
				 <a href="{{route('home')}}"><button type="button" class="btn btn-danger">TRANG CHỦ</button></a>
			</div>
			<div class="account_desc">
				<ul>
					@if(Auth::check())
						<li><a href="{{route('user', Auth::user()->id)}}">Xin chào {{Auth::user()->fullname}}</a></li>
						@if(Auth::user()->level == 1)
						<li><a href="{{route('home.index')}}">Admin</a></li>
						@endif
						<li><a href="#">Delivery</a></li>
						<!-- <li><a href="{{route('checkout')}}">Checkout</a></li> -->
						<!-- <li><a href="#">My Account</a></li> -->
						<li><a href="#" id="btn_logout">Đăng xuất</a></li>
					@else
						<li><a href="{{route('register')}}">Đăng ký</a></li>
						<li><a href="{{route('login')}}">Đăng nhập</a></li>
						<li><a href="#">Delivery</a></li>
						<!-- <li><a href="{{route('checkout')}}">Checkout</a></li> -->
						<!-- <li><a href="#">My Account</a></li> -->
					@endif
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="header_top">
			<div class="logo">
				<a href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" alt="" /></a>
			</div>
			  <div class="cart">
			  	   <p>Chào mừng bạn đến với cửa hàng! 
				  	   	<span>

				  	   		<a href=" {{route('cart-index')}}"
				  	   			title="Bạn đã mua {{Cart::count()}}">Cart:
				  	   		</a>
				  	   	</span>
				  	   	<div id="dd" class="wrapper-dropdown-2">
				  	   		 {{Cart::count()}} sản phẩm 

				  	   		
				  	   		<ul class="dropdown">
								<li>Bạn có @if(Cart::count()<0) {{no}} @else {{Cart::count()}} @endif sản phẩm trong giỏ hàng</li>
							</ul>
						</div>
					</p>
			  </div>
			  <script type="text/javascript">
			function DropDown(el) {
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-2').removeClass('active');
				});

			});

		</script>
	 <div class="clear"></div>
  </div>
	<div class="header_bottom">
	     	<div class="menu">
	     		<ul>
			    	<li class="active"><a href="{{route('home')}}">Trang chủ</a></li>
			    	<li><a href="about.html">Về chúng tôi</a></li>
			    	<li><a href="delivery.html">Vận chuyển</a></li>
			    	<li><a href="news.html">Tin tức</a></li>
			    	<li><a href="{{route('create-suggest')}}">Liên hệ</a></li>
			    	<div class="clear"></div>
     			</ul>
	     	</div>
	     	<div class="search_box">
	     		<form action="{{route('list-product')}}" method="get" id="form-search">
	     			@csrf
	     			<input type="text" name="search" id="search" >
	     			<input type="submit" value="">
	     		</form>
	     	</div>
	     	<div class="clear"></div>
	     </div>	     
	