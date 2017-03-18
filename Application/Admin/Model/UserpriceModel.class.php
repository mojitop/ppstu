<?php
namespace Admin\Model;
use Think\Model;
class UserpriceModel extends Model {
        //添加表单允许接受的字段
        protected $insertFields = 'level_id,price,vip_price';
        protected $updateFields = 'level_id,price,vip_price';
        //定义表单域规则
        protected $_validate = array(
        array('goods_name','require','商品名称不能为空',1),
        array('market_price','currency','必须为货币类型',1),
        array('shop_price','currency','必须为货币类型',1)
        
    );
        
        //实现翻页  
        protected function _before_delete($option){
          
                $id = $option['where']['id'];
         }
        protected function  _before_insert(&$data,$option){
            //获取 即将要插入数据库中的数据 当前时间


        }
        protected function  _after_insert(&$data,$option){

        }
        protected function  _before_update(&$data,$option){
            $id=I('post.id');
              
             
        }
        
        public function search($perpage=15){
            
            //搜索功能实现
            
            $where = array();
            $gn=I('get.gn');
            if($gn){
                $where['goods_name']=array('like',"%$gn%");
            }
            
            $lp = I('get.lp');
            $gp = I('get.gp');
            IF($lp && $gp){
                $where['shop_price'] = array('between',array($lp,$gp));
            }else if(isset($lp)){
                $where['shop_price'] = array('egt',$lp);//shop_price >=
            }else{
                 $where['shop_price'] = array('elt',$gp);//shop_price <=
            }
            
            $sl = I('get.sl');
            if($sl){
                $where['is_on_sale'] = array('eq','$sl');
            }
            
            $lt= I('get.lt');
            $gt = I('get.gt');
            IF($lp && $gp){
                $where['addtime'] = array('between',array($lt,$gt));
            }else if(isset($lp)){
                $where['addtime'] = array('egt',$lt);//shop_price >=
            }else{
                 $where['addtime'] = array('elt',$gt);//shop_price <=
            }
            
            $odby = I('get.odby');
            //默认排序ID desc 
            $orderby = "a.id";
            $orderway = "desc";
            if($odby=='id_desc'){
                $orderby = "a.id";
                $orderway = "desc";
            }
            
            if($odby=='id_asc'){
                $orderby = "a.id";
                $orderway="asc";
            }
            if($odby=='price_desc'){
               $orderby = "a.shop_price";
               $orderway = "desc";
            }
            if($odby=='price_asc'){
               $orderby = "a.shop_price";
               $orderway = "asc";                
            }
      
        
            $count =$this->where($where)->count();
            $page = new \Think\Page($count,$perpage);
            $page->setConfig('next','下一页');
            $page->setConfig('prev','上一页');
            //生成翻页的字符串 上一页==
            $show = $page->show();

            //取数据
            $list = $this->order("$orderby $orderway")
                    ->alias('a')
                    ->field('a.*,b.brand_name')
                    ->join('left join __BRAND__ b on a.brand_id=b.id')
                    ->where($where)
                    ->limit($page->firstRow.','.$page->listRows)
                    ->select();
            return array(
                'list'=>$list,
                'page' => $show
            );
        }
}












