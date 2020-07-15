<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">STT</th>
			<th scope="col">Name Product</th>
			<th scope="col">Promotion</th>
			<th scope="col">Start Date</th>
			<th scope="col">End Date</th>
			<th scope="col">Status</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		
		@if($products != NULL)
			@foreach($list_promotions as $value)
			@foreach($products as $item)
				@if($value->product_id == $item->id)
					<tr>
						<td>{{$value->id}}</td>
			            <td >{{$value->products->name}}</td>
			            <td >${{$value->price}}</td>
			            <td id="start_date_{{$value->id}}">{{$value->start_date}}</td>
			            <td id="end_date_{{$value->id}}">{{$value->end_date}}</td>
			            <td id="status_{{$value->id}}">
			                @if($value->status == 0) 
			                	{{"Hết khuyến mãi"}}
			                @else
			                	{{"Khuyến mãi"}}
			                @endif
			            </td>
						<td>
							<button data-url="{{route('promotion.edit',$value->id)}}" class="btn btn-primary edit-promotion" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
						</td>
						<td>
							<button data-url="{{route('promotion.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
						</td>
					</tr>   
				@endif
			@endforeach
			@endforeach
		@else
			@foreach($list_promotions as $value)
			<tr>
				<td>{{$value->id}}</td>
	            <td id="name_{{$value->id}}">{{$value->products->name}}</td>
	            <td id="price_{{$value->id}}">${{$value->price}}</td>
	            <td id="start_date_{{$value->id}}">{{$value->start_date}}</td>
	            <td id="end_date_{{$value->id}}">{{$value->end_date}}</td>
	            <td id="status_{{$value->id}}">
	                @if($value->status == 0) 
	                	{{"Hết khuyến mãi"}}
	                @else
	                	{{"Khuyến mãi"}}
	                @endif
	            </td>
				<td>
					<button data-url="{{route('promotion.edit',$value->id)}}" class="btn btn-primary edit-promotion" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
				</td>
				<td>
					<button data-url="{{route('promotion.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
				</td>
			</tr>
			@endforeach
		@endif
		
	</tbody>
</table>
{!!  $list_promotions->links() !!}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_quantity_type" id="hidden_quantity_type" />