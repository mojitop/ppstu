<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model 
{
	protected $insertFields = array('star','goods_id','content','yx_name');
	// 添加和修改管理员时使用的表单验证规则
	protected $_validate = array(
		array('star', '1,2,3,4,5', 'star的星值为1-5！', 1, 'in'),
                array('goods_id', 'require', '参数错误', 1,),
		array('content', '1,200', '评论的长度为1-200格字符！', 1, 'length', 3),
		// 第六个参数：规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
	);
        public function _before_insert(&$data,$option){
            $user_id = session('u_id');
            if(!$user_id){
                $this->error='请先登录.....';
                return false;
            }
            $data['addtime'] = date('Y-m-d H:i:s');
            $data['user_id'] = $user_id;
            //处理买家印象数据
            $yx_model = D('Admin/yinxiang');
            //处理印象——复选框
            $yx_ids = I('post.yx_id');
            if(!$yx_ids){
                return;
            }else{
                if(!empty($yx_ids)){
                     foreach($yx_ids as $k => $v){
                         $yx_model->where(array(
                                 'id'=>array('eq',$v),
                             ))->setInc('yx_count',1);
                     }
                 }
                 $yx_name = I('post.yx_name');
                 $yx_name = str_replace('，', ',', $yx_name);
                 $yx_name = trim($yx_name);
                 $yx_name = explode(',', $yx_name);
                 if(!empty($yx_name)){ 
                     foreach($yx_name as $k => $v){
                         if(!$v){
                            continue; 
                         }
                         $rel = $yx_model->where(array(
                             'goods_id'=>array('eq',$data['goods_id']),
                             'yx_name'=>array('eq',$v),
                         ))->find();
                            if($rel){
                                 $yx_model->where(array(
                                      'goods_id'=>array('eq',$data['goods_id']),
                                      'yx_name'=>array('eq',$v),
                                  ))->setInc('yx_count',1);
                                 continue;
                            }
                            if($v){
                                 $yx_model->add(array(
                                     'goods_id'=>$data['goods_id'],
                                     'yx_name'=>$v,
                                     'yx_count'=>1,
                                 )); 
                            }                       
                     }                
                 } 
            }


        }
        
        //评论及 回复 ajax 获取并翻页
        public function getCommentRaply($goods_id,$pageSize=6){           
            //set 翻页
            $count = $this->where(array(
                'goods_id' => array('eq',$goods_id),
            ))->count();
          
            $page_count = ceil($count/$pageSize);
            $data['page_count'] = $page_count;
            $page_cur = max(1,(int)I('get.p',1));
            $off = ($page_cur-1)*$pageSize;
            //取当前页数据
          
            if($page_cur == 1){
                //获取好评 中评 差评率
                $star = $this->field('star')->where(array(
                    'goods_id' => array('eq',$goods_id),
                ))->select();  
                $hao = 0;
                $zhong = 0;
                $cha = 0 ;
                foreach($star as $k => $v){
                    $star_num = $v['star'];
                    if($star_num > 3){
                       $hao++; 
                    }elseif($star_num == 3){
                        $zhong++;
                    }else{
                        $cha++;
                    }
                }
                $count_pl = $hao + $zhong +$cha;
                $data['hao'] = round($hao/$count_pl,2)*100;
                $data['zhong']= round($zhong/$count_pl,2)*100;
                $data['cha']= round($cha/$count_pl,2)*100;
            }

            $data['rel'] = $this->alias('a')->field('a.goods_id,a.id,a.content,a.addtime,a.star,a.click_count,b.username,b.face,count(c.comment_id) reply_count ')
                    ->join('left join __USER__ b on a.user_id=b.id
                            left join __COMMENT_REPLY__ c on a.id=c.comment_id')
                    ->group('a.id')
                    ->where(array(
                        'a.goods_id' => array('eq',$goods_id),   
                    ))
                    ->limit("$off,$pageSize")
                    ->order('a.addtime desc')
                    ->select();
            //获取评论数据
            $replyModel = D('comment_reply');
            foreach($data['rel'] as $k => &$v){
                $v['reply']=$replyModel->alias('a')->field('a.comment_id,a.content,a.addtime,b.face,b.username')
                        ->join('left join __USER__ b on a.user_id=b.id')
                        ->where(array(
                               'comment_id'=>array('eq',$v['id']),
                        ))->order('a.addtime desc')
                        ->limit(2)
                        ->select();
            }
            //获取买家印象数据
             $yx_model = D('Admin/yinxiang');
             $data['yx_data'] = $yx_model->field('id,yx_name,yx_count')->where(array(
                    'goods_id'=>array('eq',$goods_id),
                ))->limit(14)->order('yx_count desc')->select();
            return $data;
        }
}