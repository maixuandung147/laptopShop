$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
	$(document).on('click','.pagination a',function(e){
		e.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
        var query = $('#search').val();
		fetch_data(page,query)
	});
	function fetch_data(page,query){
		$.ajax({
			type:"get",
			url : "category/fetch_data?page="+page+"&query="+query,
			success:function(data)
			{
				$('#table_data').html(data);
			}
		})
	}
     $('#form-search').submit(function(e){
        e.preventDefault();
        var query = $('#search').val();
        var page = $('#hidden_page').val(); //ở list_category ta phải tạo INPUT của page để gọi hàm đệ quỵ nến ko nó sẽ ko hỉu
        fetch_data(page,query);
    })
    $(document).on('click', '.edit-category', function(e){
        e.preventDefault();
        $('.error').hide();
        var url = $(this).attr('data-url');

        e.preventDefault();

        $.ajax({

            type: 'get',
            url: url,
            success: function (response) {
                $('.tittle').text(response.data.name);
                $('#name-edit').val(response.data.name);
                $('#parent-edit').val(response.data.parent_id);
                // CKEDITOR.instances['desription-edit'].setData(response.data.desription);
                $('#desription-edit').val(response.data.desription);
                $('#form-edit').attr('data-url','/admin/category/'+response.data.id)
            },
        })
    })
    $('#form-edit').submit(function(e){

        e.preventDefault();
        var url=$(this).attr('data-url');
        $.ajax({
            type: "PUT",
            url: url,
        data: {
            
            'name': $('#name-edit').val(),  
            'parent_id': $('#parent-edit').val(),
            // 'desription': CKEDITOR.instances['desription-edit'].getData(),
            'desription': $('#desription-edit').val(),
            '_method':'put',

        },
        success: function($resuld) {
            if($resuld.error == 'true'){
                
                if ($resuld.mess.name) {
                    $('.error').show();
                    $('.error').text($resuld.mess.name[0]);
                }else{$('.error').hide()};
               

            }else{
                // $('#edit').hide();
                var parent = '';
                $.each($resuld.children,function($key,$value){
                    if ($value['id'] == $resuld.data.parent_id) {
                        parent = $value['name'];
                    }
                });
                var desription = '';
                if ($resuld.data.desription != null) {
                    desription = $resuld.data.desription;
                } 
                toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
                $('#name_'+$resuld.data.id).text($resuld.data.name);
                $('#parent_id_'+$resuld.data.id).text(parent);
                $('#desription_'+$resuld.data.id).text(desription);

            }

        },
        })
    })
    $(document).on('click', '.btn-delete', function(e){

        var url = $(this).attr('data-url');
        var _this = $(this);
        $('.del').click(function(){
            $.ajax({
                type: 'delete',
                url: url,
                success: function($resuld) {
                    console.log($resuld.errors);
                    if ($resuld.errors == 'true') {
                        toastr.error($resuld.error, 'Thông Báo Lỗi', {timeOut: 7000});
                        location.reload();
                    } else {
                        toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
                        _this.parent().parent().remove();
                    }
                    
                    
                },

            })
        })
    })










});