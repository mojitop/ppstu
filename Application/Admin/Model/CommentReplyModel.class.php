<?php
namespace Admin\Model;
use Think\Model;
class CommentReplyModel extends Model 
{
	protected $insertFields = array('comment_id','content');
	// 添加和修改管理员时使用的表单验证规则
	protected $_validate = array(
                array('comment_id', 'require', '参数错误', 1,),
                array('content', '1,200', '回复评论的长度为1-200个字符！', 1, 'length', 3),
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
        }
        
}