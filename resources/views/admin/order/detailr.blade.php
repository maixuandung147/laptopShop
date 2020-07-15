@extends('admin.index')
@section('content')
<div>
	<h1>Customer Infomation
    <small style="color: blue;">
		{{$user->fullname}}
    </small>
    </h1>
    <hr>
    <a href="{{route('order.index')}}"><button type="button" class="btn btn-primary">BACK</button></a>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr align="center">
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd gradeX" align="center">
                <td>{{$user->email}}</td>
                <td>{{$user->telephone}}</td>
                <td>{{$user->delivery_address}}</td>      
            </tr>
        </tbody>
    </table>
</div>
<div>
	<h1>List Orders Detail
    </h1>
    <hr>
     <table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
		    <tr align="center">
		        <th>STT</th>
		        <th>Name Product</th>
		        <th>Promotion</th>
		        <th>Quantity</th>
		        <th>Price</th>
		        <th>Total</th>
		    </tr>
		</thead>
		<tbody>
		    <?php $total=0; ?>
		    @foreach($list_detailrs as $key=>$item)
		    
		    <?php $promotion=0; ?>
		    <tr class="odd gradeX" align="center">
		        <td>{{$key=$key+1}}</td>
		        <td>{{$item->products->name}}</td>
		        <td>
		        @foreach($promotions as $value)
		            @if($value->product_id == $item->product_id && $item->orders->order_date >= $value->start_date && $item->orders->order_date <= $value->end_date)
		            {{"Đã áp dụng"}}
		            <?php $promotion = $value->price ?>
		            @endif
		        @endforeach
		        </td>
		        <td>{{$item->quantity}}</td>
		        <td>${{$item->price - $promotion }}</td>
		        <td>${{($item->price - $promotion)*$item->quantity}}</td>
		        <?php $total +=($item->price - $promotion)*$item->quantity ?>
		    </tr>
		     @endforeach
		</tbody>
    </table>
</div>
<div>
	<span style="color: red;font-size: 37px;">Tổng tiền thanh toán :${{$total}}</span><br>
	<span style="color: blue;font-size: 25px;">Deliver_Status :
        @if($status->deliver_status == 0)
            
            <button data-url="{{route('order.edit',$status->id)}}" class="btn btn-primary edit-order" data-toggle="modal" data-target="#edit" type="button"><p class="status_{{$status->id}}">Chờ xử lý</p> </button>
        @elseif($status->deliver_status == 1)
            
            <button data-url="{{route('order.edit',$status->id)}}" class="btn btn-primary edit-order" data-toggle="modal" data-target="#edit" type="button"><p class="status_{{$status->id}}">Đang giao hàng</p></button>
        @else 
            
            <button data-url="{{route('order.edit',$status->id)}}" class="btn btn-primary edit-order" data-toggle="modal" data-target="#edit" type="button"><p class="status_{{$status->id}}">Hoàn thành</p> </button>
        @endif
    </span>
</div>

@include('admin.order.edit_order')

<script src="{{ asset('admin/js/admin/ajaxOrder/ajax.js') }}"></script>
@endsection
