<?php
namespace Common\Model;
use Think\Model\ViewModel;
class MemberViewModel extends ViewModel {
	public $viewFields = array(
			'member'=>array('*','_type'=>'LEFT'),
			'groups'=>array('title'=>'groups_title','menus'=>'groups_menus', '_on'=>'member.groups_id=groups.id','_type'=>'LEFT'),
	);
}