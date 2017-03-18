<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MGSHOP 管理中心 -<?php echo $page_name;?>  </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $page_btn_target ;?>"><?php echo $page_btn_name ;?></a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $page_name ;?> </span>
    <div style="clear:both"></div>
</h1>
    
    


<!-- 列表 -->
<div class="list-div" id="listDiv">
    <form method="post" action="/index.php/Admin/Goods/goodsnum/id/75.html">
	<table cellpadding="3" cellspacing="1">
                <tr>
                    <?php foreach($_ga_data as $k =>$v): $cols = count($_ga_data)+2; $val_times = 0; ?>
                      <th><?php echo $k;?></th>
                    <?php endforeach;?>
                    <th width="200" >库存量</th>
                    <th width="100">操作</th>
                </tr>
                
                <?php if($gn_data):?>
                
		<?php foreach($gn_data as $gnk => $gnv): $ga_id=explode(',',$gnv['goods_attr_id']); ?>       
		<tr class="tron" >                   
                 <?php foreach ($_ga_data as $k => $v): ?>     
                        <td align='center'> 
                           <select name="goods_attr_id[]">
                            <?php foreach($v as $k1 => $v1): if( in_array($v1['id'],$ga_id ) ){ $sel = 'selected="selected"'; }else{ $sel=''; } ?>
                            <option <?php echo $sel;?> value="<?php echo $v1['id'];?>"><?php echo $v1['attr_value'];?></option>
                            <?php endforeach;?>
                            </select>
                       </td>
                <?php endforeach; ?>     
                <td align='center'><input type='text' name='goods_number[]' value="<?php echo$gnv['goods_number'];?>" title='请输入库存数量' /></td>
                <?php if($val_times ==0 ){ echo "<td align='center'><input class='set_val'type='button' onclick='addNewTr(event)' value='增加' /></td>"; $val_times++; }else{ echo "<td align='center'><input class='set_val'type='button' onclick='addNewTr(event)' value='删除' /></td>"; $val_times++; }?>
	        </tr>
                <?php endforeach;?>
                <?php else: ?>
                <tr><p><?php echo '天啦！！还没有设置商品库存量！！先去设置好商品属性再来吧！！~~~~(>_<)~~~~';?></p></tr>
		<tr class="tron" >                   
                 <?php foreach ($_ga_data as $k => $v): ?>     
                        <td align='center'> 
                           <select name="goods_attr_id[]">
                            <?php foreach($v as $k1 => $v1):?>
                                   <option <?php echo $sel;?> value="<?php echo $v1['id'];?>"> <?php echo $v1['attr_value'];?> </option>
                            <?php endforeach;?>
                            </select>
                       </td>
                <?php endforeach; ?>     
                <td align='center'><input type='text' name='goods_number[]' value="" title='请输入库存数量' /></td>

                    <td align='center'><input class='set_val'type='button' onclick='addNewTr(event)' value='增加' /></td>

	        </tr>
                <?php endif; ?>
                
                <tr id='submitTr'><td colspan="<?php echo $cols;?>"> <input type="submit" value="提交"/></td></tr>
	</table>
    </form>
</div>

<script type='text/javascript'>
   function addNewTr(evt){ 
      if( $(evt.target).val() == "增加" ){
          
           var tr =$(evt.target).parent().parent();
           var newTr = tr.clone(true);
           newTr.find('.set_val').val("删除");
           $('#submitTr').before(newTr);         
        }else{
            $(evt.target).parent().parent().remove();
        }

   }
</script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>

<!---页尾 --->
<div id="footer">
共执行 456个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2017-2018 西院2013级--城乡规划--王桃，保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery-1.4.4.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>