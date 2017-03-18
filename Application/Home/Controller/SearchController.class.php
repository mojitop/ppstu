<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends NavController{
    
   
    public function cat_search(){
        $cat_id = I('get.cat_id');
        $goodsModel = D('Admin/goods');
        $goods_data = $goodsModel->getGoodsByCat($cat_id);

        $data = $goodsModel->getSearchConditionByGoodsId($goods_data['goods_id']);
        $this->assign(array(
                'goods_data'=>$goods_data['goods_data'],
                'page'=>$goods_data['page'],
                'data'=>$data,
                '_show_nav'=>0,
                '_page_title'=>'商品列表',
                '_page_keywords'=>'商品列表',
                '_page_description'=>'商品列表',
        ));
        $this->display();
    }
   
     public function key_search(){
        $key = I('get.key');
        $goodsModel = D('Admin/goods');
        $goods_data = $goodsModel->getGoodsByKey($key);

        $data = $goodsModel->getSearchConditionByGoodsId($goods_data['goods_id']);
        $this->assign(array(
                'goods_data'=>$goods_data['goods_data'],
                'page'=>$goods_data['page'],
                'data'=>$data,
                '_show_nav'=>0,
                '_page_title'=>'商品列表',
                '_page_keywords'=>'商品列表',
                '_page_description'=>'商品列表',
        ));
        $this->display();
    }
}