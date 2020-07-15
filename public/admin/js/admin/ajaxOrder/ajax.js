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
			url : "order/fetch_data?page="+page+"&query="+query+"&sort="+sort,
			success:function(data)
			{
				$('#table_data').html(data);
                if (sort == 1 ) {
                    $('#hidden_quantity_type').attr('value','1');
                } else if (sort == 2 ) 
                {
                    $('#hidden_quantity_type').attr('value','2');
                }
                else if (sort == 3 ) 
                {
                    $('#hidden_quantity_type').attr('value','3');
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
    $(document).on('click', '.cho', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#cho').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.dang', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val(); 
        var sort = $('#dang').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.hoan', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#hoan').val();
        fetch_data(page,query,sort);
    })

    $(document).on('click', '.edit-order', function(e){
        var url = $(this).attr('data-url');
        e.preventDefault();
        $.ajax({
                type: 'get',
                url: url,
                success: function (response) {
                    $('.tittle').text(response.data.email);
                    $('#email-edit').val(response.data.email);
                    if(response.data.deliver_status == 0){
                        $('#option0').attr('selected','selected');
                    }else if(response.data.deliver_status == 1){
                        $('#option1').attr('selected','selected');
                    }
                    else{
                        $('#option2').attr('selected','selected');
                    }
                     $('#form-edit').attr('data-url','/admin/order/'+response.data.id)

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
            'deliver_status': $('#deliver_status-edit').val(),
            '_method':'put',

        },                       
        success: function($resuld) {
            toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
            if ($resuld.data.deliver_status == 0) {
                var status = 'Chờ xử lý';
            } else if ($resuld.data.deliver_status == 1) {
                var status = 'Đang giao hàng';
            } else {
                var status = 'Hoàn thành';
            }
            if ($resuld.data.delivery_date == null) {
                var date = '';
            } else {
                var date = $resuld.data.delivery_date;
            }
            $('.status_'+$resuld.data.id).text(status);
            $('#date_'+$resuld.data.id).text(date);

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