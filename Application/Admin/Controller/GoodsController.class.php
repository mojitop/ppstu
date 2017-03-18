<?php
namespace Admin\Controller;

class GoodsController extends BaseController 
{
  /**************库存表操作***************/
    public function goodsnum(){
        header("content-type:text/html;charset=utf-8");
        $goods_num_model = D('goodsnumber');
        $goods_id = I('get.id'); 
        if(IS_POST){
            //清空当前goods_id 的库存量
           $goods_num_model->where("goods_id=$goods_id")->delete();
           
           $gnumr=I('post.goods_number');
           $gaid = I('post.goods_attr_id');
           $times = count(I('post.goods_attr_id'))/count(I('post.goods_number'));
           $_i=0;
               foreach($gnumr as $k => $v){
                            if( $v==0 ){ 
                               // $this->redirect('goodsnum',array('goods_id'=>$goods_id),2,"库存修改失败");
                                $this->error('好桑心！！库存修改失败了。。。');
                                exit;
                            }
                             for($i=0;$i<$times;$i++){
                                 $goods_attr_id[] = $gaid[$_i];
                                 $_i++;
                             }  
                             sort($goods_attr_id, SORT_NUMERIC);
                             (string)$attr_lst =  implode(',', $goods_attr_id);
                             $rel = $goods_num_model->add(array(
                                   'goods_id'=>$goods_id,
                                   'goods_number'=>$v,
                                   'goods_attr_id'=>$attr_lst
                                     ));
                             $goods_attr_id = array();
                    }
               if($rel){
                $this->success('库存量操作成功',U('lst'));
                exit;
                }else{
                   $error =$goods_num_model->getError();
                   $this->error($error);                   
             }
                 
           
                    
 

        }else{
            //以goodsattr为主 获取可选属性 制作添加页面
            $goods_id = I('get.id');
            $ga_model = D('goodsattr');
            $ga_data = $ga_model->alias("a")
                    ->field("a.*,b.attr_type,b.attr_name")
                    ->join("left join __ATTRIBUTE__ b on a.attr_id=b.id")
                    ->where(array(
                      'attr_type'=>array('eq',"可选"),
                      'goods_id' => array('eq',$goods_id)
                      ))
                    ->select();
            //处理数组 二维 转 三维
            foreach ($ga_data as $k => $v) {
                $_ga_data[$v['attr_name']][]=$v;
            }
            
            $gn_data = $goods_num_model->where(array(
                  'goods_id'=>array('eq',$goods_id),
                  ))->select();
            //分配数据到页面
            $this->assign(array(
                'gn_data'=>$gn_data,
                '_ga_data'=>$_ga_data,
                'page_name'=>'库存量设置',
                'page_btn_name'=>'商品列表',
                'page_btn_target'=>U('lst')
            ));
            $this->display();
        }
   }
  public function add(){
        //IS_POST 判断用户是否提交表单 
        if(IS_POST){
            //创建商品模型
            $model = D('goods');
           
            //create (  , )  接受的数据（默认$_POST）    表单的类型（添加 或 修改）
            //create（） 有过滤和表单验证 作用 
            if($model->create(I('post.'),1)){
                //插入到数据库
                if($model->add()){
                    $this->success('添加goods成功',U('lst'));
                    exit;
                }
            } 
            $error =$model->getError();
            $this->error($error);
        }
        //取得会员价格
        $vmodel =D('userlevel');
        $vdata = $vmodel->field("level_name,id")->select();
        
        $catmodel = D('category');
        $catdata = $catmodel->gettree();
        $this->assign(array(
            'catdata'=>$catdata,
            'vdata'=> $vdata,
            'page_name'=>'PRO添加',
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
        $model = D('goods');
        $pmodel =D('userprice');
        $vmodel =D('userlevel');
        if(IS_POST){
           $p = I('post.vip_price');
           foreach($p as $pk => $pv){
               $_id = (int)$id;
               $_pv = (float)$pv;
               $_pk = (float)$pk;
               //$Model->execute("update think_user set name='thinkPHP' where status=1");
               $pmodel->execute("update mgs_userprice set price=$_pv where goods_id=$_id and level_id=$_pk");
           }
    /*******************修改商品之前  更新商品属性表******************/
           $goods_attr_model = D('goodsattr');
           $goods_attr_id = I('post.goods_attr_id');
           $attr_value = I('post.attr_value');
           $goods_id = $id ;
           $pid = 0;
           foreach($attr_value as $k => $v){
                foreach($v as $k1 => $v1){
                  
                    if($goods_attr_id[$pid] == ''){
                    //属性ID等于 “” 说明是添加 
                        $goods_attr_model->add(array(
                            'attr_value'=> $v1,
                            'attr_id' => $k,
                            'goods_id' => $goods_id,
                           )
                         );
                    }else{
                        $goods_attr_model->where(array(
                            'id'=>array('eq',$goods_attr_id[$pid] ) ,
                           ))
                            ->setfield('attr_value' , $v1); 
                    }
                    $pid++;
                }

            }
           
            //create (  , )  接受的数据（默认$_POST）    表单的类型（添加 或 修改）
            //create（） 有过滤和表单验证 作用 
            if($model->create(I('post.'),2)){
                //更新到数据库
                if(false !== $model->save()){
                    $this->success('修改goods成功',U('lst'));
                    exit;
                }
            } 
            $error =$model->getError();
            $this->error($error);
        }
        //取得商品信息
        
        $data = $model->find($id);
        // dump($model->where("id =$id")->select());
        // 
       //取得会员信息
        $vdata = $vmodel->field("level_name,id")->select();
        //取得会员价格信息
        $pdata = $pmodel->where("goods_id=$id")->select();
         //获得分类tree
        $catmodel = D('category');
        $catdata = $catmodel->gettree();
        
        //取出扩展分类id
        $goodscat_model = D('goodscat');
        $goodscat_data = $goodscat_model->where("goods_id=$id")->select();
        
/*********************取出商品属性信息*************************/
        $ab_model = D('attribute');
        $type_id= $data['type_id'];
        if($type_id){
            $abdata = $ab_model->alias("a")
                        ->field("a.*,b.attr_value,b.id goods_attr_id")
                        ->join("left join __GOODSATTR__ b on a.id=b.attr_id")
                        ->where("type_id=$type_id and b.goods_id=$id")
                        ->select(); 
        }
 /*********************取出商品pic信息*************************/      
        $pic_model = D('goods_pic');
        $goods_id = $id;
            $pic_data = $pic_model
                        ->where("goods_id=$goods_id")
                        ->select(); 

        
        $this->assign(array(
            'pic_data'=>$pic_data,
            'abdata'=>$abdata,
            'goodscat_data'=>$goodscat_data,
            'catdata'=>$catdata ,
            'data'=>$data,
            'vdata'=>$vdata,
            'pdata'=>$pdata,
            'page_name'=>'PRO修改',
            'page_btn_name'=>'返回列表',
            'page_btn_target'=>U('lst')
        ));
        //显示表单
        $this->display();
       
    }
    public function del(){
        
        $model = D('goods');
        $id = I('get.id');
        if($model->delete($id)){
           $this->success("删除goods成功",U('lst'));
        exit;
        }else {
         $this->error('删除失败！！原因：'.$model->getError());   
        }
    }
    public function lst(){
        //商品列表
        $model = D('goods');
        
        //返回数据和翻页
        $data = $model->search();
        $this->assign('list',$data['list']);
        $this->assign('page',$data['page']);
        //取得分类ID
        $catmodel = D('category');
        $catdata = $catmodel->gettree();
        $this->assign(array(
            'catdata'=>$catdata,
            'page_name'=>'PRO列表',
            'page_btn_name'=>'添加新商品',
            'page_btn_target'=>U('add')
        ));
        $this->display();
    }
    public function ajaxGetAttr(){
        $attrmodel = D('attribute');
        $type_id = I('get.type_id');
        $data = $attrmodel ->where("type_id='$type_id'")
                -> select();
        echo json_encode($data);
    }
    public function remove_attr(){
        $goods_id=I('get.goods_id');
        $goods_attr_id = I('get.goods_attr_id');
        $ga_model = D('goodsattr');
        $ga_model->delete($goods_attr_id);
        //删除商品属性对应的库存量
        $gn_model = D('goodsnumber');
        //$where['goods_id']=array('eq','$goods_id'); 
         $gn_data = $gn_model->where(array(
                'goods_id' => array('exp',"=$goods_id or AND WHERE FIND_IN_SET('$goods_attr_id','goods_attr_id')"),
                ))->delete();
         
    }
}
