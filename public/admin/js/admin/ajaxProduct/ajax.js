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
        var sort = $('#hidden_quantity_type').val();        
		fetch_data(page,query,sort)
	});
	function fetch_data(page,query,sort){
		$.ajax({
			type:"get",
			url : "product/fetch_data?page="+page+"&query="+query+"&sort="+sort,
			success:function(data)
			{
				$('#table_data').html(data);
                if (sort == 1 ) {
                    $('#hidden_quantity_type').attr('value','1');
                } else if (sort == 2 ) 
                {
                    $('#hidden_quantity_type').attr('value','2');
                } else if (sort == 3 ) {
                    $('#hidden_quantity_type').attr('value','3');
                }else if (sort == 4 ) {
                    $('#hidden_quantity_type').attr('value','4');
                }
			}
		})
	}
	$('#form-search').submit(function(e){
        e.preventDefault();
        var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#hidden_quantity_type').attr('value',''); 
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.quantity', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#remaining').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.quantity_out', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val(); 
        var sort = $('#out').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.love', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#love').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.notLove', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#notLove').val();
        fetch_data(page,query,sort);
    })

    $(document).on('click', '.edit-product', function(e){
        e.preventDefault();
        $('.error1').hide();
        $('.error2').hide();
        $('.error3').hide();
        var url = $(this).attr('data-url');

        e.preventDefault();

        $.ajax({

            type: 'get',
            url: url,
            success: function (response) {  
                    $('.tittle').text(response.data.name);
                    $('#name-edit').val(response.data.name);
                    $('#quantity-edit').val(response.data.quantity);
                    $('#price-edit').val(response.data.price);
                    var html ='';
                    $.each(response.suppliers,function($key,$value){
                        if ($value['id']==response.data.supplier_id) {
                            html +='<option value='+$value['id']+' selected>';
                                html += $value['name'];
                            html += '</option>';
                        }else{
                            html +='<option value='+$value['id']+' >';
                                html += $value['name'];
                            html += '</option>';
                        }
                    });
                    $('.idSupplier').html(html);
                    var html1 ='';
                    $.each(response.categories,function($key,$value){
                        if ($value['id']==response.data.category_id) {
                            html1 +='<option value='+$value['id']+' selected>';
                                html1 += $value['name'];
                            html1 += '</option>';
                        }else{
                            html1 +='<option value='+$value['id']+' >';
                                html1 += $value['name'];
                            html1 += '</option>';
                        }
                    });
                    $('.idCategory').html(html1);
                    $('#ram-edit').val(response.data.RAM);
                    $('#vga-edit').val(response.data.VGA);
                    $('#operating_system-edit').val(response.data.operating_system);
                    $('#cpu-edit').val(response.data.CPU);
                    $('#guarantee-edit').val(response.data.guarantee);
                    // CKEDITOR.instances['description-edit'].setData(response.data.description);
                    $('#description-edit').val(response.data.description);
                    $('#sales_volume-edit').val(response.data.sales_volume);
                    var html2 ='';
                    $.each(response.product_image,function($key,$value){
                        html2 +='<img src=/uploads/'+$value['path']+' style="margin-right: 16px;width:100px; "/>';
                        
                    });
                    $('.idImage').html(html2);   
                    $('#form-edit').attr('data-url','/admin/product/'+response.data.id);
                },
                error: function (error) {
                    
                }
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
            'quantity': $('#quantity-edit').val(),
            'price': $('#price-edit').val(),
            'supplier_id': $('.idSupplier').val(),
            'category_id': $('.idCategory').val(),
            'RAM': $('#ram-edit').val(),
            'VGA': $('#vga-edit').val(),
            'operating_system': $('#operating_system-edit').val(),
            'CPU': $('#cpu-edit').val(),
            'guarantee': $('#guarantee-edit').val(),
            // 'description': CKEDITOR.instances['description-edit'].getData(),
            'description' : $('#description-edit').val(),
            'sales_volume': $('#sales_volume-edit').val(),
            '_method':'put',
        },
        success: function($resuld) {
             if($resuld.error == 'true'){
                if ($resuld.mess.name) {
                    $('.error1').show();
                    $('.error1').text($resuld.mess.name[0]);
                } else {
                      $('.error1').hide();                                    
                }
                if ($resuld.mess.quantity) {
                     $('.error2').show();
                     $('.error2').text($resuld.mess.quantity);
                 } else {
                    $('.error2').hide();
                }
                if ($resuld.mess.price) {
                    $('.error3').show();
                    $('.error3').text($resuld.mess.price);
                } else {
                    $('.error3').hide();
                 }
            }else{
            	var cate = '';
            	$.each($resuld.categories,function($key,$value){
            		if ($resuld.data.category_id == $value['id']) 
            		{
            			cate = $value['name'];
            		}
            	});
            	var no = '';
            	if ($resuld.data.note == null || $resuld.data.note == 0) 
            	{
            		no ='<button data-url="http://127.0.0.1/admin/product/like/'+$resuld.data.id+'" class="notlike"><i class="fa fa-star-o" aria-hidden="true"></i></button>';
            	} 
            	else {
            		no ='<button data-url="http://127.0.0.1/admin/product/like/'+$resuld.data.id+'" class="like"><i class="fa fa-star" aria-hidden="true"></i></button>';
            	}
	            toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
	            $('#name_'+$resuld.data.id).text($resuld.data.name);
	            $('#category_id_'+$resuld.data.id).text(cate);
	            $('#quantity_'+$resuld.data.id).text($resuld.data.quantity);
                $('#price_'+$resuld.data.id).text($resuld.data.price);
                $('#RAM_'+$resuld.data.id).text($resuld.data.RAM);
                $('#VGA_'+$resuld.data.id).text($resuld.data.VGA);
                $('#operating_system_'+$resuld.data.id).text($resuld.data.operating_system);
                $('#CPU_'+$resuld.data.id).text($resuld.data.CPU);
                $('#description_'+$resuld.data.id).text($resuld.data.description);
                $('#sales_volume_'+$resuld.data.id).text($resuld.data.sales_volume);
	            $('#note_'+$resuld.data.id).html(no);
	            // location.reload();
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
                    // $('#delete').hide();
                    toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
                    _this.parent().parent().remove();

                },

            })
        })
    })
    $(document).on('click', '.notlike', function(e){
            var url = $(this).attr('data-url');
            e.preventDefault();
            $.ajax({
                type: 'get',
                url: url,
                success: function ($resuld) {
                	var no = '';
	            	if ($resuld.data.note == null || $resuld.data.note == 0) 
	            	{
	            		no ='<button data-url="http://127.0.0.1/admin/product/like/'+$resuld.data.id+'" class="notlike"><i class="fa fa-star-o" aria-hidden="true"></i></button>';
	            	} 
	            	else {
	            		no ='<button data-url="http://127.0.0.1/admin/product/like/'+$resuld.data.id+'" class="like"><i class="fa fa-star" aria-hidden="true"></i></button>';
	            	}
                	$('#note_'+$resuld.data.id).html(no);
             }
            })
        })
    $(document).on('click', '.like', function(e){
        var url = $(this).attr('data-url');
        e.preventDefault();
        $.ajax({
            type: 'get',
            url: url,
            success: function ($resuld) {
                var no = '';
            	if ($resuld.data.note == null || $resuld.data.note == 0) 
            	{
            		no ='<button data-url="http://127.0.0.1/admin/product/like/'+$resuld.data.id+'" class="notlike"><i class="fa fa-star-o" aria-hidden="true"></i></button>';
            	} 
            	else {
            		no ='<button data-url="http://127.0.0.1/admin/product/like/'+$resuld.data.id+'" class="like"><i class="fa fa-star" aria-hidden="true"></i></button>';
            		}
            	$('#note_'+$resuld.data.id).html(no);
				}
        })
    })





    
    // PRODUCT IMAGES


    $(document).on('click', '.btn-del-image', function(e){

        var url = $(this).attr('data-url');
        var _this = $(this);
        $('.del').click(function(){
            $.ajax({
                type: 'delete',
                url: url,
                success: function($resuld) {
                    toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
                    _this.parent().remove();

                },

            })
        })
    })








});