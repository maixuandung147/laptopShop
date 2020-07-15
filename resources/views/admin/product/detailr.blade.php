@extends('admin.index')
@section('content')
<div>
	<h1>Products
    <small style="color: blue;">{{$product_detailr->name}}</small>
    </h1>
    <hr>
</div>
@if(session('thongbao'))
    <div class="alert alert-success" role="alert">
        {{session('thongbao')}}
    </div>
@endif
<a href="{{route('product.index')}}"><button type="button" class="btn btn-primary">BACK</button></a>
<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">Name</th>
			<th scope="col">Category_Name</th>
			<th scope="col">Quantity</th>
			<th scope="col">Price</th>
			<th scope="col">RAM</th>
			<th scope="col">VGA</th>
			<th scope="col">Operating_System</th>
			<th scope="col">CPU</th>
			<th scope="col">Description</th>
			<th scope="col">Sales_volume</th>
			<th scope="col">Note</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<tr>
            <td id="name_{{$product_detailr->id}}">{{$product_detailr->name}}</td>
            <td id="category_id_{{$product_detailr->id}}">{{$product_detailr->categoies->name}}</td>
            <td id="quantity_{{$product_detailr->id}}">{{$product_detailr->quantity}}</td>
            <td id="price_{{$product_detailr->id}}">{{$product_detailr->price}}</td>
            <td id="RAM_{{$product_detailr->id}}">{{$product_detailr->RAM}}</td>
            <td id="VGA_{{$product_detailr->id}}">{{$product_detailr->VGA}}</td>
            <td id="operating_system_{{$product_detailr->id}}">{{$product_detailr->operating_system}}</td>
            <td id="CPU_{{$product_detailr->id}}">{{$product_detailr->CPU}}</td>
            <td id="description_{{$product_detailr->id}}">{{$product_detailr->description}}</td>
            <td id="sales_volume_{{$product_detailr->id}}">{{$product_detailr->sales_volume}}</td>
            <td id="note_{{$product_detailr->id}}">
                @if($product_detailr->note == 0)
                    <button data-url="{{route('product.like',$product_detailr->id)}}" class="notlike"><i class="fa fa-star-o" aria-hidden="true"></i></button>
                @else
                    <button data-url="{{route('product.like',$product_detailr->id)}}" class="like"><i class="fa fa-star" aria-hidden="true"></i></button>
                @endif

            </td>
			<td>
				<button data-url="{{route('product.edit',$product_detailr->id)}}" class="btn btn-primary edit-product" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
			</td>

		</tr>
	</tbody>
</table>
<div>
	<h1>Products Images
    <small style="color: blue;">{{$product_detailr->name}}</small>
    </h1>
    <hr>
    <div>
        <form action="{{ route('post.image',$id) }}" method="POST" role="form" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
			<label>Image *</label>
			<input  type="file" name="image[]" multiple />
			</div>
			<button type="submit" class="btn btn-default">Upload</button>
		</form>
    </div>
</div>
<div>
	@foreach($product_image as $item)
	    @if($item->id != 0)
	    
	    <img src="/uploads/{{$item->path}}" alt="" width="33%"></img>
	    <button data-url="{{route('image.destroy',$item->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-del-image"><i class="fa fa-times" aria-hidden="true"></i></button>
	    @endif
	@endforeach
</div>
@include('admin.product.edit_product')
@include('admin.product.delete_product')
<script src="{{ asset('admin/js/admin/ajaxProduct/ajax.js') }}"></script>
@endsection
