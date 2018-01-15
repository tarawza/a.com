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
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th>标题</th>
				<th>值</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
 foreach($_list as $v){ ?>
			<tr class="text-c">
				<td><?=$v['title']?></td>
				<td><?=$v['value']?></td>
				<td><?=getBtn(2,null,$v['id'],$v['status'])?></td>
			</tr>
			<?php
 } ?>
		</tbody>
	</table>
	</div>
</div>

</body>
</html>