<?php
namespace Admin\Controller;

class BrandController extends BaseController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Brand');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}

		// 设置页面中的信息
		$this->assign(array(
			'page_name' => '添加品牌',
			'page_btn_name' => '品牌列表',
			'page_btn_target' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Brand');
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
    	$model = M('Brand');
    	$data = $model->find($id);
    	$this->assign('data', $data);

		// 设置页面中的信息
		$this->assign(array(
			'page_name' => '修改品牌',
			'page_btn_name' => '品牌列表',
			'page_btn_target' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Brand');
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
    	$model = D('Brand');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息

		$this->assign(array(
			'page_name' => '品牌列表',
			'page_btn_name' => '添加品牌',
			'page_btn_target' => U('add'),
		));
    	$this->display();
    }
}