<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Public/new/css/icheck.css" />
<!-- <link rel="stylesheet" type="text/css" href="/Public/new/css/page.css" />THINKPHP分页 -->
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/lib/jquery/3.2.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="/Public/new/js/self.js"></script> 
<!--/_footer 作为公共模版分离出去-->
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span><?=$top['ptitle']?><span class="c-gray en">&gt;</span><?=$top['title']?><a class="btn btn-success radius r refresh" style="line-height:1.6em;margin-top:3px" href="javascript:;" title="刷新" data-url="<?=U()?>"><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
	<div class="text-c">
	<form id="search" action="<?=U()?>" class="form form-horizontal" id="form-member-add" method="get">
	 	日期范围：
		<input type="text" id="logmin" name='add_time_1' onfocus="WdatePicker()" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" id="logmax" name='add_time_2' onfocus="WdatePicker()" class="input-text Wdate" style="width:120px;">
		<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i>搜索</button>
	</form>
</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> 
	<span class="r">
	<?=getBtn(1)?>
	</span>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th><input type="checkbox" name="" value=""></th>
				<th>ID</th>
				<th>用户名</th>
				<th>性别</th>
				<th>所在用户组</th>
				<th>手机</th>
				<th>邮箱</th>
				<th>地址</th>
				<th>加入时间</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
 foreach($_list as $v){ ?>
			<tr class="text-c">
				<td><input type="checkbox" data-id="<?=$v['id']?>" class="checkbox"></td>
				<td><?=$v['id']?></td>
				<td><?=$v['username']?></td>
				<td><?=$v['sex']?></td>
				<td><?=$v['groups_title']?></td>
				<td><?=$v['tel']?></td>
				<td><?=$v['email']?></td>
				<td><?=$v['address']?></td>
				<td><?=$v['add_time']?></td>
				<td><?=getAllType('test',$v['status'])?></td>
				<td>
					<?=getBtn(2,null,$v['id'],$v['status'])?>
				</td>
			</tr>
			<?php
 } ?>
		</tbody>
	</table>
	</div>
</div>
<script type="text/javascript" src="/Public/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/Public/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/lib/laypage/1.2/laypage.js"></script>  
<script type="text/javascript">
$('.table-sort').dataTable({
	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"pading":false,
	"aoColumnDefs": [
	  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
	  {"orderable":false,"aTargets":[0]}// 不参与排序的列
	]
});
</script>

</body>
</html>