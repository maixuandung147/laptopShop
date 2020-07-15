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
			url : "user/fetch_data?page="+page+"&query="+query+"&sort="+sort,
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
    $(document).on('click', '.admin', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val();
        var sort = $('#admin').val();
        fetch_data(page,query,sort);
    })
    $(document).on('click', '.user', function(e){
    	var query = $('#search').val();
        var page = $('#hidden_page').val(); 
        var sort = $('#user').val();
        fetch_data(page,query,sort);
    })


    $(document).on('click', '.edit-user', function(e){
        var url = $(this).attr('data-url');
        e.preventDefault();
        $.ajax({
            type: 'get',
            url: url,
            success: function (response) {
                $('.tittle').text(response.data.fullname);
                $('#fullname-edit').val(response.data.fullname);
                $('#email-edit').val(response.data.email);
                if(response.data.level == 1){
                    $('#gridRadios1').attr('checked','checked');
                }else{
                    $('#gridRadios2').attr('checked','checked');
                }
                $('#form-edit').attr('data-url','/admin/user/'+response.data.id)

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
            'fullname': $('#fullname-edit').val(),
            'email': $('#email-edit').val(),
            'level': ($(".leveledit").prop("checked") ? 1 : 0),
            '_method':'put',

        }, 
        success: function($resuld) {
            toastr.success($resuld.success,'Thông báo',{timeOut: 5000});
            if ($resuld.data.level == 1) 
                {
                    var level = 'Admin';
                } 
            else 
                {
                    var level = 'User';
                }
            $('.level_'+$resuld.data.id).text(level);

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
    $(document).on('click', '.btn-show', function(e){

        var url = $(this).attr('data-url');
        var _this = $(this);
            $.ajax({
                type: 'get',
                url: url,
                success: function($resuld) {
                    if ($resuld.data.level == 1) {
                        var level = 'Admin';
                    } else {
                        var level = 'User';
                    }
                    if ($resuld.data.sex == 0) {
                        var sex = 'Man';
                    } else {
                        var sex = 'Female';
                    }
                    var html ='';
                    html = '<tr><td >'+$resuld.data.id+'</td><td>'+$resuld.data.username+'</td><td>'+$resuld.data.fullname+'</td><td>'+$resuld.data.email+'</td><td class="level_'+$resuld.data.id+'">'+level+'</td><td>'+$resuld.data.telephone+'</td><td>'+sex+'</td><td><img src="/avatar/'+$resuld.data.image+'" alt="" width="130%"></img></td><td><button data-url="http://127.0.0.1/admin/user/'+$resuld.data.id+'/edit"class="btn btn-primary edit-user" data-toggle="modal" data-target="#edit" type="button"><i class="fa fa-pencil fa-fw" ></i> </button></td></tr>';

                    $('#table_detailr').html(html);
                },

            })
    })











});