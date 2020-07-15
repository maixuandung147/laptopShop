<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa Category <span class="tittle" style="color: blue;"></span></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin: 5px">
                    <div class="col-lg-12">
                        <form action="" id="form-edit" method="POST" role="form">
                            <div class="form-group">
                            <label>Category Name</label>
                            <input class="form-control" name="name" id="name-edit" />
                            <div class="error" style="color: red;"></div>
                            </div>
                            <div class="form-group">
                            <label>Category Parent</label>
                            <select class="form-group" name="parent_id" id="parent-edit">
                            @foreach ($children as $category) 
                            <?php $str="-" ?>
                            <option value="{{$category->id}}"><?php echo $str; ?>{{ $category->name }}</option>
                            @foreach ($category->childrenCategories as $childCategory)
                            <?php $str."-" ?>
                            @include('admin.category.child_edit', ['child_category' => $childCategory,'str'=>$str.'-' ])
                            @endforeach   
                            @endforeach
                            </select>
                            </div>
                            <div class="form-group">
                            <label>Desription</label>
                            <input class="form-control" name="desription" id="desription-edit"/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>