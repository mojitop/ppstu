<?php
namespace Home\Controller;

class IndexController extends NavController {
    public function getUserPri(){
         $goodsModel = D('Admin/goods');
         $goods_id = I('get.goods_id');
         $data = $goodsModel->ajaxGetPrice($goods_id);
         echo $data;
    }
    public function index(){
        $goodsModel = D('Admin/goods');
        $goods1 = $goodsModel->getProGoods();
        
        
        $goods2 = $goodsModel->getHBN('is_new');
        $goods3 = $goodsModel->getHBN('is_hot');
        $goods4 = $goodsModel->getHBN('is_best');
         //dump($goods1);die;
        $this->assign(array(
             'goods1'=>$goods1,
             'goods2'=>$goods2,
             'goods3'=>$goods3,
             'goods4'=>$goods4,
        ));
        //floor楼层推荐
        $cat_model = D('Admin/category');
        $floorData = $cat_model->getFloorData();
        
        $this->assign(array(
                'floorData'=>$floorData,
                '_show_nav'=>1,
                '_page_title'=>'首页',
                '_page_keywords'=>'首页',
                '_page_description'=>'首页',
        ));
           $this->display();
        }
    
     //商品详情页
    public function goods(){
        header('content-type:text/html;charset=utf-8;');
        $goods_id = I('get.id');
        $gmodel = D('Admin/goods');

        $gdata = $gmodel->where(array(
                    'id'=>array('eq',$goods_id),
                    'is_on_sale'=>array('eq','是'),
                    ))->find();
        $cid=$gdata['cat_id'];
        $catmodel = D('Admin/category');
        $cat_name = $catmodel->getPath($cid);
        $cat_name = array_reverse($cat_name);
        
        
        $conf = C('IMAGE_CONFIG');
        
        //取得商品属性信息
        $attrModel = D('Admin/attribute');
        $attr_data = $attrModel->alias('a')
                ->field('b.id goods_attr_id,b.attr_value,a.attr_name,a.attr_type,a.id attr_id')
                ->join('left join __GOODSATTR__ b on a.id=b.attr_id')
                ->where(array(
                 'b.goods_id'=>array('eq',$goods_id),
                 ))
                  ->select();
        //将取得属性按属性类型组成三维数组
        $uniAttr = array();
        $mulAttr = array();
        foreach($attr_data as $k => $v){
            if($v['attr_type'] == '可选'){
                $mulAttr[$v['attr_name']][]=$v;
            }else{
                $uniAttr[$v['attr_name']][]=$v;
            }
        }
        //取得goods_pic 信息
         $gpModel = D('Admin/goods_pic');
         $gpdata = $gpModel->where(array(
             'goods_id'=>array('eq',$goods_id),
         ))->select();
        //取得会员价格
         $upModel = D('Admin/userprice');
         $updata = $upModel->alias('a')
                 ->field('a.price,b.level_name')
                 ->join('left join __USERLEVEL__ b on a.level_id=b.id')
                 ->where(array(
             'goods_id'=>array('eq',$goods_id),
         ))->select();

        $this->assign(array(
                'updata'=>$updata ,
                'gpdata'=>$gpdata,
                'uniAttr'=>$uniAttr,
                'mulAttr'=>$mulAttr,
                'viewPath'=>$conf['viewPath'],
                'gdata' => $gdata,
                'cat_name' => $cat_name,
                '_show_nav'=>0,
                '_page_title'=>'商品详情页',
                '_page_keywords'=>'商品详情页',
                '_page_description'=>'商品详情页',
        ));
         $this->display();
        
    }
    public function display_history(){
                $id = I('get.id');
		// 先从COOKIE中取出浏览历史的ID数组
		$data = isset($_COOKIE['display_history']) ? unserialize($_COOKIE['display_history']) : array();
		// 把最新浏览的这件商品放到数组中的第一个位置上
		array_unshift($data, $id);
		// 去重
		$data =	array_unique($data);
		// 只取数组中前6个
                if(count($data) > 6){
                	$data = array_slice($data, 0, 6);    
                }
		// 数组存回COOKIE
		setcookie('display_history', serialize($data), time() + 30 * 86400, '/');
		// 再根据商品的ID取出商品的详细信息
		$goodsModel = D('Admin/goods');
               
		$data = implode(',', $data);
		$gData = $goodsModel->field('id,mid_logo,goods_name')->where(array(
			'id' => array('in', $data),
			'is_on_sale' => array('eq', '是'),
		))->order("FIELD(id,$data)")->select();
		echo json_encode($gData); 
    }
}
