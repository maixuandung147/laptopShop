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
			url : "suggest/fetch_data?page="+page+"&query="+query+"&sort="+sort,
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
    $(document).on('click', '.xem', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#xem').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.chuaX', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val(); 
        var sort = $('#chuaX').val();
        fetch_data(page,query,sort);
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
    $(document).on('click', '.btn-show', function(e){

        var url = $(this).attr('data-url');
        var _this = $(this);
            $.ajax({
                type: 'get',
                url: url,
                success: function($resuld) {
                    var html ='';
                    html = '<tr><td >'+$resuld.data.id+'</td><td>'+$resuld.data.username+'</td><td>'+$resuld.data.email+'</td><td>'+$resuld.data.telephone+'</td><td>'+$resuld.data.name_product+'</td><td>'+$resuld.data.quantity+'</td><td>'+$resuld.data.content+'</td></tr>';

                    $('#table_detailr').html(html);
                    if ($resuld.data.status = 1) {
                        var status = 'Đã xem';
                    }
                    $('.status_'+$resuld.data.id).text(status);
                },

            })
    })











});