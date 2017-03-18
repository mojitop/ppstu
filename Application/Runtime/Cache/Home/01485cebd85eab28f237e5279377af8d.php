<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="keywords" content="<?php echo $_page_keywords;?>"/>
        <meta name="description" content="<?php echo $_page_description;?>"/>
	<title><?php echo $_page_title;?></title>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">	
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">
        <link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
        <link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">   
       	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/Public/Home/js/header.js"></script>
     
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li id="loginfo"></li>
					<li class="line">|</li>
                                        <li><a href='<?php echo U("Myself/index");?>' >我的订单</a></li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
        


<link rel="stylesheet" href="/Public/Home/style/common.css" type="text/css">
<link rel="stylesheet" href="/Public/Home/style/list.css" type="text/css">
<script type="text/javascript" src="/Public/Home/js/list.js"></script>
	
<!-- 头部 start -->
	<div class="header w1210 bc mt15">
		<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
		<div class="logo w1210">
			<h1 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h1>
			<!-- 头部搜索 start -->
			<div class="search fl">
				<div class="search_form">
					<div class="form_left fl"></div>
					<form action="" name="key" method="get" class="fl">
                                            <input id='key_words' type="text" name="key" class="txt" value="<?php echo I('get.key',请输入商品关键字);?>" />
                                                <input type="button" onclick="search()" class="btn" value="搜索" />
					</form>
					<div class="form_right fl"></div>
				</div>
				
				<div style="clear:both;"></div>

				<div class="hot_search">
					<strong>热门搜索:</strong>
					<a href="">D-Link无线路由</a>
					<a href="">休闲男鞋</a>
					<a href="">TCL空调</a>
					<a href="">耐克篮球鞋</a>
				</div>
			</div>
			<!-- 头部搜索 end -->

			<!-- 用户中心 start-->
			<div class="user fl">
				<dl>
					<dt>
						<em></em>
						<a href="">用户中心</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
                                                    您好，请<a href="<?php echo U('User/login');?>">登录</a>
						</div>
						<div class="uclist mt10">
							<ul class="list1 fl">
								<li><a href="">用户信息></a></li>
								<li><a href="">我的订单></a></li>
								<li><a href="">收货地址></a></li>
								<li><a href="">我的收藏></a></li>
							</ul>

							<ul class="fl">
								<li><a href="">我的留言></a></li>
								<li><a href="">我的红包></a></li>
								<li><a href="">我的评论></a></li>
								<li><a href="">资金管理></a></li>
							</ul>

						</div>
						<div style="clear:both;"></div>
						<div class="viewlist mt10">
							<h3>最近浏览的商品：</h3>
							<ul>
								<li><a href=""><img src="/Public/Home/images/view_list1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/Public/Home/images/view_list2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/Public/Home/images/view_list3.jpg" alt="" /></a></li>
							</ul>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 用户中心 end-->

			<!-- 购物车 start -->
			<div class="cart fl">
				<dl>
					<dt>
                                        <a href="<?php echo U('Cart/cartLst');?>" id='show_cart_list'>去购物车结算</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt" id='show_cart'>
							<img src='/Public/Home/images/loading.gif' width='350'/>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 购物车 end -->
		</div>
		<!-- 头部上半部分 end -->
		
		<div style="clear:both;"></div>

		<!-- 导航条部分 start -->
		<div class="nav w1210 bc mt10">
			<!--  商品分类部分 start-->
			<div class="category fl <?php if($_show_nav == 0){echo ' cat1';}?>">
				<div class="cat_hd <?php if($_show_nav == 0){echo 'off';}?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，并将cat_bd设置为不显示(加上类none即可)，鼠标滑过时展开菜单则将off类换成on类 -->
					<h2>全部商品分类</h2>
					<em></em>
				</div>
				
				<div class="cat_bd <?php if($_show_nav == 0) echo 'none'; ?>"> 
					<!-- 循环输出三层分类数据 -->
					<?php foreach ($catData as $k => $v): ?>
					<div class="cat <?php if($k==0) echo 'item1'; ?>">
                                            <h3><a href="<?php echo U('Search/cat_search?cat_id='.$v['id'],'',false);?>"><?php echo $v['cat_name'];?></a> <b></b></h3>
						<div class="cat_detail none">
							<?php foreach ($v['children'] as $k1 => $v1): ?>
							<dl <?php if($k1==0) echo 'class="dl_1st"'; ?>>
								<dt><a href="<?php echo U('Search/cat_search?cat_id='.$v1['id'],'',false);?>"><?php echo $v1['cat_name'];?></a></dt>
								<dd>
									<?php foreach ($v1['children'] as $k2 => $v2): ?>
									<a href="<?php echo U('Search/cat_search?cat_id='.$v2['id'],'',false);?>"><?php echo $v2['cat_name'];?></a>
									<?php endforeach; ?>					
								</dd>
							</dl>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

			</div>
			<!--  商品分类部分 end--> 
		

			<div class="navitems fl">
				<ul class="fl">
					<li class="current"><a href="">首页</a></li>
					<li><a href="">电脑频道</a></li>
					<li><a href="">家用电器</a></li>
					<li><a href="">品牌大全</a></li>
					<li><a href="">团购</a></li>
					<li><a href="">积分商城</a></li>
					<li><a href="">夺宝奇兵</a></li>
				</ul>
				<div class="right_corner fl"></div>
			</div>
		</div>
		<!-- 导航条部分 end -->
	</div>
	<!-- 头部 end-->

	<div style="clear:both;"></div>
<script>
$('#show_cart_list').mouseover(function(){
    var view ="<?php $view =C('IMAGE_CONFIG');echo $view['viewPath'];?>";
    $.ajax({
        type:'get',
        url:"<?php echo U('Cart/ajax_get_cart_list');?>",
        dataType:'json',
        success:function(data){           
                var html = '';
                html += "<html >";
                html+="<table bgcolor='#A0B3BC' width='200' height='300'>";          
            $(data).each(function(k,v){

                html +="<tr>";
                html +="<td><img width='60' align='center' height='60' src='"+view+v.mid_logo+"'/></td>";
                html += "<td><font size='2' color='red'>"+v.goods_name+"</font></td>";
                html +="</tr>";
            });
                html+="</table>";
                html += "</html>";
                $('#show_cart').html(html);
        }
    });
});
function search(){
    window.location.href="<?php echo U('Search/key_search','',false);?>"+"/key/"+$('#key_words').val();
}
</script>	

	<div style="clear:both;"></div>

	<!-- 列表主体 start -->
	<div class="list w1210 bc mt10">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2>当前位置：<a href="">首页</a> > <a href="">电脑、办公</a></h2>
		</div>
		<!-- 面包屑导航 end -->

		<!-- 左侧内容 start -->
		<div class="list_left fl mt10">
			<!-- 分类列表 start -->
			<div class="catlist">
				<h2>电脑、办公</h2>
				<div class="catlist_wrap">
					<div class="child">
						<h3 class="on"><b></b>电脑整机</h3>
						<ul>
							<li><a href="">笔记本</a></li>
							<li><a href="">超极本</a></li>
							<li><a href="">平板电脑</a></li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>电脑配件</h3>
						<ul class="none">
							<li><a href="">CPU</a></li>
							<li><a href="">主板</a></li>
							<li><a href="">显卡</a></li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>办公打印</h3>
						<ul class="none">
							<li><a href="">打印机</a></li>
							<li><a href="">一体机</a></li>
							<li><a href="">投影机</a></li>
							</li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>网络产品</h3>
						<ul class="none">
							<li><a href="">路由器</a></li>
							<li><a href="">网卡</a></li>
							<li><a href="">交换机</a></li>
							</li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>外设产品</h3>
						<ul class="none">
							<li><a href="">鼠标</a></li>
							<li><a href="">键盘</a></li>
							<li><a href="">U盘</a></li>
						</ul>
					</div>
				</div>
				
				<div style="clear:both; height:1px;"></div>
			</div>
			<!-- 分类列表 end -->
				
			<div style="clear:both;"></div>	

			<!-- 新品推荐 start -->
			<div class="newgoods leftbar mt10">
				<h2><strong>新品推荐</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/list_hot1.jpg" alt="" /></a></dt>
								<dd><a href="">美即流金丝语悦白美颜新年装4送3</a></dd>
								<dd><strong>￥777.50</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/list_hot2.jpg" alt="" /></a></dt>
								<dd><a href="">领券满399减50 金斯利安多维片</a></dd>
								<dd><strong>￥239.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="/Public/Home/images/list_hot3.jpg" alt="" /></a></dt>
								<dd><a href="">皮尔卡丹pierrecardin 男士长...</a></dd>
								<dd><strong>￥1240.50</strong></dd>
							</dl>
						</li>
					</ul>
				</div>
			</div>
			<!-- 新品推荐 end -->

			<!--热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!--热销排行 end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap">
					<dl>
						<dt><a href=""><img src="/Public/Home/images/hpG4.jpg" alt="" /></a></dt>
						<dd><a href="">惠普G4-1332TX 14英寸笔记...</a></dd>
					</dl>

					<dl class="last">
						<dt><a href=""><img src="/Public/Home/images/crazy4.jpg" alt="" /></a></dt>
						<dd><a href="">直降200元！TCL正1.5匹空调</a></dd>
					</dl>
				</div>
			</div>
			<!-- 最近浏览 end -->
		</div>
		<!-- 左侧内容 end -->
	
		<!-- 列表内容 start -->
		<div class="list_bd fl ml10 mt10">
			<!-- 热卖、促销 start -->
			<div class="list_top">
				<!-- 热卖推荐 start -->
				<div class="hotsale fl">
					<h2><strong><span class="none">热卖推荐</span></strong></h2>
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/hpG4.jpg" alt="" /></a></dt>
								<dd class="name"><a href="">惠普G4-1332TX 14英寸笔记本电脑 （i5-2450M 2G 5</a></dd>
								<dd class="price">特价：<strong>￥2999.00</strong></dd>
								<dd class="buy"><span>立即抢购</span></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/list_hot3.jpg" alt="" /></a></dt>
								<dd class="name"><a href="">ThinkPad E42014英寸笔记本电脑</a></dd>
								<dd class="price">特价：<strong>￥4199.00</strong></dd>
								<dd class="buy"><span>立即抢购</span></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/acer4739.jpg" alt="" /></a></dt>
								<dd class="name"><a href="">宏碁AS4739-382G32Mnkk 14英寸笔记本电脑</a></dd>
								<dd class="price">特价：<strong>￥2799.00</strong></dd>
								<dd class="buy"><span>立即抢购</span></dd>
							</dl>
						</li>
					</ul>
				</div>
				<!-- 热卖推荐 end -->

				<!-- 促销活动 start -->
				<div class="promote fl">
					<h2><strong><span class="none">促销活动</span></strong></h2>
					<ul>
						<li><b>.</b><a href="">DIY装机之向雷锋同志学习！</a></li>
						<li><b>.</b><a href="">京东宏碁联合促销送好礼！</a></li>
						<li><b>.</b><a href="">台式机笔记本三月巨惠！</a></li>
						<li><b>.</b><a href="">富勒A53g智能人手识别鼠标</a></li>
						<li><b>.</b><a href="">希捷硬盘白色情人节专场</a></li>
					</ul>

				</div>
				<!-- 促销活动 end -->
			</div>
			<!-- 热卖、促销 end -->
			
			<div style="clear:both;"></div>
                        <style>
                            #search_condition span{border:4px dashed yellow;border-style:outset;padding:2px;font-weight:bolder;margin:8px;margin-bottom: 10px;}
                            #search_condition{margin:5px;margin:10px;height:80px;}
                             #search_condition p {font-size:16px;font-weight: bold;margin-bottom: 25px;}
                            #search_condition a:hover{color:red;}
                        </style>
                        <div style='padding:5px;background-color:lightgrey;<?php if(count(I("get.")) == 1 || count(I("get."))==0 ){echo "display:none;";}?>' id='search_condition' >
                            <p >当前筛选条件：</p>
                             <div >
                                 
                                    <!------品牌------>
                                    <?php  $brand_id = I('get.brand_id'); if($brand_id): $brand_name =ltrim(strstr($brand_id,'-'),'-'); ?>
                                     <span >品牌：<?php echo $brand_name?>--<a href="<?php getNewUrl('brand_id');?>" title='去除该条件'>删除</a></span>


                                    <!--------价格-------->
                                    <?php endif;?>
                                     <?php  $price = I('get.price'); if($price): ?>
                                    <span >价格：<?php echo $price;?>--<a href="<?php getNewUrl('price');?>" title='去除该条件'>删除</a></span>
                                    <?php endif;?>
                                    
                                    <!------属性------>
                                    <?php foreach(I('get.') as $k => $v): $weizhi = strpos($k,'_'); if($weizhi == 4): $rel = explode('_',$v); ?>
                                         <span ><?php echo $rel[0];?>：<?php echo $rel[1];?>--<a href="<?php getNewUrl($k);?>" title='去除该条件'>删除</a></span>
                                    <?php endif;endforeach;?>
                            </div>
                        </div>
			<!-- 商品筛选 start -->
			<div class="filter mt10">
				<h2><a href="/Index.php/Home/Search/key_search">重置筛选条件</a> <strong>商品筛选</strong></h2>
				<div class="filter_wrap">
					<dl>
						<dt>品牌：</dt>
                                                <dd class="cur"><a href="<?php getNewUrl('brand_id');?>">不限</a></dd>
                                                <?php foreach($data['brand'] as $k => $v): $brand_name = 'brand_id/'.$v['id'].'-'. $v['brand_name']; $brand_id = I('get.brand_id'); if($brand_id){ break; } ?>
                                                <dd><a href="/Index.php/Home/Search/key_search/key/%E6%A3%80%E6%B5%8B/<?php echo $brand_name;?>"><?php echo $v['brand_name'];?></a></dd>
						<?php endforeach;?>
					</dl>

					<dl>
						<dt>价格：</dt>
						<dd class="cur"><a href="<?php getNewUrl('price');?>">不限</a></dd>
                                                <?php foreach($data['price'] as $k => $v): $price_name = 'price/'.$v; $price = I('get.price'); if($price){ break; } ?>
						<dd><a href="/Index.php/Home/Search/key_search/key/%E6%A3%80%E6%B5%8B/<?php echo $price_name;?>"><?php echo $v;?></a></dd>
						<?php endforeach;?>
					</dl>
                                        <!-------属性筛选------>
                                       <?php foreach($data['attr'] as $k => $v):?>
					<dl>    
                                         
						<dt><?php echo $k;?>：</dt>   
                                                
                                                            <?php foreach($v as $k1 => $v1): $get_name = 'attr_'.$v1['attr_id']; if($k1>0){ break; } ?>
                                                            <dd class="cur"><a href="<?php getNewUrl($get_name);?>">不限</a></dd>
                                                            <?php endforeach;?>
                                                 
                                                <?php foreach($v as $k1 => $v1): $attr_name = 'attr_'.$v1['attr_id']; if(I("get.$attr_name")){ continue; } ?>
                                                <dd><a href="/Index.php/Home/Search/key_search/key/%E6%A3%80%E6%B5%8B/<?php echo 'attr_'.$v1['attr_id'].'/'.$k.'_'.$v1['attr_value'];?>"><?php echo $v1['attr_value'];?></a></dd>
						<?php endforeach;?>
                                          
					</dl>
                                        <?php endforeach;?>
				</div>
			</div>
			<!-- 商品筛选 end -->
			
			<div style="clear:both;"></div>

			<!-- 排序 start -->
			<div class="sort mt10">
				<dl>
                                    <?php  $odby = I('get.odby','xiao_liang'); ?>
					<dt>排序：</dt>
                                        <dd <?php if($odby=='xiao_liang'){echo 'class="cur"';}?> ><a href="<?php getNewUrl('odby');?>/odby/xiao_liang">销量</a></dd>
                                        <dd <?php if(strpos($odby,'price_')===0){echo 'class="cur"';}?> ><a href="<?php getNewUrl('odby');?>/odby/<?php if($odby=='price_desc'){echo 'price_asc';}else{ echo 'price_desc';}?>">
                                                <?php if( strpos($odby,'price_')!==0 ){ echo '价格';}elseif($odby == 'price_asc'){echo '价格↑';}else{ echo '价格↓';}?>
                                             </a></dd>
					<!---<dd><a href="<?php getNewUrl('odby');?>/odby/xiao_liang">评论数</a></dd>--->
					<dd <?php if($odby=='addtime'){echo 'class="cur"';}?> ><a href="<?php getNewUrl('odby');?>/odby/addtime">上架时间</a></dd>
				</dl>
			</div>
			<!-- 排序 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品列表 start-->
			<div class="goodslist mt10">
				<ul>
                                    <?php foreach($goods_data as $k => $v):?>
					<li>
						<dl>
                                                    <dt><a href="<?php echo U('Index/goods?id='.$v['id']);?>"><?php showImage($v['mid_logo']);?></a></dt>
							<dd><a href=""><?php echo $v['goods_name'];?></a></dt>
							<dd><strong>￥<?php echo $v['shop_price'];?></strong></dt>
							<dd><a href=""><em>已有10人评价</em>&nbsp;<em>已有<?php if($v['xiao_liang']){ echo $v['xiao_liang'];}else{echo '0';}?>人购买</em></a></dt>
						</dl>
					</li>
                                    <?php endforeach;?>
			</div>
			<!-- 商品列表 end-->

			<!-- 分页信息 start -->
			<div class="page mt20">
                              <?php echo $page;?>
			</div>
			<!-- 分页信息 end -->

		</div>
		<!-- 列表内容 end -->
	</div>
	<!-- 列表主体 end-->

  <div style="clear:both;"></div>
<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
        <div class="bnav1">
                <h3><b></b> <em>购物指南</em></h3>
                <ul>
                        <li><a href="">购物流程</a></li>
                        <li><a href="">会员介绍</a></li>
                        <li><a href="">团购/机票/充值/点卡</a></li>
                        <li><a href="">常见问题</a></li>
                        <li><a href="">大家电</a></li>
                        <li><a href="">联系客服</a></li>
                </ul>
        </div>

        <div class="bnav2">
                <h3><b></b> <em>配送方式</em></h3>
                <ul>
                        <li><a href="">上门自提</a></li>
                        <li><a href="">快速运输</a></li>
                        <li><a href="">特快专递（EMS）</a></li>
                        <li><a href="">如何送礼</a></li>
                        <li><a href="">海外购物</a></li>
                </ul>
        </div>


        <div class="bnav3">
                <h3><b></b> <em>支付方式</em></h3>
                <ul>
                        <li><a href="">货到付款</a></li>
                        <li><a href="">在线支付</a></li>
                        <li><a href="">分期付款</a></li>
                        <li><a href="">邮局汇款</a></li>
                        <li><a href="">公司转账</a></li>
                </ul>
        </div>

        <div class="bnav4">
                <h3><b></b> <em>售后服务</em></h3>
                <ul>
                        <li><a href="">退换货政策</a></li>
                        <li><a href="">退换货流程</a></li>
                        <li><a href="">价格保护</a></li>
                        <li><a href="">退款说明</a></li>
                        <li><a href="">返修/退换货</a></li>
                        <li><a href="">退款申请</a></li>
                </ul>
        </div>

        <div class="bnav5">
                <h3><b></b> <em>特色服务</em></h3>
                <ul>
                        <li><a href="">夺宝岛</a></li>
                        <li><a href="">DIY装机</a></li>
                        <li><a href="">延保服务</a></li>
                        <li><a href="">家电下乡</a></li>
                        <li><a href="">京东礼品卡</a></li>
                        <li><a href="">能效补贴</a></li>
                </ul>
        </div>
</div>
<!-- 底部导航 end -->

<!-- 页脚  -->
	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>
<script>
    $.ajax({
       type: 'get',
       url:"<?php echo U('User/ajax_chk_login');?>",
       dataType:'json',
       success:function(data){
            var li='';
            if(data.link == 1){ 
                    li = '您好！'+'<font color="red" size="2">'+data.level_name+'</font>&nbsp;&nbsp;'+data.username+'，欢迎来到<a href="<?php echo U('Index/index');?>">京西</a>！[<a href="<?php echo U('User/logout');?>">退出</a>] ';
                 }else{
                    li =  '您好，欢迎来到京西！[<a href="<?php echo U('User/login');?>">登录</a>] [<a href="<?php echo U('User/register');?>">免费注册</a>] ';
            }
            $('#loginfo').html(li);
       }
    });
</script>