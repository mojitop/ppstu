<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model {
        //添加表单允许接受的字段
        protected $insertFields = 'shr_name,shr_area,shr_tel,shr_province,shr_city,shr_address';
        //定义表单域规则
        protected $_validate = array(
            array('shr_name','require','收货人名称不能为空',1),
            array('shr_tel','require','收货人电话不能为空',1),
            array('shr_province','require','收货人省份不能为空',1),
            array('shr_city','require','收货人城市不能为空',1),
            array('shr_address','require','收货人详细地址不能为空',1),
            
        
    );
        
        public function makeAlipayBtn($orderID,$btname='支付宝支付'){
            return require '/alipay/alipayapi.php';
        }
        public function setPaid($orderID){
            $order_model = M('order');
            $order_model->where(array(
                'id'=>array('eq',$orderID),
            ))->asve(array(
                'pay_atatus'=>'是',
                'pay_time'=>time(),
            ));
            //会员积分修改
            $rel = $order_model->field('user_id,total_price')->where(array(
                'id'=>array('eq',$orderID),
            ))->find();
            $user_model = M('user');
            $user_id = $rel['user_id'];
            $user_model->where(array(
                'id'=>array('eq',$user_id),
            ))->setInc('jifen',$rel['total_price']);
        }
        protected function _before_delete($option){
          

        }
        protected function _after_delete($option){

            
        }
        protected function  _before_insert(&$data,&$option){

            //下订单之前检查订单 和补充数据 setCarLst
            //获取购物车中的数据
            
            $cartModel = D('cart');
            $option['cartData']=$cartData = $cartModel->setCarLst();
            $user_id = $data['user_id'] = session('u_id');
            //检查是否登录
            if(!$user_id){
                $this->error('下订单失败，请先登录！','Cart/CartLst',1);
                return false;
            }
            $this->$fp = fopen('./order.lock', 'r');
            flock($fp, LOCK_EX);
            //检查库存量
            $gnModel = D('Admin/goodsnumber');
            $total = 0;
            foreach($cartData as $k => $v){
                $gnData = $gnModel->field('goods_number')->where(array(
                    'goods_id'=>array('eq',$v['goods_id']),
                    'goods_attr_id'=>array('eq',$v['goods_attr_id']),
                ))->find();
               if( $gnData['goods_number'] < $goods_number){
                       $this->error('下订单失败，库存不足！','Cart/CartLst',1);
                       return false;                  
               }
               $total = $v['goods_pri']*$v['goods_number'];
            }
            $data['addtime']=time(); 
            $data['total_price'] = $total;
            $this->startTrans();
            
        }
        protected function  _after_insert(&$data,$option){
             //订单下了之后操作reder_goods 表
            //循环购物车的数据插入到 order_goods表 and 减库存量
            $gnModel = D('Admin/goodsnumber');
            $ogModel = D('order_goods');
            $cartData = $option['cartData'];
            $order_id = $data['id'];     
            foreach($cartData as $k => $v){
                $rel = $ogModel->add(array(
                    'order_id'=>$order_id,
                    'goods_id'=>$v['goods_id'],
                    'goods_attr_id'=>$v['goods_attr_id'],
                    'goods_number'=>$v['goods_number'],
                    'price'=>$v['goods_pri'],
                    ));

                if(!$rel){
                    $this->rollback;
                    return false;
                }
                //减库存
                $gnData = $gnModel->where(array(
                    'goods_id'=>array('eq',$v['goods_id']),
                    'goods_attr_id'=>array('eq',$v['goods_attr_id']),
                ))->setDec('goods_number',$v['goods_number']);
                if(false === $gnData){
                     $this->rollback;
                     return false;
                }
            }
            $this->commit();
            //释放文件锁
            flock($this->$fp, LOCK_UN);
            fclose($this->$fp);
            //清空购物车
            $cartModel = D('cart');
            $cartModel->clear();

        }
        protected function  _before_update(&$data,$option){

        }
        protected function _after_uptade(&$data,$option){}
        public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
                $user_id = session('u_id');
		$where = array(
                    'user_id'=>array('eq',$user_id),
                    );
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')
                        ->field('a.id,a.addtime,a.shr_name,a.total_price,group_concat(c.sm_logo),b.order_id,b.goods_id')
                        ->join('left join __ORDER_GOODS__  b on a.id=b.order_id
                                left join __GOODS__ c on b.goods_id=c.id')
                        ->where($where)
                        ->group('a.id')
                        ->limit($page->firstRow.','.$page->listRows)
                        ->select();
		return $data;
	}
}












