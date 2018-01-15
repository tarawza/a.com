<?php
/*
 * 写入/更新
 * $table  	表名
 * $data 	需处理的数据（数组）
 */
function update_data($table,$data,$debug=false){
	//检查参数
	$user = M($table);
	if(!$user->create($data)){
		return false;
	}
	if(!is_array($data)){
		return false;
	}
	//更新/写入数据
	if($data['id']){
		//更新
		$id = $data['id'];
		unset($data['id']);
		$data['update_time'] = getD();
		$data['update_member_id'] = $GLOBALS['user']['id'];
		//调试
		if($debug){
			//$sql = $user->fetchSql(true)->where('id='.$data_id)->save($data);
			//return $sql;
		}
		$user->where('id='.$id)->save($data);
	}else{
		//写入
		$data['add_time'] = getD();
		$data['add_member_id'] = $GLOBALS['user']['id'];
		//调试
		if($debug){
			//$sql = $user->fetchSql(true)->add($data);
			//return $sql;
		}
		$id = $user->add($data);
	}
	return $id;
}
/*
 * 批量写入
 */
function addAll(){
	
}

/*
 * 批量更新
 * $table 	表名
 * $ids 	需改变的id
 * $field 	需改变的字段
 */
function saveData($table,$ids,$field){
	$user = M($table);
	if(!$user->create($field)){
		return false;
	}
	$field['update_time'] = getD();
	$field['update_member_id'] = $GLOBALS['user']['id'];
	$w['id']=array('in',$ids);
	$user->where($w)->setField($field);
	return true;
}

/*
 * 获取数据(单条) 后续需要修改！
 * $table 		表名
 * $where 		用于查询或者更新条件的定义
 * $field 		用于定义要查询的字段（支持字段排除）
 * $orders  	用于对结果排序
 * $limit 		查询的条数
 * $group 		用于对查询的group支持	
 */
function get_info($table,$where,$field=null,$orders=null,$limit=null,$group=null){
	//检查参数
	if(is_object($table)){
		$user = $table; //视图模型
	}else{
		$user = M($table);
	}
	if(!is_array($where)){
		return false;
	}
	$data = $user->where($where)->field($field)->order($orders)->limit($limit)->group($group)->find();
	return $data;
}
/*
 * 获取数据(多条)
 * $table 		表名
 * $where 		用于查询或者更新条件的定义
 * $field 		用于定义要查询的字段（支持字段排除）
 * $orders  	用于对结果排序
 * $limit 		查询的条数
 * $group 		用于对查询的group支持
 */
function get_result($table,$where,$field=null,$orders=null,$limit=null,$group=null){
	//检查参数
	if(is_object($table)){
		$user = $table; //视图模型
	}else{
		$user = M($table);
	}
	if(!is_array($where)){
		return false;
	}
	$data = $user->where($where)->field($field)->order($orders)->limit($limit)->group($group)->select();
	return $data;
}



/*
 * 按钮
 * $location 	按钮位置
 * $id 			按钮对应数据的id
 * $btnstatus 	按钮对应数据的status
 * $title 		按钮对应数据的标题
 * 1.获取所有菜单数据$menu
 * 2.根据CONTROLLER_NAME和$menu获取当前页面的按钮
 * 3.根据位置生成相应的按钮
 */
function getBtn($location,$title=null,$id=null,$btnstatus=null){
	//1.获取所有菜单数据$menu（没有分权限）
	$menu = session('menu');
	//2.根据CONTROLLER_NAME和$menu获取当前页面的按钮
	$str = CONTROLLER_NAME;
	foreach ($menu as $v){
		if($v['level']==3 && strpos($v['url'], $str) && $location == $v['location']){
			$btn[] = $v;
		}
	}
 	//var_dump($btn);
	switch ($location){
		case 1:
			$text = '';
			foreach ($btn as $v){
				if($v['btnstatus']===null || $v['btnstatus'] === $btnstatus){
					$text .= '&nbsp;<a href="javascript:;" class="'.$v['classes'].' '.getBtnType($v['type']).'" data-url="'.U($v['url']).'" data-title=" '.$v['title'].' ">'.$v['title'].'</a>&nbsp;';
				}
			}
			break;
		case 2:
			$text = '';
			foreach ($btn as $v){
				if($v['btnstatus']===null || $v['btnstatus'] === $btnstatus){
					$text .= '&nbsp;<a href="javascript:;" class="'.getBtnType($v['type']).'" data-url="'.U($v['url']).'" data-title=" '.$v['title'].' " data-id="'.$id.'">'.$v['title'].'</a>&nbsp;';
				}
			}
			break;
		case 3:
			foreach ($btn as $v){
				if($v['btnstatus']===null || $v['btnstatus'] === $btnstatus){
					$text = '<a href="javascript:;" class="'.getBtnType($v['type']).'" data-url="'.U($v['url']).'" data-title="'.$title.'" data-id="'.$id.'">'.$title.'</a>';
				}
			}
			break;	
		default:
			break;	
	}
	return $text;
}
/*
 * 获取status
 */
function getAllType($title,$status){
	$a = C('status_type');
	if(!$a[$title][$status]){
		return false;
	}
	return $a[$title][$status];
}

/*
 * 获取按钮的类型
 */
function getBtnType($type){
	if(!$type){
		return false;
	}
	switch ($type){
		case 1:
			$res = 'ajax-info';
		break;
		case 2:
			$res = 'ajax-get';
		break;
		case 4:
			$res = 'ajax-check';
		break;
		default:
			return;
	}
	return $res;
}

function getD(){
	return date('Y-m-d H:i:s',time());
}


