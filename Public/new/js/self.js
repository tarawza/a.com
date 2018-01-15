$(function(){
	/*弹出模态框*/
	$('.ajax-info').on('click',function(){
		var loading = layer.load();
		var url = $(this).data('url');
		var title = $(this).data('title');
		var id = $(this).data('id');
		if(id){
			var b='/id/'+id+'.html';
			url=url.replace(/.html/, b);
		}
		$.get(url,function(data){
			layer.close(loading);
			if(data['status']==false){
				layer.msg(data['info'],{time:3000});
			}else{
				var index =layer.open({
	                type: 1,
	                title: title,
	                shadeClose: false,
	                shade: 0.3,
	                maxmin: true, //开启最大化最小化按钮
	                area: ['60%',''],
	                zIndex :100000,
	                content: data,
	            });
			}
			return false;
		});
	});
	/*模态框提交*/
	$('body').on('click', '.js-modal-submit', function(){
		var loading = layer.load();
		var id = $(this).data('form_id')?$(this).data('form_id'):'modal_from';
		var url = $('#'+id).attr('action');
		var data=$('#'+id).serialize();
		$.post(url, data,function(data) {
			layer.close(loading);
			if(data['status']==false){
				layer.msg(data['info'],{time:3000});
				return;
			}else{
				layer.msg(data['info'],{
					time:400
				},function(){
					if(data['url']){
						location.href=data['url'];
					}
				});
			}
		});
	});
	/*模态框取消*/
	$('body').on('click', '.js-modal-close', function(){
		var url=$(this).data('url');
		if(url){
			location.href=url;
		}else{
			layer.closeAll();
		}
	});
	/*提示提交*/
	$('.ajax-get').on('click',function(){
		var loading = layer.load();
		var id=$(this).data('id');
		var url=$(this).data('url');
		layer.confirm('确认此操作？', {
		    btn: ['确定','取消'], //按钮
			btn2:function(index,layero){
				layer.close(loading);
	    }
		}, function(){
			$.post(url,{id:id},function(data){
				layer.close(loading);
				if(data['status']==false){
					layer.msg(data['info'],{time:2000});
				}else{
					layer.msg(data['info'],{time:400},
					function(){
						if(data['url']){
							location.href=data['url'];
						}
					});
				}
			});
		});
	});
	
	/*批量提示提交*/
	$('.ajax-check').on('click',function(){
		var loading = layer.load();
		var url = $(this).data('url');
		var a = $('.table').find('input.checkbox');
		var ids = '';
		a.each(function(){
			if($(this).is(':checked')){
				ids += $(this).data('id')+',';
			}
		});
		if(!ids){
			layer.close(loading);
			layer.msg('请勾选',{time:1500});
			return;
		}
		ids=ids.substring(0,ids.length-1);
		layer.confirm('确认此操作？', {
		    btn: ['确定','取消'], //按钮
			btn2:function(index,layero){
				layer.close(loading);
	    }
		}, function(){
			$.post(url,{ids:ids},function(data){
				layer.close(loading);
				if(data['status']==false){
					layer.msg(data['info'],{time:2000});
				}else{
					layer.msg(data['info'],{time:400},
					function(){
						if(data['url']){
							location.href=data['url'];
						}
					});
				}
			});
		});
	});
	
	//页面刷新
	$('.refresh').click(function(){
		var url = $(this).data('url');
		location.href=url;
	})
	
	
	//权限-------------------------
	$('body').on('click', '.js-check-submit', function(){
		var loading = layer.load();
		var url = $(this).data('url');
		var id = $(this).data('id');
		var a = $('.domtree').find('input.js-checkbox'); //获取所有的check对象
		var ids = '';
		a.each(function(){
			if($(this).is(':checked')){
				ids += $(this).data('id')+',';
			}
		})
		ids=ids.substring(0,ids.length-1);
		$.post(url,{id:id,ids:ids},function(data) {
			if(data['status']==false){
				layer.close(loading);
				layer.msg(data['info'],{time:3000});
				return;
			}else{
				layer.msg(data['info'],{
					time:400
				},function(){
					if(data['url']){
						location.href=data['url'];
					}
				});
			}
		});
	})
	/*全选*/
	$('body').on('click', '.checkboxAll', function(){
		if($(this).is(':checked')){
	    	$('.domtree').find('input').prop('checked',true);
	    	
	    }else{
	    	$('.domtree').find('input').prop('checked',false);
	    }
	})
	/*点击input*/
	$('body').on('click', '.js-checkbox', function(){
		var a = $(this);
		if(a.is(':checked')){
			getAllChecked(a);
		}else{
			getSonUnChecked(a);
			getTongUnChecked(a);
			$('.checkboxAll').prop('checked',false);
		}
	})
	/*父级和所有子级都check*/
	function getAllChecked(obj){
		obj.parents('ul').prev().children('input').prop('checked',true);
		var a = obj.parent().next().find('input');
		if(a.length>0){
			a.prop('checked',true);
		}
	}
	/*所有的子级都取消check*/
	function getSonUnChecked(obj){
		obj.parent().next().find('input').prop('checked',false);
	}
	/*如果同级都没有check，上级就取消check*/
	function getTongUnChecked(obj){
		var sign = 1;
		var a = obj.closest('ul'); 	//点击对象最近的ul对象
		var b = obj.data('s'); 		//点击对象data的值
		a.find('input.'+b).each(function(){
			if($(this).is(':checked')){
				sign = 0;
			}
		});
		if(sign){
			var c = a.prev().children('input.js-checkbox'); 
			c.prop('checked',false);
			/*到最外层跳出循环*/
			if(c.length==1){
				getTongUnChecked(c);	
			}
		}
	}
	//权限-------------------------
});