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
    
    


<div class="form-div">
    <form action="/index.php/Admin/Goods/lst" name="searchForm" method="get">

        <!-- 分类 -->
          <!-- 
        <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <select name="cat_id">
            <option value="0">所有分类</option>
            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<<?php echo ($val["cat_id"]); ?>>"><<?php echo (str_repeat('&nbsp;&nbsp;',$val["lev"])); ?>><<?php echo ($val["cat_name"]); ?>></option><?php endforeach; endif; ?>
        </select>
        <!-- 品牌 -->
        <!--
        <select name="brand_id">
            <option value="0">所有品牌</option>
            <?php if(is_array($brand_list)): foreach($brand_list as $key=>$val): ?><option value="<<?php echo ($val["brand_id"]); ?>>"><<?php echo ($val["brand_name"]); ?>></option><?php endforeach; endif; ?>
        </select>
        <!-- 推荐 -->
          <!--
        <select name="intro_type">
            <option value="0">全部</option>
            <option value="is_best">精品</option>
            <option value="is_new">新品</option>
            <option value="is_hot">热销</option>
        </select>
        <!-- 上架 -->
          <!--
        <select name="is_on_sale">
            <option value=''>全部</option>
            <option value="1">上架</option>
            <option value="0">下架</option>
        </select>
        <!-- 关键字 -->
        <!--          关键字 <input type="text" name="keyword" size="15" /><br />     -->
    
        <p> 商品名称：<input size='22' value="<?php echo I('get.gn');?>" type="text" name='gn'/></p>
        
         <p> 分类名称：
                   <select name="cat_id">   
                     <?php $_id=I('get.cat_id'); ;?>
                     <option  value='' >选择分类</option>
                     <?php foreach($catdata as $k => $v): if($_id == $v['id']){ $sel = 'selected="selected"'; }else{ $sel =''; } ?>  
                       
                     <option  <?php echo $sel; ?>value="<?php echo $v['id']; ?>"  > <?php echo str_repeat('>',6*$v['level']).$v['cat_name'];?> </option>
                     <?php endforeach; ?>
                  </select>  
                 </p>
        <p>        
        价格：从<input value="<?php echo I('get.lp');?>" type="text" name='lp'size="8"/>
        到<input value="<?php echo I('get.gp');?>" type="text" name='gp' size='8'/>
        <?php $sl=I('get.sl');;?>
        是否上架：全部<input  type="radio" name='sl' value='' <?php if($sl==""){echo "checked=checked";} ?> />
                 是<input  type="radio" name='sl' value='是'<?php if($sl=="是"){echo "checked=checked";} ?> /> 
                 否<input  type="radio" name='sl' value='否'<?php if($sl=="否"){echo "checked=checked";} ?> />
        添加时间：从<input  type="text" id="LT" name='lt' value="<?php echo I('get.lt');?>" />
                 到<input  type="text" id="GT" name='gt'value="<?php echo I('get.gt');?>" />
        </p>
        <?php $odby = I('get.odby')?>
        排序方式： 按时间降序:<input onclick = "this.parentNode.submit();" type="radio" name='odby' value='id_desc' <?php if($odby=="id_desc"){echo "checked=checked";} ?> /></input>
                  按时间升序:<input onclick = "this.parentNode.submit();" type="radio" name='odby' value='id_asc' <?php if($odby=="id_asc"){echo "checked=checked";} ?> /></input>
                  本店价格降序:<input onclick = "this.parentNode.submit();" type="radio" name='odby' value='price_desc' <?php if($odby=="price_desc"){echo "checked=checked";} ?> /></input>
                  本店价格升序:<input onclick = "this.parentNode.submit();"  type="radio" name='odby' value='price_asc' <?php if($odby=="price_asc"){echo "checked=checked";} ?> /></input>
        <p> <input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>主分类名称</th>
                <th>扩展分类名称</th>
                <th>品牌</th>
                <th>商品名称</th>
                <th>logo</th>
                <th>本店价格</th>
                <th>市场价格</th>
                <th>上架</th>
                <th>最后修改时间</th>
                <th>操作</th>
            </tr>
         
            <?php foreach($list as $key => $val): ?>
            <tr class="tron">
                <td align="center"><?php echo $val['id'];?></td>
                <td align="center"><?php echo $val['cat_name'];?></td>
                <td align="center"><?php echo $val['ext_cat_name'];?></td>
                <td align="center"><?php echo $val['brand_name'];?></td>
                <td align="center" class="first-cell"><span><?php echo $val['goods_name'];?></span></td>
                <td align="center"><span onclick=""><?php if($val['sm_logo']){showImage($val['sm_logo']);}else{ echo '暂无logo';}?></span></td>
                <td align="center"><span><?php echo $val['shop_price'];?></span></td>
                <td align="center"><?php echo $val['market_price'];?></td>
                <td align="center"><?php echo $val['is_on_sale'];?></td>
                <td align="center"><?php echo $val['addtime'];?></td>
                <td align="center">
                    <a href="<?php echo U('goodsnum'.'?id='.$val[id]); ?>">库存</a>
                    <a href="<?php echo U('edit'.'?id='.$val[id]); ?>">修改</a>
                    <a onclick="return window.confirm('确认要删除吗？')"  href="<?php echo U('del'.'?id='.$val[id]); ?>" >删除</a>
                </td>
            </tr>
             <?php endforeach; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $page;?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>


<!---导入时间插件--->
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
    //$("#LT").datetimepicker({ dateFormat: "yy-mm-dd" });
    $("#LT").datetimepicker();
    $("#GT").datetimepicker();
</script>


<!---页尾 --->
<div id="footer">
共执行 456个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2017-2018 西院2013级--城乡规划--王桃，保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery-1.4.4.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>