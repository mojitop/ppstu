<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model 
{
	protected $insertFields = array('username','password','cpassword','captcha','must_checked');
	protected $updateFields = array('id','username','password');
	// 添加和修改管理员时使用的表单验证规则
	protected $_validate = array(
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('username', '3,20', '用户名的长度为3-30个字符！', 1, 'length', 3),
		// 第六个参数：规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
                array('password', '6,20', '密码的长度为6-30个字符！', 1, 'length', 3),
		array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
		array('username', '', '用户名已经存在！', 1, 'unique', 3),
             
	);
        
	// 验证验证码是否正确
	function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}
	public function login($data)
	{    
            
            $username = $data['username'];
            $id = $data['id'];
            $password = md5($data['password']);
            $rel = $this->where(array(
                           'username'=>array('eq',$username),
                     ))->find();
            if($rel){
                $rel_pwd = $this->where(array(
                           'password'=>array('eq',$password),
                     ))->find();
                if($rel_pwd){
                    session('id',$id);
                    session('username',$username);
                    $model->success('登录成功',U(Index/index));
                    return ;
                }else{
                    $model->error('用户名输入错误！！');
                }
            }else{
                $this->error('用户名输入错误！！');
            }
	}

	// 添加前
	protected function _before_insert(&$data, $option)
	{        
                $data['password']=  md5($data['password']);
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		if($data['password'])
			$data['password'] = md5($data['password']);
		else 
			unset($data['password']);   // 从表单中删除这个字段就不会修改这个字段了！！

                $rel = I('post.');
                $armodel = D('admin_role');
                foreach($rel['role_id'] as $k => $v){
                     $armodel->add(array(
                         'admin_id'=>$rel['id'],
                         'role_id'=>$v,
                     )); 
                 }
               
	}
	protected function _after_insert($data, $option)
	{
		$roleId = I('post.role_id');
		$arModel = D('admin_role');
		foreach ($roleId as $v)
		{
			$arModel->add(array(
				'admin_id' => $data['id'],
				'role_id' => $v,
			));
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
		if($option['where']['id'] == 1)
		{
			$this->error = '超级管理员无法删除！';
			return FALSE;
		}
		$arModel = D('admin_role');
		$arModel->where(array(
			'admin_id' => array('eq', $option['where']['id'])
		))->delete();
	}
	public function logout()
	{
		session(null);
	}
	/************************************ 其他方法 ********************************************/
}