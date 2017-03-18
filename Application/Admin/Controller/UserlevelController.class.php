<?php

namespace Admin\Controller;

class UserlevelController extends BaseController {
    public function lst(){
        $model = D('userlevel');
        $data = $model->select();
        $this->assign(array(
                'data'=>$data,
                'page_name'=>'V_level列表',
                'page_btn_name'=>'添加新level',
                'page_btn_target'=>U('add'))
           );
        //显示表单
        $this->display();
    }
    public function add(){
        //接受数据
        if(IS_POST){
            //创建商品模型
            $model = D('userlevel');
            //create (  , )  接受的数据（默认$_POST）    表单的类型（添加 或 修改）
            //create（） 有过滤和表单验证 作用 
            if($model->create(I('post.'),1)){
                //插入到数据库
                if($model->add()){
                    $this->success('添加level成功',U('lst'));
                    exit;
                }
            } 
            $error =$model->getError();
            $this->error($error);
        }
        $this->assign(array(
                'page_name'=>'修改level',
                'page_btn_name'=>'返回V_level列表',
                'page_btn_target'=>U('lst'))
           );
        //显示表单
        $this->display();
    }
    public function edit(){
       //IS_POST 判断用户是否提交表单
        $id=I('get.id');
        //创建模型
        $model = D('userlevel');
        if(IS_POST){
            //create (  , )  接受的数据（默认$_POST）    表单的类型（添加 或 修改）
            //create（） 有过滤和表单验证 作用 
            
            if($model->create(I('post.'),2)){
                //更新到数据库
                if(false !== $model->save()){
                    $this->success('修改level成功',U('lst'));
                    exit;
                }
            } 
            $error =$model->getError();
            $this->error($error);
        }
        
        $data = $model->find($id);
        
        $this->assign(array(
            'data'=>$data,
            'page_name'=>'level修改',
            'page_btn_name'=>'返回列表',
            'page_btn_target'=>U('lst')
        ));
        //显示表单
        $this->display();
       
    }
    public function del(){
        
        $model = D('userlevel');
        $id = I('get.id');
        if($model->delete($id)){
           $this->success("删除level成功",U('lst'));
        exit;
        }else {
         $this->error('删除失败！！原因：'.$model->getError());   
        }
    }
}
