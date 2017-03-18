<?php

namespace Home\Controller;
use Think\Controller;
class NavController extends Controller {
   public function __construct(){
        parent::__construct();
        //取出分类数据  分配
        $catModel = D('Admin/category');
        $catData = $catModel->getNavData();

        $this->assign('catData',$catData);
    }
}