<?php
/*
 * 后台入口类
 */
namespace Backend\Controller\Base;
use Think\Controller;
class AdminController extends Controller {
	protected $user;
	protected $str_error;
	protected $memcache_host = 'localhost';
	protected $memcache_ip = 11211;
	
	//构造函数
	public function __construct(){
		parent::__construct();
		if(!$this->is_login()){
			$this->error('非法访问!');
		}
		if(!$this->checkMenu()){
			$this->error('未授权访问');
		}
		$GLOBALS['user'] = $this->getUser();
	}
	
	/*
	 * 是否登录
	 */
	public function is_login(){
		if($_SESSION['user']['login']!=1){
			return false;
		}
		return true;
	}
	/*
	 * 分页
	 */
	public function getPage($table,$where,$field=null,$orders=null,$group=null){
		//检查参数
		if(is_object($table)){
			$user = $table; //视图模型
		}else{
			$user = M($table);
		}
		if(!is_array($where)){
			return false;
		}
		$count = $user->where($where)->count();// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show  = $Page->show();// 分页显示输出
		$list = $user->where($where)->field($field)->order($orders)->limit($Page->firstRow.','.$Page->listRows)->group($group)->select();
		$data['_list'] = $list;
		$data['page'] = $show;
		return $data;
	}
	/*
	 * 搜索
	 */
	protected function getSearch($map){
		//搜索日期
		if(I('add_time_1') && I('add_time_2')){
			$add_time_1 = I('add_time_1').' 00:00:00';$add_time_2 = I('add_time_2').' 00:00:00';
			$time = $add_time_1.','.$add_time_2;
			$map['add_time'] = array('between',$time);
		}
		
		return $map;
	}
	
	
	
	/*
	 * 检查权限
	 */
	protected function checkMenu(){
		$menus = session('menu'); 					//获取权限菜单
		$str = CONTROLLER_NAME.'/'.ACTION_NAME;		//当前菜单
		$sign = 0;
		foreach ($menus as $v){
			if(strpos($v['url'], $str)){
				$a = $v; //标记当前权限数据
				$sign = 1;
				break;
			}
		}
		if($sign){
			$data['top'] = $a;
			$this->assign($data); //渲染页眉
			return true;
		}
		return false;
	}
	
	/*
	 * 获取权限菜单
	 */
	protected function getMenus($menus){
		//获取所有的权限
		$a = get_result('menu',array('status'=>1)); //所有的菜单
		//获取用户权限
		$b = $menus['menus'];
		if(!$b){
			$b = $menus['groups_menus'];
		}
		$b = explode(',', $b);
		//处理数据
		foreach ($a as $v){
			foreach ($b as $val){
				if($v['id'] == $val){
					$v['is_check'] = 1;
					break;
				}
			}
			$c[] = $v;
		}
		$res = $this->getLevelMenus($c,3);
		return $res;
	}
	/*
	 * 获取所需菜单（树形）
	 * $menus 未处理的菜单
	 * $level 菜单层级
	 */
	protected function getLevelMenus($menus,$level){
		if($level==1){
			return $menus;
		}
		foreach ($menus as $v){
			if($v['level'] == $level){
				$a[] = $v;
			}elseif($v['level'] == $level-1){
				$b[] = $v;
			}else{
				$c[] = $v;
			}
		}
		foreach ($b as $v){
			foreach ($a as $val){
				if($v['id'] == $val['pid']){
					$v['_child'][] = $val;
				}
			}
			$c[] = $v;
		}
		$res = $this->getLevelMenus($c,$level-1);
		return $res;
	}
	
	protected function getUser(){
		return $this->user = session('user');
	}
	
	protected function getError(){
		return $this->str_error;
	}
	
	
	
// 	public function memcacheTest(){
// 		$memcache = memcache_connect('localhost', 11211);
// 		if($memcache){
// 			$memcache->set("str_key", "String to store in memcached");	//缓存字符串
// 			$memcache->set("num_key", 123);								//缓存int
// 			$array = Array('assoc'=>123, 345, 567);						//缓存数组
// 			$memcache->set("arr_key", $array);
	
// 			echo "<pre>";
// 			var_dump($memcache->get('str_key'));
// 			var_dump($memcache->get('num_key'));
// 			var_dump($memcache->get('arr_key'));
// 		}else{
// 			echo "Connection to memcached failed";
// 		}
// 	}
}
	
	