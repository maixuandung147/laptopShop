<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">STT</th>
			<th scope="col">Name</th>
			<th scope="col">Category_Name</th>
			<th scope="col">Quantity</th>
			<th scope="col">Images</th>
			<th scope="col">Note</th>
			<th scope="col"></th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_products as $value)
		<tr>
			<td>{{$value->id}}</td>
            <td id="name_{{$value->id}}">{{$value->name}}</td>
            <td id="category_id_{{$value->id}}">{{$value->categoies->name}}</td>
            <td id="quantity_{{$value->id}}">{{$value->quantity}}</td>
            <td>
                @foreach($value->product_images as $key=>$valus)
                @if($value->id == $valus->product_id)
                @if($key == 0)
                <img src="/uploads/{{$valus->path}}" alt="" width="25%"></img>
                @endif
                @endif
                @endforeach
            </td>
            <td id="note_{{$value->id}}">
                @if($value->note == 0)
                    <button data-url="{{route('product.like',$value->id)}}" class="notlike"><i class="fa fa-star-o" aria-hidden="true"></i></button>
                @else
                    <button data-url="{{route('product.like',$value->id)}}" class="like"><i class="fa fa-star" aria-hidden="true"></i></button>
                @endif

            </td>
            <td><a href="{{route('product.show',$value->id)}}">Show</a></td>
			<td>
				<button data-url="{{route('product.edit',$value->id)}}" class="btn btn-primary edit-product" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
			</td>
			<td>
				<button data-url="{{route('product.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{!!  $list_products->links() !!}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_quantity_type" id="hidden_quantity_type" />