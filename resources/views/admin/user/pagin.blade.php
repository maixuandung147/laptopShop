<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th scope="col">STT</th>
			<th scope="col">Full_Name</th>
			<th scope="col">Email</th>
			<th scope="col">Level</th>
			<th scope="col"></th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_users as $value)
		<tr>
			<td>{{$value->id}}</td>
            <td>{{$value->fullname}}</td>
            <td>{{$value->email}}</td>
            <td class="level_{{$value->id}}">
            	@if($value->level == 0)
            		{!! "User" !!}
            	@else
            		{!! "Admin" !!}
            	@endif
            </td>
            <td>
            	<button data-url="{{route('user.show',$value->id)}}"​ type="button" data-target="#show" data-toggle="modal" class="btn btn-info btn-show">Show</button>
            </td>
			<td>
				<button data-url="{{route('user.edit',$value->id)}}" class="btn btn-primary edit-user" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button>
			</td>
			<td>
				<button data-url="{{route('user.destroy',$value->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete"><i class="fa fa-trash-o  fa-fw"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{!!  $list_users->links() !!}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_quantity_type" id="hidden_quantity_type" />