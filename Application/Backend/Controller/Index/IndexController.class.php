<?php
// 本类由系统自动生成，仅供测试用途
namespace Backend\Controller\Index;
use Think\Controller;
use Backend\Controller\Base\AdminController;
class IndexController extends Controller {
	
	/*
	 * 首页
	 * 1.检查登录
	 * 2.检查是否有菜单缓存，有就使用菜单缓存
	 * 3.没有就获取菜单数据，缓存菜单数据
	 */
	public function index(){
		//1.检查登录
		if(!$this->is_login()){
			$this->display('login');
		}else{
			//获取所有菜单数据(暂无缓存)
			if(!session('?menu')){
				$c = $this->getMyMenus();
				session('menu',$c);
			}else{
				$c = session('menu');
			}
			$data['_list'] = $this->getLeftMenu($c);
			$this->assign($data);
			$this->display();
		}
	}
	/*
	 * 登录
	 * 1.判断是否登录
	 * 2.检查用户名和密码
	 * 3.存入缓存
	 * 4.跳转后台首页
	 */
	public function login(){
		//1.判断是否登录
		if($this->is_login()){
			$this->error('已登录');
		}
		//检查验证码
// 		if(!$this->check_verify(I('verify'))){
// 			$this->error('验证码错误');
// 		}
		if(IS_POST){
			//2.检查用户名和密码
			$username = I('username');
			$password = md5(md5(I('password')));
			$user = get_info(D('MemberView'), array('username'=>$username,'status'=>1));
			if(!$user){
				$this->error('用户不存在');
			}
			if($user['password']!=$password){
				$this->error('密码错误');
			}
			//3.存入缓存
			$user['login'] = 1;
			session('user',$user);
			//4.跳转后台首页
			$this->success('成功',U('index'));
		}
	}
	/*
	 * 验证码检验
	 */
	protected function check_verify($code, $id = ''){
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}
	/*
	 * 生成验证码
	 */
	public function verify(){
		$Verify = new \Think\Verify();
		$Verify->entry();
	}
	
	/*
	 * 退出
	 */
	public function logout(){
		session_start();
		session_destroy();
		$url = U('index');
		Header("Location:$url");
	}
	
	protected function is_login(){
		if($_SESSION['user']['login']!=1){
			return false;
		}
		return true;
	}
	
	/*
	 * 获取后台左侧菜单
	 * $a 所有的菜单数据
	 */
	protected function getLeftMenu($a){
		foreach ($a as $v){
			if($v['level']==1){
				$b[] = $v;
			}
			if($v['level']==2){
				$c[] = $v;
			}
		}
		foreach ($b as $v){
			foreach ($c as $val){
				if($v['id']==$val['pid']){
					$v['_child'][] = $val;
				}
			}
			$data[] = $v;
		}
		return $data;
	}
	
	protected function getMyMenus(){
		$a = get_result('menu',array('status'=>1)); //所有的菜单
		$user = session('user');					//我的菜单的ids
		if($user['id']==1 &&$user['groups_id'] == 0){
			return $a;
		}
		if(!$user['menus']){
			$b = $user['groups_menus'];
		}else{
			$b = $user['menus'];
		}
		$menus_ids = explode(',', $b);
		foreach ($a as $v){
			foreach ($menus_ids as $val){
				if($v['id'] == $val){
					$c[] = $v;						//我的菜单集合
					break;
				}
			}
		}
		return $c;
	}

}