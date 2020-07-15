@if ($child_category->categories)     <!-- Ở đây tk categories ở function MODEL Category -->
	@if($child_category->id == $value->parent_id)
        {{$child_category->name}}
    @else
	    @foreach($child_category->childrenCategories as $childCategory)
			@include('admin.category.de_quy', ['child_category' => $childCategory])
	    @endforeach
    @endif
@endif