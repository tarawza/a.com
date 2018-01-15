<?php
// 本类由系统自动生成，仅供测试用途
namespace Backend\Controller\Base;
use Think\Controller;
use Backend\Controller\Base\AdminController;
class BasicSetController extends AdminController {
	protected $table = 'set';
	
	public function index(){
		$data['_list'] = get_result($this->table, array('status'=>1));
		$this->assign($data);
		$this->display();
	}
	
	/*
	 * 修改
	 */
	public function edit(){
		$info = get_info($this->table, array('id'=>I('id'),'status'=>1));
		if(!$info){
			$this->error('您访问的信息不存在');
		}
		if(IS_POST){
			$value = I('value');
			update_data($this->table, array('id'=>$info['id'],'value'=>$value));
			$this->success('成功',U('index'));
		}else{
			$data['info']=$info;
			$this->assign($data);
			$this->display();
		}
	}
}
	