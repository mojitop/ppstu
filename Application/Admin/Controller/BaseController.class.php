<?php

namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller  
{
  public function __construct(){
      parent::__construct();
      if(!session('id')){
          $this->error('必须先登录！！',U('Login/login'));
      }
      $pri_model = D('privilege');
      $link = $pri_model->checkpri();
      if(CONTROLLER_NAME == 'Index'){
          return true;
      }
      if(!$link){
          $this->error('没有权限访问！！！','',1);
      }
  
  }
  
}