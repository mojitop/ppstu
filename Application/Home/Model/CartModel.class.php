<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model{
    
    protected $insertFields= array('goods_id','goods_attr_id','goods_number','user_id');
    protected $_validate=array(
		array('goods_number', 'require', '购买数量不能为空！', 1, 'regex', 3),
		array('goods_number', 'chk_goods_number', '库存不足！', 1, 'callback'),
            );
    public function chk_goods_number($goods_number){
        $gnModel = D('Admin/goodsnumber');
        $goods_attr_id = I('post.goods_attr_id');
        $goods_id = I('post.goods_id');
        sort($goods_attr_id, SORT_NUMERIC);
        $goods_attr_id= (string)implode(',', $goods_attr_id);
       
        $gnData = $gnModel->field('goods_number')->where(array(
                      'goods_id'=>array('eq',$goods_id),
                      'goods_attr_id'=>array('eq',$goods_attr_id),
                 ))->find();
       return $gnData['goods_number']>=$goods_number;
    }
    //添加到购物车
    public function add(){
        $data = I('post.');
        sort($data['goods_attr_id'], SORT_NUMERIC);
        $data['goods_attr_id']= (string)implode(',', $data['goods_attr_id']);       
        $user_id = session('u_id');
        //dump($user_id);die;
        if($user_id){
            $cartModel = D('cart');
            $rel = $cartModel->where(array(
                'goods_id'=>array('eq',$data['goods_id']),
                'goods_attr_id'=>array('eq',$data['goods_attr_id']),                  
                    ))->find();
            
            if(!$rel){
                 parent::add(array(
                   'goods_id'=>$data['goods_id'],
                    'goods_attr_id'=>$data['goods_attr_id'],
                    'goods_number'=>$data['goods_number'],
                    'user_id'=>$user_id, 
            ));  
            }else{
                $cartModel->where(array(
                   'id'=>array('eq',$rel['id']), 
                ))->setInc('goods_number',$data['goods_number']);
            }
        
        }else{
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            $key = $data['goods_id'].'-'.$data['goods_attr_id'];
            if(!isset($cart[$key])){
                $cart[$key] = $data['goods_number'];
            }else{
                $cart[$key] +=$data['goods_number'];
            }  
            setcookie('cart', serialize($cart),time()+30*86400,'/');   
        }
        return true;
    }
    public function moveDataToDB(){
        $user_id = session('u_id');
        //dump($user_id);die;
        if($user_id){
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            if($cart){
                foreach($cart as $k => $v){
                    $k = explode('-', $k);
                    $cartModel = D('cart');
                    $rel = $cartModel->where(array(
                        'goods_id'=>array('eq',$k['0']),
                        'goods_attr_id'=>array('eq',$k['1']),                  
                            ))->find();
                    if(!$rel){
                         parent::add(array(
                            'goods_id'=>$k['0'],
                            'goods_attr_id'=>$k['1'],
                            'goods_number'=>$v,
                            'user_id'=>$user_id, 
                    ));  
                    }else{
                        $cartModel->where(array(
                           'id'=>array('eq',$rel['id']), 
                        ))->setInc('goods_number',$v);
                    }   
                }  
                cookie('cart',null);
            }
         }
         return; 
    }
    public function setCarLst(){
        $user_ID = session('u_id');
        //判断是否登录 取出购物车中的数据
        if($user_ID){
            $data = $this->select();
        }else{
            $data = array();
            $_data = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            //将一维数组转成二维数组
            foreach($_data as $k => $v){
                $_k = explode('-',$k);
                $data[]= array(
                    'goods_id'=>$k['0'],
                    'goods_attr_id' => $k['1'],
                    'goods_number' => $v,
                );
            }
        }
        //取出商品的详细信息   
        $goodsModel = D('Admin/goods');
        foreach($data as $k => &$v){
            $gdata = $goodsModel->field('goods_name,mid_logo')->find($v['goods_id']);
            $v['goods_name'] = $gdata['goods_name'];
            $v['mid_logo'] = $gdata['mid_logo'];
        //属性值和 商品属性值
            $gaModel = D('goodsattr');
            $gaData = $gaModel->alias('a')
                    ->join('left join __ATTRIBUTE__ b on a.attr_id=b.id')
                    ->field('a.attr_value,b.attr_name')
                    ->where(array(
                         'a.id'=>array('in',$v['goods_attr_id']),
                    ))->select();            
            $v['gaData'] = $gaData;
            //取出商品实际价格
            $goods_pri = $goodsModel->ajaxGetPrice($v['goods_id']);
            $v['goods_pri'] = $goods_pri;
        }
        return $data;
    }
    public function clear(){
        $user_id = session('u_id');
        $cartModel = D('cart');
        $cartModel->where(array(
            'user_id' => array('eq',$user_id),
        ))->delete();
    }
}