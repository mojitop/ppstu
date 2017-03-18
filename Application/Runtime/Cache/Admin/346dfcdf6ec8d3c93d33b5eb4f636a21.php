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
    
    


<style type='text/css'>
    #ext_cat{margin:0px; padding-left:0px;}
    ul li{list-style: none;}
    #attr_list{margin-left:0px;padding-left:5px;margin-top:5px;}
</style>
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/Index.php/Admin/Goods/add" method="post">
            <table width="90%" id="general-table" align="center">
                
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" />
                    <span class="require-field">*</span></td>
                </tr
                <tr>
                    <td class="label">商品属性：</td>
                    <td>
                        <?php buildSelect('type','type_id','id','type_name'); ?> 
                        <ul id="attr_list"></ul>
                    </td>
                </tr>
                
              <tr>
                <td class="label">选择分类：</td>
                <td>
                   <select name="cat_id">    
                     <option value="0" >顶级分类</option>
                     <?php foreach($catdata as $k => $v):?>  
                       
                     <option value="<?php echo $v['id']; ?>"  > <?php echo str_repeat('>',6*$v['level']).$v['cat_name'];?> </option>
                     <?php endforeach; ?>
                  </select>               
                </td>
                </tr>
              <tr>
                    <td class="label">扩展分类：</td>
                    <td>
                        <input type="button" value='添加分类' onclick='add()'>
                       <ul id='ext_cat'>
                           <li id='ext_li'>
                                <select name="ext_cat[]"> 
                                  <option value="0" >顶级分类</option>
                                  <?php foreach($catdata as $k => $v):?>  
                                  <option value="<?php echo $v['id']; ?>"  > <?php echo str_repeat('>',6*$v['level']).$v['cat_name'];?> </option>
                                  <?php endforeach; ?>
                               </select> 
                               <input type="button" value='删除'onclick='remove(event)'> 
                           </li>
                       </ul>
                    </td>
                </tr>
                
                <tr>
                    <td class="label">所属品牌：</td>
                    <td>
                        <?php buildSelect('brand','brand_id','id','brand_name'); ?> 
                    </td>
                </tr>
               
                <tr>
                    <td class="label">LOGO：</td>
                    <td><input type="file" name="logo" size="60" /></td>
                </tr>
                <!-- 商品相册 -->
                <tr>
                    <td class="label">商品相册：</td>                  
                    <td id="add_pic">
                        <p ><input type="file" name="pic[]" size="60" value="" /><input  type="button" value="重置" onclick="remove_pic(this)" /><input  type="button" value="增加" onclick="add_pic(this)"/></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                  <tr>
                    <td class="label">促销时间：</td>
                    <td>
                       开始： <input type="text" id="promote_start_date"  name="promote_start_date" value=""  /> 
                       结束： <input type="text" id="promote_end_date"    name="promote_end_date" value=""  /> 
                    </td>
                </tr>
                <tr>
                    <td class="label">促销价格：</td>
                    <td>
                        <input type="text" name="promote_price" value="0"  /> 
                        <span class="require-field">默认为零不促销</span>      
                    </td>
                </tr>
                
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="checked" /> 是
                        <input type="radio" name="is_on_sale" value="否" /> 否
                    </td>
                </tr>
                 <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="是"  checked="checked"/> 是
                        <input type="radio" name="is_new" value="否" /> 否
                    </td>
                </tr>
                 <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="是"  /> 是
                        <input type="radio" name="is_hot" value="否" checked="checked"/> 否
                    </td>
                </tr>
                 <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="是"  /> 是
                        <input type="radio" name="is_best" value="否" checked="checked"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐到楼层：</td>
                    <td>
                        <input type="radio" name="is_floor" value="是" /> 是
                        <input type="radio" name="is_floor" value="否" checked="checked" /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">排序权重：</td>
                    <td>
                        <input type="text" name="sort_num" value="100"  size="8"/>  
                        <span class="require-field">0--255</span>      
                    </td>
                </tr>
                <?php foreach($vdata as $k => $v): ?>
                 <tr>
                    <td class="label"><?php echo $v[level_name]; ?>售价：</td>
                    <td>
                        <input type="text" name="vip_price[<?php echo $v['id']; ?>]" value="0" size="12"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <?php endforeach;?>
                
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"></textarea>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>


//导入时间插件
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
    $("#promote_start_date").datetimepicker();
    $("#promote_end_date").datetimepicker();
</script>

<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script>
UM.getEditor('goods_desc', {
	initialFrameWidth : "80%",
	initialFrameHeight : 350
});
</script>
<script type='text/javascript'>
    var num=0;
    function add(){
        var fu_li = $('#ext_li').clone(true);
        $('#ext_cat').append(fu_li);

    }
    function remove(evt){
         var num =$('#ext_cat li');
         if(num.length > 1){
             $(evt.target).parent().remove();
         }
    }
// 选择类型获取属性的AJAX
$("select[name=type_id]").change(function(){
	// 获取当前选中的类型的id
	var typeId = $(this).val();
	// 如果选择了一个类型就执行AJAX取属性
	if(typeId > 0)
	{
		// 根据类型ID执行AJAX取出这个类型下的属性，并获取返回的JSON数据
		$.ajax({
			type : "GET",
			url : "<?php echo U('ajaxGetAttr', '', FALSE); ?>/type_id/"+typeId,
			dataType : "json",
			success : function(data)
			{
				/** 把服务器返回的属性循环拼成一个LI字符串，并显示在页面中 **/
				var li = "";
				// 循环每个属性
				$(data).each(function(k,v){
					li += '<li>';
					
					// 如果这个属性类型是可选的就有一个+
					if(v.attr_type == '可选')
						li += '<a onclick="addNewAttr(this);" href="#">[+]</a>';
					// 属性名称
					li += v.attr_name + ' : ';	
					// 如果属性有可选值就做下拉框，否则做文本框
					if(v.attr_option_values == "")
						li += '<input type="text" name="attr_value['+v.id+'][]" />';
					else
					{
						li += '<select name="attr_value['+v.id+'][]"><option value="">请选择...</option>';
						// 把可选值根据,转化成数组
						var _attr = v.attr_option_values.split(',');
						// 循环每个值制作option
						for(var i=0; i<_attr.length; i++)
						{
							li += '<option value="'+_attr[i]+'">';
							li += _attr[i];
							li += '</option>';
						}
						li += '</select>';
					}
						
					li += '</li>'
				});
				// 把拼好的LI放到 页面中
				$("#attr_list").html(li);
			}
		});
	}
	else
		$("#attr_list").html("");  // 如果选的是请 选择就直接清空
});

// 点击属性的+号
function addNewAttr(a)
{
	// $(a)  --> 把a转换成jquery中的对象，然后才能调用jquery中的方法
	// 先获取所在的li
	var li = $(a).parent();
	if($(a).text() == '[+]')
	{
		var newLi = li.clone();
		// +变-
		newLi.find("a").text('[-]');
		// 新的放在li后面
		li.after(newLi);
	}
	else
		li.remove();
}
//相册处理
function add_pic(a){
    if($(a).val() == '增加'){
        var p = $(a).parent();
        var new_p = p.clone(true);
        new_p.find("input:eq(2)").val('删除');
        new_p.find("input:eq(0)").attr('value','');
        //p的父节点所在tr
        $('#add_pic').append(new_p);
    }else{
      $(a).parent().remove();
    }
}
function remove_pic(a){
    $(a).parent().find('input:eq(0)').val('');
}
</script>

























<!---页尾 --->
<div id="footer">
共执行 456个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2017-2018 西院2013级--城乡规划--王桃，保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery-1.4.4.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>