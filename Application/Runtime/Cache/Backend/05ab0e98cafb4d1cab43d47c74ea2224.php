<?php if (!defined('THINK_PATH')) exit();?><meta charset="utf-8">
<article class="page-container">
	<form id="modal_from" action="<?=U()?>" class="form form-horizontal" id="form-member-add">
		<input type="hidden" name="id" value="<?=$info['id']?>"/>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<?=$info['username']?>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所在组名：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" name="groups_id">
					<option value="0">请选择用户组</option>
					<?php
 foreach($groups as $v){ ?>
					<option value="<?=$v['id']?>" <?=$info['groups_id']==$v['id']?'selected':'' ?> ><?=$v['title']?></option>
					<?php
 } ?>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button class="btn btn-primary radius js-modal-submit" type="button">确定</button>
				<button class="btn radius js-modal-close" type="button">取消</button>
			</div>
		</div>
	</form>
</article>