<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Name</th>
			<th scope="col">Parent_Name</th>
			<th scope="col">Desription</th>
			<th scope="col">Category_Children</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_categories as $value)
		<tr>
			<th scope="row">{{$value->id}}</th>
			<td id="name_{{$value->id}}">{{$value->name}}</td>
			<td id="parent_id_{{$value->id}}">
				@if($value->parent_id == 0)
                    {!!"None"!!}
                @else
                   @foreach($children as $item)
                        @if($item->id == $value->parent_id)<!-- Ở đây ta so sánh vs list_categories danh sách đe lọc ra -->
                            {{$item->name}}
						@else
							@foreach($item->childrenCategories as $childCategory)
								@include('admin.category.de_quy', ['child_category' => $childCategory])
							@endforeach
                        @endif

                    @endforeach          
                @endif
			</td>
			<td id="desription_{{$value->id}}">{{$value->desription}}</td>
			<td><a href="{{route('category.show',$value->id)}}">Show</a></td>
			<td>
				<button data-url="{{route('category.edit',$value->id)}}" class="btn btn-primary edit-category" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
			</td>
			<td>
				<button data-url="{{route('category.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{!!  $list_categories->links() !!}