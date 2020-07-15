<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">STT</th>
			<th scope="col">Email</th>
			<th scope="col">Name_Product</th>
			<th scope="col">Status</th>
			<th scope="col"></th>
			<th >Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_suggests as $value)
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
            <td>
            	<button data-url="{{route('suggest.show',$value->id)}}"​ type="button" data-target="#show" data-toggle="modal" class="btn btn-info btn-show">Show</button>
            </td>
			<td>
				<button data-url="{{route('suggest.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{!!  $list_suggests->links() !!}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_quantity_type" id="hidden_quantity_type" />