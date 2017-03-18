<?php
namespace Admin\Controller;

class CategoryController extends BaseController 
{
  public function add(){
        //IS_POST 判断用户是否提交表单 
        $model = D('category');
        if(IS_POST){
            //创建商品模型
            

            //create (  , )  接受的数据（默认$_POST）    表单的类型（添加 或 修改）
            //create（） 有过滤和表单验证 作用 
            if($model->create(I('post.'),1)){
                //插入到数据库
                if($model->add()){
                    $this->success('添加分类成功',U('lst'));
                    exit;
                }
            } 
            $error =$model->getError();
            $this->error($error);
        }

        $data = $model->gettree();
        $this->assign(array(
            'data'=>$data,
            'page_name'=>'添加新分类',
            'page_btn_name'=>'返回列表',
            'page_btn_target'=>U('lst')
        ));
        //显示表单
        
        $this->display();
       
    }
    public function edit(){
       //IS_POST 判断用户是否提交表单
        $id=I('get.id');
        //创建商品模型
        $model = D('category');
        if(IS_POST){

            //create (  , )  接受的数据（默认$_POST）    表单的类型（添加 或 修改）
            //create（） 有过滤和表单验证 作用 
            if($model->create(I('post.'),2)){
                //更新到数据库
                if(false !== $model->save()){
                    $this->success('修改分类成功',U('lst'));
                    exit;
                }
            } 
            $error =$model->getError();
            $this->error($error);
        }

       //取得所有分类ID
        $data = $model->gettree();
        //获得当前id的子分类
        $cid = $model->getchild($id);

        $did = $model->find($id);
        $this->assign(array(
            'did'=>$did,
            'cid' => $cid,
            'data'=>$data,
            'page_name'=>'分类修改',
            'page_btn_name'=>'返回列表',
            'page_btn_target'=>U('lst')
        ));
        //显示表单
        $this->display();
       
    }
    public function del(){
        
        $model = D('category');
        $id = I('get.id');
        if($model->delete($id)){
           $this->success("删除分类成功",U('lst'));
        exit;
        }else {
         $this->error('删除失败！！原因：'.$model->getError());   
        }
    }
    public function lst(){
        //商品列表
        $model = D('category');
        $data = $model ->gettree();
        $this->assign(array(
            'data'=>$data,
            'page_name'=>'PRO分类列表',
            'page_btn_name'=>'添加新分类',
            'page_btn_target'=>U('add')
        ));
        $this->display();
    }

}
