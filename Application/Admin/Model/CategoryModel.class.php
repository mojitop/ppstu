<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model {
        //添加表单允许接受的字段
        protected $insertFields = 'id,cat_name,parent_id,is_floor';
        protected $updateFields = 'id,cat_name,parent_id,is_floor';
        //定义表单域规则
        protected $_validate = array(
        array('cat_name','require','商品分类名称不能为空',1),
        
    );
        
         
        protected function _before_delete($option){
          
                $id = $option['where']['id'];
        }
        protected function _after_delete($option){
            $ids = $this->getchild($option['where']['id']);
            if($ids){
                $_ids = implode(',', $ids);
                $mod = new \Think\Model();
                $mod ->table('__CATEGORY__')-> delete($_ids);
            }
            
        }
        protected function  _before_insert(&$data,$option){
            
        }
        protected function  _after_insert(&$data,$option){
 
            
        }
        protected function  _before_update(&$data,$option){

        }
        protected function _after_uptade(&$data,$option){}
        //找一个分类的所有子分类
        public function getchild($catId){
          $data = $this->select();
          return $this->_getchild($data,$catId,true);
       }
       //递归获得所有子分类
        private function _getchild($data,$catId,$isClear=false){
            static $ids =array();
            if($isClear){
                $ids = array();
            }
            foreach ($data  as $k => $v) {
                if($v['parent_id'] == $catId ){
                    $ids[]=$v['id'];
                    $this->_getchild($data,$v['id']);
                }
            }
            return $ids;
        }
        //获取树形图
        public function gettree(){
            $data = $this->select();
            return $this-> _gettree($data);
        }
        private function _gettree($data,$parent_id=0,$level=0){
            static $idl = array();
            foreach ($data as $k => $v) {
                if($v['parent_id'] == $parent_id){
                    $v['level'] = $level;
                    $idl[] = $v;
                    $this->_gettree($data,$v['id'],$level+1);
                }
            }
            return $idl;
        }
        public function getNavData(){
            $catData = S('catData');
            if(!$catData){
                //获取nav导航数据
                $rel = array();
                $data = $this->select();
                foreach($data as $k => $v){
                    if($v['parent_id'] == 0){
                        foreach($data as $k1 =>$v1){
                            if($v1['parent_id'] == $v['id']){
                                foreach($data as $k2 =>$v2){
                                      if($v2['parent_id'] == $v1['id']){
                                          $v1['children'][]=$v2;
                                      }
                                }
                                $v['children'][] = $v1;
                            }
                            
                        }
                        $rel[]=$v;
                    }
                }
                S('catData',$rel,86400);
                return $rel;
            }else{
                return $catData;
            }
        }
        public function getFloorData(){
            $floorData = S('floorData');
            $goodsModel = D('Admin/goods');
            if(!$floorData){
                //取得floor一层分类
                $catModel = D('category');
                $floor1 = $catModel->where(array(
                        'parent_id'=>array('eq',0),
                        'is_floor' => array('eq','是'),
                        ))
                        ->select();
                
               

                //定义一个空数组保存取得的数据
                $rel = array();
                foreach($floor1 as $k => $v){
                        //取得品牌
                        $goods_ids = $goodsModel->getGoodsIdByCat($v['id']);
                        $rel[$k]['brand'] = $goodsModel->alias('a')->field('DISTINCT b.brand_name,b.id,b.logo')
                                ->join('left join __BRAND__ b on a.brand_id=b.id ')
                                ->limit(9)
                                ->where(array(
                                'a.id'=>array('in',$goods_ids),
                                'a.brand_id'=>array('neq',0),
                                'a.is_on_sale'=>array('eq','是'),
                                'is_floor'=>array('eq','是'),
                              ))->order('a.sort_num asc')
                                ->select();
                        
                         //取得顶级分类下未被推荐的二级分类        
                        $floorN = $floor2 = $catModel->where(array(
                            'parent_id'=>array('eq',$v['id']),
                            'is_floor' => array('eq','否'),
                            ))
                            ->select();
                        $rel[$k]['cat_name'] = $v['cat_name'];
                        $rel[$k]['subCat_floorN'] = $floorN ;
                        //取得顶级分类下被推荐的二级分类
                         $floorY = $floor2 = $catModel->limit(5)
                                 ->where(array(
                            'parent_id'=>array('eq',$v['id']),
                            'is_floor' => array('eq','是'),
                            ))
                            ->select();
                         $rel[$k]['subCat_floorY'] = $floorY; 
                         
                         //取得被推荐的二级分类下的推荐到楼层的商品
                         foreach($floorY as $k1 => $v1){
                            $goodsId = $goodsModel->getGoodsIdByCat($v1['id']);
                            $goods_data = $goodsModel->limit(8)->field('goods_name,mid_logo,shop_price,id')
                                    ->where(array(
                                       'is_on_sale'=>array('eq','是'),
                                       'is_floor'=>array('eq','是'),
                                       'id '=> array('in',$goodsId),
                                    ))->order('sort_num asc')
                                    ->select();
                            //降取得的商品信息保存到二级分类下的goods下
                             $rel[$k][subCat_floorY][$k1]['goods'] = $goods_data;
                         }
                }
                 S('floorData',$rel,86400);
                return $floorData = $rel;
              
            }else{
                return $floorData;
            }
        }
        
            public function getPath($cat_id){
                static $cat_name = array();
                $data = $this->field('id,cat_name,parent_id')->where(array(
                     'id'=>array('eq',$cat_id)   
                        ))->find();
                $cat_name[] = $data['cat_name'];
                if($data['parent_id'] > 0){
                    $this->getPath($data['parent_id']);
                }
                return $cat_name;
        }

}












