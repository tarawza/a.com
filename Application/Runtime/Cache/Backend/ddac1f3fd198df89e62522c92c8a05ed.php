<?php if (!defined('THINK_PATH')) exit();?><meta charset="utf-8">
<div>
	<div>
		<div class="check-box">
		<input type="checkbox" id="checkboxAll" class="checkboxAll">
		<label for="checkboxAll">全选</label>
	</div>
	</div>
	<ul class="domtree">
	<?php
 foreach($menus as $v){ ?>
  	<li>
  		<div class="check-box">
			<input type="checkbox" id="<?=$v['id']?>" class="js-checkbox box-1" data-id="<?=$v['id']?>" data-s='box-1' <?=$v['is_check']?'checked':''?> >
			<label for="<?=$v['id']?>"><?=$v['title']?></label>
		</div>
  		<ul>
	  		<?php
 foreach($v['_child'] as $val){ ?>
  			<li>
  				<div class="check-box">
				  <input type="checkbox" id="<?=$val['id']?>" class="js-checkbox box-2" data-id="<?=$val['id']?>" data-s='box-2' <?=$val['is_check']?'checked':''?> >
				  <label for="<?=$val['id']?>"><?=$val['title']?></label>
				</div>
				<ul>
					<?php
 foreach($val['_child'] as $value){ ?>
					<li class="checkbox_li">
						<div class="check-box">
						  <input type="checkbox" id="<?=$value['id']?>" class="js-checkbox box-3" data-id="<?=$value['id']?>" data-s='box-3' <?=$value['is_check']?'checked':''?> >
						  <label for="<?=$value['id']?>"><?=$value['title']?></label>
						</div>
					</li>
					<?php
 } ?>
					<li style="">
						<div class="check-box">
						  <label></label>
						</div>
					</li>
				</ul>
  			</li>
  			<?php
 } ?>
  		</ul>
  	</li>
  	<?php
 } ?>
  </ul>
</div>
<hr/>
<div style="padding:2em;">
	<div class="col-xs-6 col-sm-offset-2">
		<button class="btn btn-primary radius js-check-submit" type="button" data-url="<?=U()?>" data-id="<?=$info['id']?>">确定</button>&nbsp;
		<button class="btn radius js-modal-close" type="button">取消</button>
	</div>
</div>
<div style="height:2em;">

</div>