<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller 
{    
    public function ajax_chk_login(){
        if(session('u_id')){
            $rel=array(
               'link'=>1,
                'id' => session('u_id'),
                'username'=> session('u_username'),
                'level_name'=> session('u_level_name'),
            );
        }else{
            $rel=array(
                'link'=> 0,
            );
        }
        echo json_encode($rel);
    }
    public function login()
    {    
        $user_model= D('Admin/user');
        if(IS_POST){
            //接受数据并过滤
            $ad_data=I('post.');
            //验证验证码是否输入正确

            $verify_rel = $user_model->check_verify($ad_data['captcha']);
            if($verify_rel){
               
                    $username = $ad_data['username'];
                    $password = md5($ad_data['password']);
                    $rel = $user_model->where(array(
                                   'username'=>array('eq',$username),
                             ))->find();
                    if($rel){
                        $id = $rel['id'];
                        //取出会员积分保存到session中
                        $jifen =$rel['jifen'];
                        //计算会员级别
                        $ulModel = D('userlevel');
                        $ulData = $ulModel->field('id,level_name')->where(array(
                                    'jifen_bottom'=>array('elt',$jifen),
                                    'jifen_top'=>array('egt',$jifen),
                              ))->find();
                        if( $rel['password'] == $password){
                            session('u_id',$id);
                            session('u_username',$username);
                            session('u_jifen',$jifen);
                            session('u_level_name',$ulData['level_name']);
                            session('face','/Public/Home/images/user2.jpg');
                            $cartModel = D('cart');
                            $cartModel->moveDataToDB();
                            
                            $url = U('Index/index');
                            $u = session('returnurl');
                            if($u){
                                $url = $u;
                                session('returnurl',null);
                            }
                            $this->success('登录成功',$url);
                            return ;
                        }else{
                            $this->error('密码输入错误！！');
                        }
                    }else{
                        $this->error('用户名输入错误！！');
                    }
            }else{
                $this->error('验证码输入不正确','',1);
            } 
        }
         $this->assign(array(
                '_page_title'=>'登录',
                '_page_keywords'=>'登录',
                '_page_description'=>'登录',
        ));
    	$this->display();
    }
    public function logout()
    {
    	session(null);
        $this->redirect('User/login');
    }
   public function verify(){
       $config =    array(    
               'fontSize'    =>    20,    // 验证码字体大小    
               'length'      =>    2,                            // 验证码位数    
               'useNoise'    =>   false,                        // 关闭验证码杂点
               'fontttf'     =>  '5.ttf',
               'imageH'      =>   40,
               'imageW'      =>  150,
              // 'bg'          =>   array(125, 125, 125),
               'useImgBg'    =>   false,
        );                 
       $Verify  =   new \Think\Verify($config);
       $Verify->entry();
   }
       public function register()
    {
    	if(IS_POST)
    	{
    		$user_model = D('Admin/user');
                $ad_data=I('post.');
                //验证验证码是否输入正确
                $verify_rel = $user_model->check_verify($ad_data['captcha']);
                if($verify_rel){
                    if( I('post.must_checked') == 1 && $user_model->create(I('post.'), 1) )
                    {
                            if($id = $user_model->add())
                            {
                                    $this->success('添加成功！', U('login'),2);
                                    exit;
                            }
                    }else{
                         $this->error($user_model->getError());
                         exit;
                    }
                }else{
                    $this->error('验证码不正确！！',U('register'),1);
                    exit;
                }                   
    		
    		
    	}
    	
        // 设置页面中的信息
        $this->assign(array(
                '_page_title'=>'注册',
                '_page_keywords'=>'注册',
                '_page_description'=>'注册',
        ));
        $this->display();
    }
        public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Admin');
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
    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);
    	
    	$roleModel = D('Role');
    	$roleData = $roleModel->select();
    	// 取出当前管理员所在的角色ID
    	$arModel = D('admin_role');
    	$roleId = $arModel->field('GROUP_CONCAT(role_id) role_id')->where(array(
    		'admin_id' => array('eq', $id),
    	))->find();

		// 设置页面中的信息
		$this->assign(array(
			'roleId' => $roleId['role_id'],
			'roleData' => $roleData,
			'page_name' => '修改管理员',
			'page_btn_name' => '管理员列表',
			'page_btn_target' => U('lst'),
		));
		$this->display();
    }
    public function del()
    {
    	$model = D('Admin');
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
    
}