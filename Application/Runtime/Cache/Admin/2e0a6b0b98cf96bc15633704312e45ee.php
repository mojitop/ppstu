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
    
    


<!-- 搜索 -->
<div class="form-div search_form_div">
    <form action="/Index.php/Admin/Admin/lst" method="GET" name="search_form">
		<p>
			用户名：
	   		<input type="text" name="username" size="30" value="<?php echo I('get.username'); ?>" />
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >用户名</th>
            <th >角色列表</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td align='center'><?php echo $v['username']; ?></td>
				<td align='center'><?php echo $v['id']==1?'超级管理员':$v['role_name']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a>
		        	<?php if($v['id'] > 1): ?>
		        	 |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
	                <?php endif; ?>
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>

<script>
</script>

<script src="/Public/Admin/Js/tron.js"></script>

<!---页尾 --->
<div id="footer">
共执行 456个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2017-2018 西院2013级--城乡规划--王桃，保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery-1.4.4.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>