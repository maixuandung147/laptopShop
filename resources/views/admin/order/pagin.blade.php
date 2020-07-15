<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">STT</th>
			<th scope="col">Email</th>
			<th scope="col">Order_Date</th>
			<th scope="col">Delivery_Date</th>
			<th scope="col">Deliver_Status</th>
			<th scope="col"></th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_orders as $value)
		<tr>
			<td>{{$value->id}}</td>
            <td>{{$value->email}}</td>
            <td>{{$value->order_date}}</td>
            <td id="date_{{$value->id}}">{{$value->delivery_date}}</td>
            <td class="status_{{$value->id}}">
            	@if($value->deliver_status == 0)
                    {{"Chờ xử lý"}}
                @elseif($value->deliver_status == 1)
                    {{"Đang giao hàng"}}
                @else 
                    {{"Hoàn thành"}}
                @endif
            </td>
            <td>
            	<a href="{{route('order.show',$value->id)}}">Show</a>
            </td>
			<td>
				<button data-url="{{route('order.edit',$value->id)}}" class="btn btn-primary edit-order" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
			</td>
			<td>
				<button data-url="{{route('order.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{!!  $list_orders->links() !!}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_quantity_type" id="hidden_quantity_type" />