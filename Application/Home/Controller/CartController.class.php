<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
    
    public function receive(){
        require_once './alipay/notify_url.php';
    }
    
    public function add(){
        $goods_id=I('post.goods_id');
        $cartModel = D('cart');
        if(IS_POST){

            if($cartModel->create(I('post.'),1)){
                if($cartModel->add()){
                    $this->success('添加成功！',U('Cart/cartLst?id='.$goods_id),1);
                    exit;
                }
            }
            $this->error($cartModel->getError());
        }else{
            $this->error('非法访问！！',U('Index/goods?id='.$goods_id),1);
        }

    }
    public function cartLst(){
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
    public function ajax_get_cart_list(){
        $cartModel = D('cart');
        $cartData = $cartModel->setCarLst();
        echo json_encode($cartData);
    }
    public function order(){
        $user_id = session('u_id');
        if(!$user_id){
            session('returnurl',U('Cart/order'));

            $this->error('请先登录。。。',U('User/login'),1);
            exit;
        }
        if(IS_POST){
            $orderModel = D('Admin/order');
            if($orderModel->create(I('post.'),1)){
                if($orderID = $orderModel->add()){
                    $this->success('下单成功！！',U('Cart/order_jiesuan?orderID='.$orderID),1);
                    exit;
                }
            }
            $this->error($orderModel->getError());
        }
 
        $cartModel = D('cart');
        $cartData = $cartModel->setCarLst();
        $this->assign(array(
                'cartData' => $cartData,
                '_page_title'=>'订单页',
                '_page_keywords'=>'订单页',
                '_page_description'=>'订单页',
        ));
        $this->display();        
    }
    PUBLIC function order_jiesuan(){
        $orderModel = D('Admin/order');
        $orderID = I('get.orderID');
        $btn = $orderModel->makeAlipayBtn($orderID);
            //结算购物车
        $this->assign(array(
                'btn' => $btn,
                '_page_title'=>'订单支付',
                '_page_keywords'=>'订单支付',
                '_page_description'=>'订单支付',
        ));
        $this->display();        
        
    }
    
}