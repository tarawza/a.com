<?php
// 本类由系统自动生成，仅供测试用途
namespace Backend\Controller\System;
use Think\Controller;
use Backend\Controller\Base\AdminController;
class MenuController extends AdminController {
	protected $table = 'groups';
	
	public function index(){
		$data['_list'] = get_result($this->table, array('status'=>array('neq',-1)));
		$this->assign($data);
		$this->display();
	}
	
	/*
	 * 添加
	 */
	public function add(){
		if(IS_POST){
			$title = I('title');$remark = I('remark');
			if(!$title){
				$this->error('用户组名必填');
			}
			if(get_info('title', array('title'=>$title,'status'=>array('neq',-1)))){
				$this->error('用户组已存在');
			}
			update_data($this->table, array('title'=>$title,'remark'=>$remark));
			$this->success('成功',U('index'));
		}else{
			$this->display();
		}
	}
	
	/*
	 * 修改
	 */
	public function edit(){
		$info = get_info($this->table, array('id'=>I('id'),'status'=>array('neq',-1)));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		if(IS_POST){
			$title = I('title');$remark = I('remark');
			if(!$title){
				$this->error('用户组名必填');
			}
			//如果没有修改，直接成功
			if($title == $info['title'] && $remark == $info['remark']){
				$this->success('成功',U('index'));
			}
			//判断是否重复
			if(get_info('title', array('id'=>array('neq',$info['id']),'title'=>$title,'status'=>array('neq',-1)))){
				$this->error('用户组已存在');
			}
			update_data($this->table, array('id'=>$info['id'],'title'=>$title,'remark'=>$remark));
			$this->success('成功',U('index'));
		}else{
			$data['info'] = $info;
			$this->assign($data);
			$this->display();
		}
	}
	/*
	 * 禁用
	 */
	public function disable(){
		$info = get_info($this->table,array('id'=>I('id'),'status'=>1));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		update_data($this->table, array('id'=>$info['id'],'status'=>0));
		$this->success('成功',U('index'));
	}
	/*
	 * 启用
	 */
	public function enable(){
		$info = get_info($this->table,array('id'=>I('id'),'status'=>0));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		update_data($this->table, array('id'=>$info['id'],'status'=>1));
		$this->success('成功',U('index'));
	}
	/*
	 * 删除
	 */
	public function del(){
		$info = get_info($this->table,array('id'=>I('id'),'status'=>0));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		update_data($this->table, array('id'=>$info['id'],'status'=>-1));
		$this->success('成功',U('index'));
	}
	/*
	 * 设置权限
	 */
	public function setMenu(){
		$info = get_info('groups',array('id'=>I('id'),'status'=>array('neq',-1)));
		if(!$info){
			$this->error('您访问的数据不存在');
		}
		if(IS_POST){
			$ids = I('ids');
			if(!$ids){
				$this->error('数据错误');
			}
			update_data('groups', array('id'=>$info['id'],'menus'=>$ids));
			$this->success('成功',U('index'));
		}else{
			$data['menus'] = $this->getMenus($info); //获取正确的菜单
			$data['info'] = $info;
			$this->assign($data);
			$this->display();
		}
	}
	 
}
	