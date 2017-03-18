<?php
namespace Admin\Model;
use Think\Model;
class UserlevelModel extends Model {
        //添加表单允许接受的字段
        protected $insertFields = 'level_name,jifen_bottom,jifen_top,id';
        protected $updateFields = 'level_name,jifen_bottom,jifen_top,id';
        //定义表单域规则
        protected $_validate = array(
            array('level_name','require','会员名称不能为空',1),
        );
        protected function _before_delete($option){
                $id = $option['where']['id'];
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












