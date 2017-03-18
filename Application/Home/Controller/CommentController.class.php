<?php
namespace Home\Controller;
use Think\Controller;

class CommentController extends Controller {
     
    public function add(){
        $commentModel = D('Admin/comment');
        if(IS_POST){
            if($commentModel->create(I('post.'),1)){
                if($id = $commentModel->add()){
                    $this->success(array(
                        'username'=>session('u_username'),
                        'face'=>session('face'),
                        'content'=>I('post.content'),
                        'star'=>I('post.star'),
                        'id'=>$id,
                        'addtime'=>date('Y-m-d H:i:s'),
                    ),'',true);
                }
            }
            $this->error($commentModel->getError(),'',true);
        }else{
            $this->error('非法访问！！',U('Index/index'),1);
        }
    }
    public function search(){
        $comModel = D('Admin/comment');
        $goods_id = I('get.id');
        $data = $comModel->getCommentRaply($goods_id);
        echo json_encode($data);
    }
    public function reply(){
        if(IS_POST){
            $commentReplyModel = D('Admin/comment_reply');
            if($commentReplyModel->create(I('post.'),1)){
                if($com_rep_id = $commentReplyModel->add()){
                    $this->success(array(
                        'username'=>session('u_username'),
                        'face'=>session('face'),
                        'content'=>I('post.content'),
                        'comment_id'=>I('post.comment_id'),
                        'addtime'=>date('Y-m-d H:i:s'),
                        'comment_reply_id'=>$com_rep_id,
                    ),'',true);
                }
            }
            $this->error($commentReplyModel->getError(),'',true);
        }
    }
    public function setYouYong(){
        $CommentModel = D('Admin/comment');
        if(IS_POST){
            $id = I('post.id');
            if($id){
                 if($CommentModel->where(array(
                       'id'=>array('eq',$id),
                    ))->setInc('click_count')){
                     $this->success('点赞成功，刷新查看！','',true);
                     return;
                 }
            }
            $this->error('点赞失败','',true);
        }
       
    }
}
