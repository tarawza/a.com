$(function(){
	$('#submit').click(function(){
		var loading = layer.load();
		var url = $(this).data('url');
		var data = $(this).parent().parent().parent().serialize();
		$.post(url,data,function(data){
			layer.close(loading);
			if(data['status']==0){
				layer.msg(data['info'],{time:1000});
				change($('#verify_change'));
			}else{
				layer.msg(data['info'],{time:1000},function(){
					location.href = data['url'];
				});
				
			}
		});
	})
	
	$('#verify_change').click(function(){
		change($(this));
	})
	
	/*刷新验证码*/
	function change(e){
		var src = e.prev().attr('src');
		src = src+'?'+Math.random();
		e.prev().attr('src',src);
	}
});