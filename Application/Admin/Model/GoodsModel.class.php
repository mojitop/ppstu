<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {
        //添加表单允许接受的字段
        protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,vip_price,cat_id,type_id.goods_attr_id,attr_value,promote_price,promote_start_date,promote_end_date,is_new,is_hot,is_best,is_floor,sort_num';
        protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,vip_price,cat_id,type_id,goods_attr_id,attr_value,promote_price,promote_start_date,promote_end_date,is_new,is_hot,is_best,is_floor,sort_num';
        //定义表单域规则
        protected $_validate = array(
        array('goods_name','require','商品名称不能为空',1),
        array('market_price','currency','必须为货币类型',1),
        array('shop_price','currency','必须为货币类型',1)
        
    );
        
       //根据积分计算会员价格 制作借口 ajaxGetPrice
        public function ajaxGetPrice($goods_id){
            
            //根据会员级别和goods_id 获取价格
            //判断条件：促销价     是否设置会员价格   是否登录   
                
            //本店价
            $shop_price = $this->field('shop_price')->find($goods_id);
            
            $jifen = session('u_jifen');
            
            //促销价 
            $today = date('Y-m-d H:i:s');
            $pro_price = $this->field('promote_price')->where(array( 
                        'id'=>array('eq',$goods_id),
                        'promote_price'=>array('gt',0),
                        'promote_start_date'=>array('elt',$today),
                        'promote_end_date'=>array('egt',$today),
                    ))->find();

            if(!$jifen){
                if($shop_price){
                      return  min($pro_price['promote_price'],$shop_price['shop_price']);   
                }else{
                      return $shop_price['shop_price'];
                }
              
            }

            
            //计算会员级别
            $ulModel = D('userlevel');
            $ulData = $ulModel->field('id,level_name')->where(array(
                                    'jifen_bottom'=>array('elt',$jifen),
                                    'jifen_top'=>array('egt',$jifen),
                              ))->find();
            
           
            //会员价
            $ulModel = D('userprice');
            $user_Data = $ulModel->field('price')->where(array(
                         'level_id'=>array('eq',$ulData['id']),
                         'goods_id'=>array('eq',$goods_id),
                  ))->find();

            if($user_Data){
                   if($pro_price){
                        $rel = min($pro_price['promote_price'],$user_Data['price']);
                        return min($rel,$shop_price['shop_price']);
                   }else{
                        return min($user_Data['price'],$shop_price['shop_price']);
                   }
                  
            }else{
                if($pro_price){
                    return  min($pro_price['promote_price'],$shop_price['shop_price']);
                }else{
                    return $shop_price['shop_price'];
                }
               
            }
        }
        
        
        protected function _before_delete($option){
    /***************删除商品之前 删除商品属性*********************/
                $goodsattr_model= D('goodsattr');
                $goods_id=$option['where']['id'];
                //where(array('goods_id' => array('eq',$goods_id)));
                $goodsattr_model->where("goods_id=$goods_id")->delete();
          
                $id = $option['where']['id'];
                $de_logo = $this->field("mbig_logo,big_logo,logo,mid_logo,sm_logo")->find($id);
                //删除旧图片delImage() return bool
                delImage($de_logo);
    /***************删除商品之前 删除商品扩展分类*********************/
                $goodscat_model= D('goodscat');
                $goods_id=$option['where']['id'];
                //where(array('goods_id' => array('eq',$goods_id)));
                $goodscat_model->where("goods_id=$goods_id")->delete();
    /***************删除商品之前 删除商品pic*********************/
                $gpModel = D('goods_pic');
                $goods_id=$option['where']['id'];
                $de_logo = $gpModel->field("pic,sm_pic,mid_pic,big_pic")->where("goods_id=$goods_id")->select();

                foreach($de_logo as $k => $v){
                    delImage($v);
                }
                $gpModel->where(array(
                            'goods_id'=>array('eq',$id),
                        ))->delete();

        }
        protected function  _before_insert(&$data,$option){
            //获取 即将要插入数据库中的数据 当前时间
            $data['addtime']=date('Y-m-d H:i:s',time());  
            //xss过滤
            $data['goods_desc'] = removeXSS($_POST['goods_desc']);
            //logo图片处理
            if($_FILES['logo']['error']==0){                
                    $upload = new \Think\Upload();// 实例化上传类  
                   
                    $upload->maxSize   = C('IMAGE_CONFIG')['maxSize'];// 设置附件上传大小    
                    $upload->exts      = C('IMAGE_CONFIG')['exts'];// 设置附件上传类型    
                    $upload->rootPath = C('IMAGE_CONFIG')['rootPath'];      //设置附件上传根目录    // 上传文件
                    $upload->savePath  = C('IMAGE_CONFIG')['savePath']; // 设置附件上传子目录    // 上传文件     
                    $info  = $upload->upload();
                    if(!$info) {// 上传错误提示错误信息        
                        $this->error = $upload->getError();
                        return false;
                    }else{
                            //上传成功   
                           $logo=$info['logo']['savepath'].$info['logo']['savename'];
                  
                           $image = new \Think\Image(); 
                           $image->open('./Public/Uploads/'.$logo);// 按照原图的比例生成一个最大为150*150的缩略图并保存

                           $mbig_logo = $info['logo']['savepath'].'mbig_logo_'.$info['logo']['savename'];
                           $mid_logo = $info['logo']['savepath'].'mid_logo_'.$info['logo']['savename'];
                           $big_logo= $info['logo']['savepath'].'big_logo_'.$info['logo']['savename'];
                           $sm_logo= $info['logo']['savepath'].'sm_logo_'.$info['logo']['savename'];

                           $image->thumb(700, 700)->save('./Public/Uploads/'.$mbig_logo);
                           $image->thumb(350, 350)->save('./Public/Uploads/'.$big_logo);
                           $image->thumb(130, 130)->save('./Public/Uploads/'.$mid_logo);
                           $image->thumb(50, 50)->save('./Public/Uploads/'.$sm_logo);
                           //吧路径放到data中，存入数据库
                           $data['logo']=$logo;
                           $data['mbig_logo']=$mbig_logo;
                           $data['big_logo']=$big_logo;
                           $data['mid_logo']=$mid_logo;
                           $data['sm_logo']=$sm_logo;
                           // $this->success('上传成功！');    
                 }
            }
        }
        protected function  _after_insert(&$data,$option){
                /***************添加商品后将图片路径添加到商品相册表中****************/
             $goods_id=$data['id']; 
             if(isset($_FILES['pic']))
		{
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v)
			{
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			$_FILES = $pics;  // 把处理好的数组赋给$_FILES，因为uploadOne函数是到$_FILES中找图片
			$gpModel = D('goods_pic');
			// 循环每个上传
			foreach ($pics as $k => $v)
			{
				if($v['error'] == 0)
				{
					$ret = uploadOne($k, 'Goods/pic', array(
						array(650, 650),
						array(350, 350),
						array(50, 50),
					));
					if($ret['ok'] == 1)
					{
						$gpModel->add(array(
							'pic' => $ret['images'][0],
							'big_pic' => $ret['images'][1],
							'mid_pic' => $ret['images'][2],
							'sm_pic' => $ret['images'][3],
							'goods_id' => $goods_id,
						));
					}
				}
			}
		}

         /***************接受并处理商品属性表信息****************/
            $attr_value = I('post.attr_value');
            $goods_attr_model = D('goodsattr');

            foreach($attr_value as $k => $v){
                $v = array_unique($v);  
                foreach ($v as $k1 => $v1){
                    $goods_attr_model->add(array(
                        'attr_value'=>$v1,
                        'goods_id'=>$goods_id,
                        'attr_id'=>$k,
                         )); 
                }
            }

            $vmodel = D('userprice');
            $vdata = I('post.vip_price');
            foreach ($vdata as $k=> $v) {
                $_v=(float)$v;
                if($_v){
                    $vmodel->add(array(
                      'price'=>$_v,
                        'level_id'=>$k,
                        'goods_id'=>$goods_id,
                    ));
                }
            }
           //插入扩展cat到表
           $ext_cat_model = D('goodscat');
           $ext_cat_id= I('post.ext_cat');
           if($ext_cat_id ){
                foreach($ext_cat_id as $k => $v){
                    if($v){
                      $ext_cat_model->add(array(
                          'cat_id'=>$v,
                          'goods_id'=>$goods_id,
                      )); 
                    }
                }
            }
        }
        protected function  _before_update(&$data,$option){
               $goods_id=$option['where']['id'];
               //修改之前设置字段 is_uptade 为 1
               $data['is_updated'] = 1;
               //在更新sphinx 中is_updated 的属性值
                require './sphinxapi.php';
                $sph = new \SphinxClient();
                $sph->setServer('localhost',9312);
                $sph->UpdateAttributes('goods',array('is_updated'),array($goods_id=>array(1)));
               //删除商品之前 删除扩展
                $goodscat_model= D('goodscat');
               
                //where(array('goods_id' => array('eq',$goods_id)));
                $goodscat_model->where("goods_id=$goods_id")->delete();
                //插入新数据到goodscat
                foreach( I('post.ext_cat') as $kc => $vc){
                    $goodscat_model->add(array(
                        'goods_id' => $goods_id,
                        'cat_id'=>$vc,
                    ));
                }
                
            $id=I('post.id');
            //获取 即将要插入数据库中的数据 当前时间
            $data['addtime']=date('Y-m-d H:i:s',time());  
            //xss过滤
            $data['goods_desc'] = removeXSS($_POST['goods_desc']);
            //logo图片处理
            if($_FILES['logo']['error']==0){                
                    $upload = new \Think\Upload();// 实例化上传类    
                    $upload->maxSize   = C('IMAGE_CONFIG')['maxSize'];// 设置附件上传大小    
                    $upload->exts      = C('IMAGE_CONFIG')['exts'];// 设置附件上传类型    
                    $upload->rootPath = C('IMAGE_CONFIG')['rootPath'];      //设置附件上传根目录    // 上传文件
                    $upload->savePath  = C('IMAGE_CONFIG')['savePath']; // 设置附件上传子目录    // 上传文件     
                    $info  = $upload->upload();
                    if(!$info) {// 上传错误提示错误信息        
                        $this->error = $upload->getError();
                        return false;
                    }else{
                            //上传成功   
                           $logo=$info['logo']['savepath'].$info['logo']['savename'];
                           $id = I('post.id');
                           $image = new \Think\Image(); 
                           $image->open('./Public/Uploads/'.$logo);// 按照原图的比例生成一个最大为150*150的缩略图并保存

                           $mbig_logo = $info['logo']['savepath'].'mbig_logo_'.$info['logo']['savename'];
                           $mid_logo = $info['logo']['savepath'].'mid_logo_'.$info['logo']['savename'];
                           $big_logo= $info['logo']['savepath'].'big_logo_'.$info['logo']['savename'];
                           $sm_logo= $info['logo']['savepath'].'sm_logo_'.$info['logo']['savename'];
                           
                           //删除旧路径
                           $de_logo = $this->field("mbig_logo,big_logo,logo,mid_logo,sm_logo")->find($id);
                           delImage($de_logo);
                           
                           $image->thumb(700, 700)->save('./Public/Uploads/'.$mbig_logo);
                           $image->thumb(350, 350)->save('./Public/Uploads/'.$big_logo);
                           $image->thumb(130, 130)->save('./Public/Uploads/'.$mid_logo);
                           $image->thumb(50, 50)->save('./Public/Uploads/'.$sm_logo);

                           //把路径放到data中，存入数据库
                           $data['logo']=$logo;
                           $data['mbig_logo']=$mbig_logo;
                           $data['big_logo']=$big_logo;
                           $data['mid_logo']=$mid_logo;
                           $data['sm_logo']=$sm_logo;
                           // $this->success('上传成功！');    
                 }
            }
            /************ 处理相册图片 *****************/
		if($_FILES['pic']['name'][0])
		{
			$gpModel = D('goods_pic');
                        $pics = array();
                        $de_logo = $gpModel->field("pic,sm_pic,mid_pic,big_pic")->where("goods_id=$id")->select();
                        foreach($de_logo as $k => $v){
                            delImage($v);
                        }
                        
                        $gpModel->where(array(
                            'goods_id'=>array('eq',$id),
                        ))->delete();
                        
			foreach ($_FILES['pic']['name'] as $k => $v)
			{
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			$_FILES = $pics;  // 把处理好的数组赋给$_FILES，因为uploadOne函数是到$_FILES中找图片
			// 循环每个上传
			foreach ($pics as $k => $v)
			{
				if($v['error'] == 0)
				{
					$ret = uploadOne($k, 'Goods/pic', array(
						array(650, 650),
						array(350, 350),
						array(50, 50),
					));
					if($ret['ok'] == 1)
					{
						$gpModel->add(array(
							'pic' => $ret['images'][0],
							'big_pic' => $ret['images'][1],
							'mid_pic' => $ret['images'][2],
							'sm_pic' => $ret['images'][3],
							'goods_id' => $id,
						));
					}
				}
			}
		}
        }
        protected function _after_uptade(&$data,$option){

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

            //根据分类搜索
            $cat_id = I('get.cat_id');
            if($cat_id){
                $id_data = $this->getGoodsIdByCat($cat_id); 
                $where['a.id']=array('in',$id_data); 
             
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
                    ->field('a.*,b.brand_name,c.cat_name,group_concat(e.cat_name separator "<br />") ext_cat_name')
                    ->join('left join __BRAND__ b on a.brand_id=b.id
                            left join __CATEGORY__ c on a.cat_id=c.id
                            left join __GOODSCAT__ d on a.id=d.goods_id
                            left join __CATEGORY__ e on d.cat_id=e.id')
                    ->group('a.id')
                    ->where($where)
                    ->limit($page->firstRow.','.$page->listRows)
                    ->select();
            return array(
                'list'=>$list,
                'page' => $show
            );
        }
        public function getGoodsIdByCat($cat_id){
            //① 取出主分类对应的goods ID和子ID
            $catmodel = D('Admin/category');
              //获得分类ID集
            $cat_ids = $catmodel->getchild($cat_id);
            //将主分类ID也放入其中
            $cat_ids[]=$cat_id;
            $g_where['cat_id']=array('in',$cat_ids);
            $gg_ids =$this->field('id')
                    ->where($g_where)
                    ->select();

            //②取出扩展ID对应的goodsID
            $goodscat_model = D('goodscat');
            $gc_where['cat_id']=array('in',$cat_ids);
            $cg_ids =$goodscat_model
                    ->field('DISTINCT goods_id id')
                    ->where($gc_where)
                    ->select();
            //③处理获得的两个二维数组  $gg_ids    $cg_ids
            //合并去重
            if($gg_ids && $cg_ids){
              $rel = array_merge($gg_ids,$cg_ids);
            }elseif($gg_ids){
                $rel = $gg_ids;
            }

             //二维数组  $rel 转成一维数组
              $_rel=array();
             foreach($rel as $k => $v){
                 if( !in_array($v['id'],$_rel) ){
                     $_rel[]=$v['id'];
                 }
             }
            return $_rel;

        }
        //获取疯狂抢购goods
        public function getProGoods($limit=5){
            
            $date = date('Y-m-d H:i:s');
            $goods1 = $this->field('id,goods_name,shop_price,promote_price,mid_logo')
                ->where(array(
                'is_on_sale'=>array('eq','是'),
                'promote_price'=>array('gt',0),
                'promote_start_date'=>array('elt',$date),
                'promote_end_date'=>array('egt',$date),
                ))
                ->order('sort_num asc')
                ->limit($limit)
                ->select();
            return $goods1;
        }
        //获取 is_hot  is_best  is_new
        public function getHBN($type,$limit=5){
            
            $goods1Data = $this->field('id,goods_name,shop_price,promote_price,mid_logo')
                ->where(array(
                'is_on_sale'=>array('eq','是'),
                 $type =>array('eq','是'),
                ))
                ->order('sort_num asc')
                ->limit($limit)
                ->select();
            return $goods1Data;
        }
        //前台search goods 展示：
        public function getGoodsByCat($cat_id,$pageSize=6){
            
            /**************************************** 搜索 ****************************************/
           
            $where = array();
            $goods_id = $this->getGoodsIdByCat($cat_id);        
            //$where['c.pay_status']=array('eq','是');
            //价格条件
            $price = I('get.price');
            if($price){
               $price=explode('--', $price);
               $min_price =$price[0];
               $max_price = $price[1];
               if($max_price){
                   $where['a.shop_price'] = array('egt',$min_price);
                   $where['a.shop_price'] = array('elt',$max_price);
               }else{
                    $where['a.shop_price'] = array('egt',$min_price);
               }
            }
            //品牌
            $brand = I('get.brand_id');
            if($brand){
               $brand=explode('-', $brand);
               $brand_id =$brand[0];
                $where['a.brand_id'] = array('eq',$brand_id);
            }
            /******属性搜索******/
            $gets = $_GET;
            $_goods_id=array();
            foreach($gets as $k => $v){
                if( strpos($k,'attr_') === 0 ){
                    $_attr_id = explode('_',$k);
                    $attr_id = $_attr_id[1];
                    $_attr_value = explode('_',$v);
                    $attr_value = $_attr_value[1];
                    $goodsAttrModel = D('Admin/goodsattr');
                    $_goods_id[] = $goodsAttrModel->field('goods_id')->where(array(
                                        'attr_id'=>array('eq',$attr_id),
                                        'attr_value'=>array('eq',$attr_value),
                                 ))->find();
                }
            } 
            if($_goods_id){
                $goods_id=array();
                foreach($_goods_id as $k => $v){
                    $goods_id[] =$v['goods_id']; 
                }
            }
            $where['a.id']=array('in',$goods_id);
           
            /************************************* 排序 ****************************************/
            $odby = 'xiao_liang';  //默认排序字段
            $odway = 'desc';       //默认排序方式
            $order = I('get.odby');
            if($order == 'xiao_liang'){
                $odway = 'desc';  
                $odby = 'xiao_liang';
            }
            if($order == 'addtime'){
                $odby = 'addtime';
            }
            if(strpos($order,'price_') === 0){
                $odby = 'shop_price';
                if($order == 'price_asc'){
                    $odway = 'asc';   
                }
            }
            /************************************* 翻页 ****************************************/
            $rel =$this->alias('a')
                  ->field('a.id')
                  ->join('left join __ORDER_GOODS__ b on (a.id=b.goods_id
                          and 
                          b.order_id in(select id from __ORDER__ WHERE pay_status="是"))')
                  ->where($where)
                  ->group('a.id')
                  ->select();
            $count = count($rel);
            foreach($rel as $k => $v){
                $data['goods_id'][] = $v['id'];
            }
            $page = new \Think\Page($count, $pageSize);
            // 配置翻页的样式
            $page->setConfig('prev', '上一页');
            $page->setConfig('next', '下一页');
            $data['page'] = $page->show();
            /************************************** 取数据 ******************************************/
            $data['goods_data'] = $this->alias('a')
                  ->field('a.goods_name,a.shop_price,a.mid_logo,a.id,sum(b.goods_number) xiao_liang')
                  ->join('left join __ORDER_GOODS__ b on (a.id=b.goods_id
                          and 
                          b.order_id in(select id from __ORDER__ WHERE pay_status="是"))')
                  ->where($where)
                  ->group('a.id')
                  ->order("$odby $odway")
                  ->limit($page->firstRow.','.$page->listRows)
                  ->select();
            return $data;
        }  
                /**************************根据商品计算搜索条件**************************/
        public function getSearchConditionByGoodsId($goods_ids){
            //dump($_SERVER);
            ////////////根据cat_id 查品牌
             $goodsModel = D('Admin/goods');
             //dump($goods_ids);
                    $rel['brand'] = $goodsModel->alias('a')->field('DISTINCT b.brand_name,b.id,b.logo')
                            ->join('left join __BRAND__ b on a.brand_id=b.id ')
                            ->where(array(
                            'a.id'=>array('in',$goods_ids),
                            'a.brand_id'=>array('neq',0),
                            'a.is_on_sale'=>array('eq','是'),
                            ))->order('a.sort_num asc')
                            ->select();
                    
                        /*******************价格筛选**********************/
                    $price_info = $goodsModel->field('max(shop_price) max_price,min(shop_price) min_price')->where(array(
                        'id'=>array('in',$goods_ids),
                    ))->select();
                    $length = 5;
             $max_price = $price_info['0']['max_price'];
             $min_price =0;
             $len = strlen(ceil($max_price));
             if($len == 1){
                 $_max_price=10;
                 $length = 1;
             }elseif($len == 2){
                 $_max_price = 100;
                 $length = 1;
             }elseif($len == 3){
                 $chu = 100;        
                 $_max_price =floor($max_price/$chu)*$chu;   
             }elseif($len == 4){
                 $chu = 1000;        
                 $_max_price =floor($max_price/$chu)*$chu;   
             }else{
                 $chu = 10000;        
                 $_max_price =floor($max_price/$chu)*$chu;   
             }
             $eq_cha = $_max_price/$length;
             for($i=0;$i<$length;$i++){
                 $link[] = $min_price.'--'.($min_price+$eq_cha-1);
                 $min_price = ($min_price+$eq_cha);
             }
             $link[] = $_max_price.'--';
             $rel['price'] = $link;
             /*****************属性的筛选************************/
             $goods_attr_model = D('Admin/goodsattr');
             $attr_data = $goods_attr_model->alias('a')
                     ->field('distinct(a.attr_value),a.attr_id,b.attr_name')
                     ->join('left join __ATTRIBUTE__ b on a.attr_id=b.id')
                     ->group('a.attr_value')
                     ->where(array(
                 'a.goods_id'=>array('in',$goods_ids),
             ))->select();
             foreach($attr_data as $k => $v){
                 $rel['attr'][$v['attr_name']][]=$v;
             }
             //dump($rel['attr']);
             //echo $goods_attr_model->getLastSql();
             //dump($rel['attr']);die;
             return $rel;
        }

        //      前台search goods 展示：
        public function getGoodsByKey($key,$pageSize=6){
            
            /**************************************** 搜索 ****************************************/
           /*********关键字************/
           //搜获sphinx
           header('content-type:text/html;charset=utf8;');        
            $where = array();   
            //开启sphinx查询
            $sphinx_star = 1;
            if($sphinx_star){
                require './sphinxapi.php';
                $sph = new \SphinxClient();
                $sph->setFilter('is_updated',array(0));
                $sph->setServer('localhost',9312);
                $rel = $sph->query($key,'goods');
                $goods_id = array_keys($rel['matches']);
            }else{
                $goods_id = $this->alias('a')
                        ->field('group_concat(distinct a.id) ids')
                        ->where(array(
                             'is_on_sale'=>array('eq','是'),
                             'a.goods_name'=>array('exp',"LIKE '%$key%' OR 'a.goods_desc' LIKE '%$key%'OR a.id IN(select goods_id from mgs_goodsattr where attr_value like '%$key%')"),
                         ))
                         ->find();
                $goods_id = explode(',', $goods_id['ids']);
            }
            //$where['c.pay_status']=array('eq','是');
            //价格条件
            $price = I('get.price');
            if($price){
               $price=explode('--', $price);
               $min_price =$price[0];
               $max_price = $price[1];
               if($max_price){
                   $where['a.shop_price'] = array('egt',$min_price);
                   $where['a.shop_price'] = array('elt',$max_price);
               }else{
                    $where['a.shop_price'] = array('egt',$min_price);
               }
            }
            //品牌
            $brand = I('get.brand_id');
            if($brand){
               $brand=explode('-', $brand);
               $brand_id =$brand[0];
                $where['a.brand_id'] = array('eq',$brand_id);
            }
            /******属性搜索******/
            $gets = $_GET;
            $_goods_id=array();
            foreach($gets as $k => $v){
                if( strpos($k,'attr_') === 0 ){
                    $_attr_id = explode('_',$k);
                    $attr_id = $_attr_id[1];
                    $_attr_value = explode('_',$v);
                    $attr_value = $_attr_value[1];
                    $goodsAttrModel = D('Admin/goodsattr');
                    $_goods_id[] = $goodsAttrModel->field('goods_id')->where(array(
                                        'attr_id'=>array('eq',$attr_id),
                                        'attr_value'=>array('eq',$attr_value),
                                 ))->find();
                }
            } 
            if($_goods_id){
                $goods_id=array();
                foreach($_goods_id as $k => $v){
                    $goods_id[] =$v['goods_id']; 
                }
            }
            $where['a.id']=array('in',$goods_id);
           
            /************************************* 排序 ****************************************/
            $odby = 'xiao_liang';  //默认排序字段
            $odway = 'desc';       //默认排序方式
            $order = I('get.odby');
            if($order == 'xiao_liang'){
                $odway = 'desc';  
                $odby = 'xiao_liang';
            }
            if($order == 'addtime'){
                $odby = 'addtime';
            }
            if(strpos($order,'price_') === 0){
                $odby = 'shop_price';
                if($order == 'price_asc'){
                    $odway = 'asc';   
                }
            }
            /************************************* 翻页 ****************************************/
                $rel =$this->alias('a')
                    ->field('a.id')
                    ->join('left join __ORDER_GOODS__ b on (a.id=b.goods_id
                            and 
                            b.order_id in(select id from __ORDER__ WHERE pay_status="是"))')
                    ->group('a.id')
                    ->where($where)
                    ->select();                 
            

            $count = count($rel);
            foreach($rel as $k => $v){
                $data['goods_id'][] = $v['id'];
            }
            $page = new \Think\Page($count, $pageSize);
            // 配置翻页的样式
            $page->setConfig('prev', '上一页');
            $page->setConfig('next', '下一页');
            $data['page'] = $page->show();
            /************************************** 取数据 ******************************************/
                  $data['goods_data'] = $this->alias('a')
                  ->field('a.goods_name,a.shop_price,a.mid_logo,a.id,sum(b.goods_number) xiao_liang')
                  ->join('left join __ORDER_GOODS__ b on (a.id=b.goods_id
                          and 
                          b.order_id in(select id from __ORDER__ WHERE pay_status="是"))')
                  ->where($where)
                  ->group('a.id')
                  ->order("$odby $odway")
                  ->limit($page->firstRow.','.$page->listRows)
                  ->select();                 
            
            $data['goods_data'] = $this->alias('a')
                  ->field('a.goods_name,a.shop_price,a.mid_logo,a.id,sum(b.goods_number) xiao_liang')
                  ->join('left join __ORDER_GOODS__ b on (a.id=b.goods_id
                          and 
                          b.order_id in(select id from __ORDER__ WHERE pay_status="是"))')
                  ->where($where)
                  ->group('a.id')
                  ->order("$odby $odway")
                  ->limit($page->firstRow.','.$page->listRows)
                  ->select();
            return $data;
        }  
}












