
<option value="{{$childCategory->id}}"><?php echo $str; ?>{{ $child_category->name }}</option>
	@if ($child_category->categories)  <!-- categories này là của hàm MODEl chứ ko pải là lấy cái ở controller nha -->
			
        @foreach ($child_category->categories as $childCategory)
        	
            @include('admin.category.child_edit', ['child_category' => $childCategory,'str'=>$str."-"])
        @endforeach
	    
@endif