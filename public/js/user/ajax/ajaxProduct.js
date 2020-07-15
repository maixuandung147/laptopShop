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
		var url = $(this).attr('href');

		if (url == 'http://127.0.0.1/product?page='+page || url == 'http://127.0.0.1/product/fetch_data?page='+page) {
					url = "http://127.0.0.1/product";
		}
		else{
			url = url.split("?");
			url = url[0];
			url = url.replace('/fetch_data','');
		}
		
		fetch_data(page,query,url)

	});
	function fetch_data(page,query,url){
		$.ajax({
			type:"get",
			url : url+"/fetch_data?page="+page+"&query="+query,

			success:function(data)
			{
				$('#table_data').html(data);
			}
		})
	}
	$('#form-search').submit(function(e){
        e.preventDefault();
        var query = $('#search').val();
        var page = $('#hidden_page').val(); 
        var url = "http://127.0.0.1/product/fetch_data?page=";
        fetch_data(page,query,url);
    })


})