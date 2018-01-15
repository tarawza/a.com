<?php
namespace Backend\Controller\System;
use Think\Controller;
use Backend\Controller\Base\AdminController;
class UserController extends AdminController {
	protected $table = 'member';
	protected $_validate = array(
			array('username','require','用户名必须！'), //默认情况下用正则进行验证
	);
	
	
	public function index(){
		$map = array('id'=>array('neq',1),'status'=>array('neq',-1));
		$map = $this->getSearch($map);
		$data['_list'] = get_result(D('MemberView'), $map);
		$this->assign($data);
		$this->display();
	}
	/*
	 * 添加
	 */
	public function add(){
		if(IS_POST){
			$username = I('username');$password = I('password');$sex = I('sex');$email = I('email');
			$tel = I('tel');$address = I('address');
			if(!$username){
				$this->error('用户名必填');
			}
			if(!$password){
				$this->error('密码必填');
			}
			if(get_info('member',array('username'=>$username,'status'=>1))){
				$this->error('用户名已存在');
			}
			if(get_info('member',array('email'=>$email,'status'=>1))){
				$this->error('邮箱已注册');
			}
			if(get_info('member',array('tel'=>$tel,'status'=>1))){
				$this->error('手机已注册');
			}
			$thistime = getD();
			$map = array(
					'username'=>$username,
					'password'=>md5(md5($password)),
					'sex'=>$sex==1?'男':'女',
					'email'=>$email,
					'tel'=>$tel,
					'address'=>$address,
					'add_time'=>$thistime,
					'add_member_id'=>$GLOBALS['user']['id'],
			);
			update_data('member', $map);
			$this->success('成功',U('index'));
		}else{
			$this->display();
		}
	}
	/*
	 * 修改
	 */
	public function edit(){
		$info = get_info('member', array('id'=>I('id'),'status'=>array('neq',-1)));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		if(IS_POST){
			$sex = I('sex');$email = I('email');$tel = I('tel');$address = I('address');
			$map = array(
					'id'=>$info['id'],
					'sex'=>$sex==1?'男':'女',
					'email'=>$email,
					'tel'=>$tel,
					'address'=>$address,
			);
			update_data('member', $map);
			$this->success('成功',U('index'));
		}else{
			$data['info']=$info;
			$this->assign($data);
			$this->display();
		}
	}
	/*
	 * 设置用户组
	 */
	Public function setGroup(){
		$info = get_info(D('MemberView'), array('id'=>I('id'),'status'=>array('neq',-1)));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		if(IS_POST){
			$groups_id = I('groups_id');
			if(!$groups_id){
				$this->error('请选择用户组');
			}
			//如果相同，则不写入数据库
			if($groups_id == $info['groups_id']){
				$this->success('成功',U('index'));
			}
			update_data('member', array('id'=>$info['id'],'groups_id'=>$groups_id));
			$this->success('成功',U('index'));
		}else{
			//获取所有用户组
			$data['groups'] = get_result('groups', array('status'=>1));
			$data['info'] = $info;
			$this->assign($data);
			$this->display();
		}
	}
	
	/*
	 * 禁用
	 */
	public function disable(){
		$info = get_info('member', array('id'=>I('id'),'status'=>1));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		update_data('member', array('id'=>$info['id'],'status'=>0));
		$this->success('成功',U('index'));
	}
	/*
	 * 启用
	 */
	public function enable(){
		$info = get_info('member', array('id'=>I('id'),'status'=>0));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		update_data('member', array('id'=>$info['id'],'status'=>1));
		$this->success('成功',U('index'));
	}
	/*
	 * 删除
	 */
	public function del(){
		$info = get_info('member', array('id'=>I('id'),'status'=>0));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		update_data('member', array('id'=>$info['id'],'status'=>-1));
		$this->success('成功',U('index'));
	}
	
	/*
	 * 批量删除
	 */
	public function allDel(){
		if(IS_POST){
			$ids = I('ids');
			if(!$ids){
				$this->error('请勾选');
			}
			$ids = explode(',', $ids);
			$a = get_result($this->table, array('id'=>array('in',$ids),'status'=>0));
			if(count($a) != count($ids)){
				$this->error('数据错误,请刷新重试');
			}
			saveData('member',$ids,array('status'=>-1));
			$this->success('成功',U('index'));
		}
	}

	/*
	 * 设置权限
	 * 1.检查数据
	 */
	public function setMenu(){
		$info = get_info(D('MemberView'),array('id'=>I('id'),'status'=>array('neq',-1)));
		if(!$info){
			$this->error('您访问的数据不存在');
		}
		if(IS_POST){
			$ids = I('ids');
			if(!$ids){
				$this->error('数据错误');
			}
			update_data('member', array('id'=>$info['id'],'menus'=>$ids));
			$this->success('成功',U('index'));
		}else{
			$data['menus'] = $this->getMenus($info); //获取正确的菜单
			$data['info'] = $info;
			$this->assign($data);
			$this->display();
		}
	}
	
}
	