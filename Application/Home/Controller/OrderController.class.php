<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller{
    
    public function orderLst(){
        $cartModel = D('cart');
        $cartData = $cartModel->setCarLst();
        $this->assign(array(
                'cartData' => $cartData,
                '_page_title'=>'购物车',
                '_page_keywords'=>'购物车',
                '_page_description'=>'购物车',
        ));
        $this->display();
    }

}