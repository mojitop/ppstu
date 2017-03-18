<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller 
{
    public function login()
    {    
        $admin_model= D('admin');
        if(IS_POST){
            //接受数据并过滤
            $ad_data=I('post.');
            //验证验证码是否输入正确

            $verify_rel = $admin_model->check_verify($ad_data['captcha']);
            if($verify_rel){
               
                    $username = $ad_data['username'];
                    $password = md5($ad_data['password']);
                    $rel = $admin_model->where(array(
                                   'username'=>array('eq',$username),
                             ))->find();
                     $id = $rel['id'];
                    if($rel){
                        $rel_pwd = $admin_model->where(array(
                                   'password'=>array('eq',$password),
                             ))->find();
                        if($rel_pwd){
                            session('id',$id);
                            session('username',$username);
                            $this->success('登录成功',U('Index/index'));
                            return ;
                        }else{
                            $this->error('密码输入错误！！');
                        }
                    }else{
                        $this->error('用户名输入错误！！');
                    }
            }else{
                $this->error('验证码输入不正确','',2);
            } 
        }
    	$this->display();
    }
    public function logout()
    {
    	session(null);
        $this->redirect('Login/login');
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
    
}