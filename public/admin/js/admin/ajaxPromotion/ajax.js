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
			url : "promotion/fetch_data?page="+page+"&query="+query+"&sort="+sort,
			success:function(data)
			{
				$('#table_data').html(data);
                if (sort == 1 ) {
                    $('#hidden_quantity_type').attr('value','1');
                } else if (sort == 2 ) 
                {
                    $('#hidden_quantity_type').attr('value','2');
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
    $(document).on('click', '.khuyen', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#khuyen').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.het', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val(); 
        var sort = $('#het').val();
        fetch_data(page,query,sort);
    })


    $(document).on('click', '.edit-promotion', function(e){
        $('.error1').hide();
        $('.error34').hide();
        var url = $(this).attr('data-url');
        e.preventDefault();

        $.ajax({
                type: 'get',
                url: url,
                success: function (response) {  
                    $('#price-edit').val(response.data.price);
                    $('#start_date-edit').val(response.data.start_date);
                    $('#end_date-edit').val(response.data.end_date);

                    var html1 ='';
                    $.each(response.products,function($key,$value){
                        if ($value['id']==response.data.product_id) {
                            html1 +='<option value='+$value['id']+' selected>';
                                html1 += $value['name'];
                            html1 += '</option>';
                        }else{
                            html1 +='<option value='+$value['id']+' >';
                                html1 += $value['name'];
                            html1 += '</option>';
                        }
                    });
                        $('.idProduct').html(html1);                      
                    $('#form-edit').attr('data-url','/admin/promotion/'+response.data.id)
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
            'product_id': $('.idProduct').val(),
            'price': $('#price-edit').val(),
            'start_date': $('#start_date-edit').val(),
            'end_date': $('#end_date-edit').val(),

            '_method':'put',
         },
        success: function($resuld) {
            $('.error34').hide();
            if($resuld.error == 'true'){
                $('.error34').hide();
                if ($resuld.mess.price) {
                    $('.error1').show();
                    $('.error1').text($resuld.mess.price);
                } else {
                      $('.error1').hide(); 
                      $('.error34').hide();                                   
                }

            }else if ($resuld.errorsss == 'true') {
                     $('.error1').show();
                    $('.error1').text($resuld.thongbaoo);
            }
            else if ($resuld.errorss == 'true') {
                    $('.error34').show();
                     $('.error34').text($resuld.thongbao);
                     $('.error1').hide();
            } else {
            toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
            $('.error34').hide();
            if ($resuld.data.status == 0) {
              var status = 'Hết khuyến mãi';
            } else {
              var status = 'Khuyến mãi';
            }
            var product ='';
            $.each($resuld.products,function($key,$value){
              if ($value['id'] == $resuld.data.product_id ) {
                product = $value['name'];
              }
            });
            console.log(product);
            $('#name_'+$resuld.data.id).text(product);
            $('#price_'+$resuld.data.id).text($resuld.data.price);
            $('#start_date_'+$resuld.data.id).text($resuld.data.start_date);
            $('#end_date_'+$resuld.data.id).text($resuld.data.end_date);
            $('#status_'+$resuld.data.id).text(status);
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
                    toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
                    _this.parent().parent().remove();

                },

            })
        })
    })




});