<?php if (!defined('THINK_PATH')) exit();?><meta charset="utf-8">
<article class="page-container">
	<form id="modal_from" action="<?=U()?>" class="form form-horizontal" id="form-member-add">
		<input type="hidden" name="id" value="<?=$info['id']?>">
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<?=$info['title']?>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">值：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" name="value" value="<?=$info['value']?>">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button class="btn btn-primary radius js-modal-submit" type="button">确定</button>
				<button class="btn radius js-modal-close" type="button">取消</button>
			</div>
		</div>
	</form>
</article>