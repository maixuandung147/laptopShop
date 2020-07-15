@extends('user.master_user')
@section('content')
<div class="wrap">
	@include('user.header.header')
@if(session('thongbao'))
<div class="alert alert-success" role="alert" style="color: #2500ff;">
	{{session('thongbao')}}
</div>
@endif
<form action="{{route('store-suggest')}}" method="POST" style="margin-top: 2%;">
    @csrf
    @if(Auth::check())
    <div class="form-group row">
		<label for="email" class="col-sm-2 form-control-label">Email:</label>
		<div class="col-sm-8">
			<input type="email" name="email" class="form-control email" id="email" placeholder="test@example.com" value="{{Auth::user()->email}}" readonly>
		</div>
	</div>
	<div class="form-group row">
		<label for="fullname" class="col-sm-2 form-control-label">User_Name:</label>
		<div class="col-sm-8">
			<input type="text" name="fullname" class="form-control" id="fullname" placeholder="Maniruzzaman" minlength="2" value="{{Auth::user()->username}}" readonly>
		</div>
	</div>
	<div class="form-group row">
		<label for="telephone" class="col-sm-2 form-control-label">Số Điện Thoại:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Enter Phone Number" value="{{Auth::user()->telephone}}" readonly>
		</div>
	</div>
    @else
	<div class="form-group row">
		<label for="email" class="col-sm-2 form-control-label">Email:</label>
		<div class="col-sm-8">
			<input type="email" name="email" class="form-control email" id="email" placeholder="test@example.com">
		</div>
	</div>
	<div class="form-group row">
		<label for="fullname" class="col-sm-2 form-control-label">Full_Name:</label>
		<div class="col-sm-8">
			<input type="text" name="fullname" class="form-control" id="fullname" placeholder="Maniruzzaman" minlength="2" value="{{Auth::user()->username}}" readonly>
		</div>
	</div>
	<div class="form-group row">
		<label for="telephone" class="col-sm-2 form-control-label">Số Điện Thoại:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Enter Phone Number" required>
		</div>
	</div>
	@endif

    <div class="form-group">
        <label>Name Category *</label>
        <select class="form-group" name="cate_id" id="idCate" >
            @foreach ($categories as $item) 
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Name Product *</label>
        <select class="form-group" name="product_id" id="idPro">
        </select>
    </div>
     <div class="form-group">
        <label >Content *</label>
        <textarea class="form-control"  id="demo" rows="3" name="content">{!! old('content') !!}</textarea>
        
        <div class="p-3 mb-2 bg-danger text-white" style="color: red;">{!! $errors->first('price')!!}</div>
    </div>


    <button type="submit" class="btn btn-default">Send</button>
    <button type="reset" class="btn btn-default">Reset</button>
<form>
</div>

			
	
</div>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#idCate').change(function(){
        var idCate = $(this).val();
        $.ajax({
            type: 'get',
            url: '/suggest/ajax/'+idCate,
            success:function($resuld){
                 var html ='';
                    $.each($resuld.data,function($key,$value){
                        if ($value['supplier_id']==idCate) {
                            html +='<option value='+$value['id']+' selected>';
                                html += $value['name'];
                            html += '</option>';
                        }else{
                            html +='<option value='+$value['id']+' >';
                                html += $value['name'];
                            html += '</option>';
                        }
                    });
                        $('#idPro').html(html);
            }
        })
    })

})
</script>
@include("user.footer.footer")
@endsection