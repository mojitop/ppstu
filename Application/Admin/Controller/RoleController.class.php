<?php
namespace Admin\Controller;

class RoleController extends BaseController 
{
    public function add()
    {
        header("content-type:text/html;charset=utf-8;");
    	if(IS_POST)
    	{  
                $role_model = D('role');
                if($role_model->create(I('post.'),1)){
                    if( $id = $role_model->add() ){
                    $this->success('添加成功！', U('lst', array('p' => I('get.p', 1))));
                    exit;
                    }
                }
               $this->error($role_model->getError());
                
    	}
    	
    	// 取出所有的权限
    	$priModel = D('privilege');
    	$priData = $priModel->getTree();

		// 设置页面中的信息
		$this->assign(array(
			'priData' => $priData,
			'page_name' => '添加角色',
			'page_btn_name' => '角色列表',
			'page_btn_target' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Role');
    	$data = $model->find($id);
    	$this->assign('data', $data);
    	
    	// 取出所有的权限
    	$priModel = D('privilege');
    	$priData = $priModel->getTree();
    	// 取出当前角色已经拥有 的权限ID
    	$rpModel = D('role_pri');
    	$rpData = $rpModel->field('GROUP_CONCAT(pri_id) pri_id')->where(array(
    		'role_id' => array('eq', $id),
    	))->find();

		// 设置页面中的信息
		$this->assign(array(
			'rpData' => $rpData['pri_id'],
			'priData' => $priData,
			'page_name' => '修改角色',
			'page_btn_name' => '角色列表',
			'page_btn_target' => U('lst'),
		));
		$this->display();
    }
    public function del()
    {
    	$model = D('Role');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
            $this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
            exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Role');
    	$data = $model->search();

    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'page_name' => '角色列表',
			'page_btn_name' => '添加角色',
			'page_btn_target' => U('add'),
		));
    	$this->display();
    }
}