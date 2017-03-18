<?php
namespace Home\Controller;

class MyselfController extends NavController {
    public function __construct(){
        parent::__construct();
        $user_id = session('u_id');
        if(!$user_id){
            session('returnurl',U('Myself/'.ACTION_NAME));
            $this->redirect('User/login', array(), 1, '请先登录...');
        }
    }
    public function index(){
       
        $orderModel = D('Admin/order');
        
        $user_id = session('u_id');
        $no_pay = $orderModel
                ->where(array(
                    'user_id'=>array('eq',$user_id),
                    'pay_status'=>array('eq','否'),
                ))->select();
        $data = $orderModel->search();
        
        $this->assign(array(
                 'no_pay'=>$no_pay,
                'data'=>$data,
                '_show_nav'=>0,
                '_page_title'=>'我的订单',
        ));
           $this->display();
        }
    
   
}
