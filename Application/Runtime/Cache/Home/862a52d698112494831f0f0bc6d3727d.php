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

<!-- 商品页面主体 start -->
	<div class="main w1210 mt10 bc">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2>当前位置：<a href="">首页</a> > 
                            <?php foreach($cat_name as $k => $v):?>
                            <a href=""><?php echo $v;?></a> >
                            <?php endforeach;?>
                            <?php echo $gdata['goods_name'];?></h2>
		</div>
		<!-- 面包屑导航 end -->
		
		<!-- 主体页面左侧内容 start -->
		<div class="goods_left fl">
			<!-- 相关分类 start -->
			<div class="related_cat leftbar mt10">
				<h2><strong>相关分类</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">笔记本</a></li>
						<li><a href="">超极本</a></li>
						<li><a href="">平板电脑</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关分类 end -->

			<!-- 相关品牌 start -->
			<div class="related_cat	leftbar mt10">
				<h2><strong>同类品牌</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">D-Link</a></li>
						<li><a href="">戴尔</a></li>
						<li><a href="">惠普</a></li>
						<li><a href="">苹果</a></li>
						<li><a href="">华硕</a></li>
						<li><a href="">宏基</a></li>
						<li><a href="">神舟</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关品牌 end -->

			<!-- 热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!-- 热销排行 end -->


			<!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
			<div class="related_view newgoods leftbar mt10">
				<h2><strong>浏览了该商品的用户还浏览了</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view1.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E431(62771A7) 14英寸笔记本电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view2.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view3.jpg" alt="" /></a></dt>
								<dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
								<dd><strong>￥7999.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view4.jpg" alt="" /></a></dt>
								<dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
								<dd><strong>￥6199.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view5.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
								<dd><strong>￥4399.00</strong></dd>
							</dl>
						</li>					
					</ul>
				</div>
			</div>
			<!-- 浏览过该商品的人还浏览了  end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap" id="history" >


				</div>
			</div>
			<!-- 最近浏览 end -->

		</div>
		<!-- 主体页面左侧内容 end -->
		
		<!-- 商品信息内容 start -->
		<div class="goods_content fl mt10 ml10">
			<!-- 商品概要信息 start -->
			<div class="summary">
				<h3><strong><?php echo $gdata['goods_name'];?></strong></h3>
				
				<!-- 图片预览区域 start -->
				<div class="preview fl">
					<div class="midpic">
                                            <a  href="<?php echo $viewPath.$gdata['mbig_logo'];?>" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
							<img src="<?php echo $viewPath.$gdata['big_logo'];?>" alt="" />               <!-- 第一幅图片的中图 -->
						</a>
					</div>
	
					<!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 
                                        下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，
                                         同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

					<div class="smallpic">
						<a href="javascript:;" id="backward" class="off"></a>
						<a href="javascript:;" id="forward" class="on"></a>
						<div class="smallpic_wrap">
							<ul>
								<li class="cur">
									<a class="zoomThumbActive" href="javascript:void(0);" 
                                                                        rel="{gallery: 'gal1', smallimage: '<?php echo $viewPath.$gdata['big_logo'];?>',largeimage: '<?php echo $viewPath.$gdata['mbig_logo'];?>'}">
                                                                        <img src="<?php echo $viewPath.$gdata['sm_logo'];?>"></a>
								</li>
                                                            <?php foreach($gpdata as $k => $v):?>
								<li>
									<a href="javascript:void(0);"
                                                                        rel="{gallery: 'gal1', smallimage: '<?php echo $viewPath.$v['mid_pic'];?>',largeimage: '<?php echo $viewPath.$v['big_pic'];?>'}">
                                                                        <img src="<?php echo $viewPath.$v['sm_pic'];?>"></a>
								</li>
                                                            <?php endforeach;?>
								
							</ul>
						</div>
						
					</div>
				</div>
				<!-- 图片预览区域 end -->

				<!-- 商品基本信息区域 start -->
				<div class="goodsinfo fl ml10">
					<ul>
						<li><span>商品编号： </span><?php echo $gdata['id'];?></li>
						<li class="market_price"><span>定价：</span><em>￥<?php echo $gdata['market_price'];?></em></li>
						<li class="shop_price"><span>本店价：</span> <strong>￥<?php echo $gdata['shop_price'];?></strong> <a href="">(降价通知)</a></li>
                                                <!--会员价格一览--->
                                                <li>
                                                    <span>会员价格：</span>
                                                    <table>
                                                <?php foreach($updata as $k => $v):?>
                                                     <tr>
                                                         <td> <span><?php echo $v['level_name'];?>：</span></td> <td>￥<?php echo $v['price'];?></td>
                                                    </tr>
                                                <?php endforeach;?>
                                                </table></li>
                                                <li class="shop_price"><span>实际价格：</span> <strong id="true_pri"></strong> <a href="">(降价通知)</a></li>
						<li><span>上架时间：</span><?php echo $gdata['addtime'];?></li>
						<li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
					</ul>
                                    <form action="<?php echo U('Cart/add')?>" method="post" class="choose">
                                        <input type='hidden' name='goods_id' value="<?php echo $gdata['id'];?>"/>
						<ul>     
                                                        <?php foreach($mulAttr as $k => $v):?>
							<li class="product">
								<dl>
									<dt><?php echo $k;?>：</dt>
									<dd>    
                                                                                 <?php foreach($v as $k1 => $v1):?>
                                                                                        <a class="<?php if($k1 == 0){echo 'selected';}?>" href="javascript:;"><?php echo $v1['attr_value'];?>
                                                                                        <input type="radio" name='goods_attr_id[ <?php echo$v1["attr_id"];?> ]' value="<?php echo $v1['goods_attr_id'];?>" checked="<?php if($k1 == 0){echo 'checked';}?>" /></a>
                                                                                  <?php endforeach;?>
									</dd>
								</dl>
							</li>
                                                        <?php endforeach;?>
							
							<li>
								<dl>
									<dt>购买数量：</dt>
									<dd>
										<a href="javascript:;" id="reduce_num"></a>
										<input type="text" name="goods_number" value="1" class="amount"/>
										<a href="javascript:;" id="add_num"></a>
									</dd>
								</dl>
							</li>

							<li>
								<dl>
									<dt>&nbsp;</dt>
									<dd>
										<input type="submit" value="" class="add_btn" />
									</dd>
								</dl>
							</li>

						</ul>
					</form>
				</div>
				<!-- 商品基本信息区域 end -->
			</div>
			<!-- 商品概要信息 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品详情 start -->
			<div class="detail">
				<div class="detail_hd">
					<ul>
						<li class="first"><span>商品介绍</span></li>
						<li class="on"><span>商品评价</span></li>
						<li><span>售后保障</span></li>
					</ul>
				</div>
				<div class="detail_bd">
					<!-- 商品介绍 start -->
					<div class="introduce detail_div none">
						<div class="attr mt15">
							<ul>
                                                            <?php foreach($uniAttr as $k => $v):?>
                                                                <?php foreach($v as $k1 => $v1):?>
								<li><span><?php echo $v1['attr_name'];?>：</span><?php echo $v1['attr_value'];?></li>
                                                                <?php endforeach;?>
                                                            <?php endforeach;?>
							</ul>
						</div>

						<div class="desc mt10">
							<!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
                                                         <?php echo $gdata['goods_desc'];?>
						</div>
					</div>
					<!-- 商品介绍 end -->
					
					<!-- 商品评论 start -->
					<div class="comment detail_div mt10">
						<div class="comment_summary" id="comment_lst">
							<div id="hao_lv" class="rate fl">
							</div>
							<div id="pl_lv" class="percent fl">
							</div>
							<div class="buyer fl">
								<dl>
									<dt id="yx_lst">买家印象：</dt>
								</dl>
							</div>
						</div>
                                                <!-- 评论容器 -->
						<div id="comment_container"></div>
						<!-- 分页信息 start -->
						<div class="page mt20" id="page_lst">
							
						</div>
						<!-- 分页信息 end -->

						<!--  评论表单 start-->
						<div class="comment_form mt20">
							<form id="comment_content">
								<ul>
									<li id="yx_checkbox_use">
                                                                            <input type="hidden" name="goods_id" value="<?php echo $gdata['id']; ?>"/>
										<label for=""> 评分：</label>
                                                                                <input type="radio" name="star" value="5" checked="checked"/> <strong class="star star5"></strong>
										<input type="radio" name="star" value="4"/> <strong class="star star4"></strong>
										<input type="radio" name="star" value="3"/> <strong class="star star3"></strong>
										<input type="radio" name="star" value="2"/> <strong class="star star2"></strong>
										<input type="radio" name="star" value="1"/> <strong class="star star1"></strong>
									</li>
                                                                        <li>
										<label for="">买家印象：</label>
										<input type="text" size="30" name="yx_name"  />每个印象之间用逗号','隔开
									</li>

									<li>
										<label for="">评价内容：</label>
										<textarea name="content" id="content_value" cols="" rows=""></textarea>
									</li>
									<li>
										<label for="">&nbsp;</label>
										<input type="button" value="提交评论"  class="comment_btn"/>										
									</li>
								</ul>
							</form>
						</div>
						<!--  评论表单 end-->
						
					</div>
					<!-- 商品评论 end -->

					<!-- 售后保障 start -->
					<div class="after_sale mt15 none detail_div">
						<div>
							<p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
							<p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

						</div>

						<div>
							<h3>服务承诺：</h3>
							<p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p> 
							
							<p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

						</div>
						
						<div>
							<h3>权利声明：</h3>
							<p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
							<p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

						</div>
					</div>
					<!-- 售后保障 end -->

				</div>
			</div>
			<!-- 商品详情 end -->

			
		</div>
		<!-- 商品信息内容 end -->
		

	</div>
	<!-- 商品页面主体 end -->
	

	<div style="clear:both;"></div>

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
<style>
    .reply_box ul li{margin-top:25px;border-top:1px solid lightgray;}
    .reply_box img{float:right;border:1px solid #009999;width:50px;}
     .reply_box p {margin:5px;}
</style>

<script type="text/javascript">
		document.execCommand("BackgroundImageCache", false, true);
</script>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/goods.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/common.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">
	
	<!--引入jqzoom css -->
	<link rel="stylesheet" href="/Public/Home/style/jqzoom.css" type="text/css">

	<script type="text/javascript" src="/Public/Home/js/header.js"></script>
	<script type="text/javascript" src="/Public/Home/js/goods.js"></script>
	<script type="text/javascript" src="/Public/Home/js/jqzoom-core.js"></script>
	
	<!-- jqzoom 效果 -->
<script>
        $(function(){
                $('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            title:false,
            zoomWidth:400,
            zoomHeight:400
        });
        });
        
        //浏览历史记录设置
        $.ajax({
            type:'get',
            url:"<?php echo U('Index/display_history?id='.$gdata['id']) ?>",
            dataType:'json',
            success:function(data){
             // 循环服务器返回的浏览历史数据放到页面中
		// 先拼HTML字符串
		var html = "";
		$(data).each(function(k,v){
		  html += '<dl><dt><a href="<?php echo U('Index/goods', '', FALSE); ?>/id/'+v.id+'"><img src="/Public/Uploads/'+v.mid_logo+'" /></a></dt><dd><a href="<?php echo U('Index/goods', '', FALSE); ?>/id/'+v.id+'">'+v.goods_name+'</a></dd></dl>';
		});
		// 放到 页面中
		$("#history").html(html);
            }
        });

</script>  
<script>
            //计算goods实际价格
        $.ajax({
            type:'GET',
            url:"<?php echo U('Index/getUserPri?goods_id='.$gdata['id']) ;?>",
            success:function(data){

               $('#true_pri').html('¥'+data);
            }
            
        });
        
        /**************ajax 发表评论**************/
        $('.comment_btn').click(function(){
          
            var formdata = $('#comment_content').serialize();
            $.ajax({
                type:'post',
                url:"<?php echo U('Comment/add','',false);?>",
                data:formdata,
                dataType:'json',
                success:function(data){
                    if(data.status == 0){
                       
                         alert( data.info );
                         /**************** Link to open the dialog****************/
                         // 显示对话框
			 // $( "#login_dialog" ).dialog( "open" );                    
                        //alert(data.info);
                    }else{
                        var html = '<div style="display:none;" class="comment_items mt10"><div class="user_pic"><dl><dt><a href=""><img src="'+data.info.face+'" alt="" /></a></dt><dd><a href="">'+data.info.username+'</a></dd></dl></div><div class="item"><div class="title"><span>'+data.info.addtime+'</span><strong class="star star'+data.info.star+'"></strong></div><div class="comment_content">'+data.info.content+'</div><div class="btns"><a onclick="do_reply(this,'+data.info.id+')" href="javascript:void(0);"  class="reply">回复(0)</a><a onclick="set_youyong(this,'+data.info.id+')" href="javascript:void(0);"  class="useful">有用(0)</a></div><div class="reply_box"><ul class="reply_lst"></ul></div></div><div class="cornor"></div></div>';
                        html = $(html);
                        $("#comment_container").prepend(html);
                        $('#comment_content').trigger("reset");
                       	$("body").animate({
			     "scrollTop" : "700px"
			}, 1000, function(){html.fadeIn(2000);});
                    }
                }
            });
        });
</script>
     


<script>
        /********************ajax 获取评论和翻页 *********************/
    function ajaxGetPL(p=1){
        $.ajax({
            type:'get',
            url:"<?php echo U('Comment/search?id='.$gdata['id'],'',false);?>/p/"+p,
            dataType:"json",
            success:function(data){
                //如果取得第一页数据计算好评率
                if(p == 1){
                    var hao_lv ='<strong><em>'+data.hao+'</em>%</strong> <br /><span>好评度</span>';
                    $('#hao_lv').html(hao_lv);
                    var plhtml='<dl><dt>好评（'+data.hao+'%）</dt><dd><div style="width:'+data.hao+'px;"></div></dd></dl><dl><dt>中评（'+data.zhong+'%）</dt><dd><div style="width:'+data.zhong+'px;"></div></dd></dl><dl><dt>差评（'+data.cha+'%）</dt><dd><div style="width:'+data.cha+'px;" ></div></dd></dl>';
	            $('#pl_lv').html(plhtml);
                    var yx_html = '';
                    var yx_checkbox = '<li> <label for="">已有印象：</label>';
                    if(data.yx_data != ''){
                        $(data.yx_data).each(function(k,v){
                            yx_html += '<dd><span>'+v.yx_name+'</span><em>('+v.yx_count+')</em></dd>';
                            yx_checkbox += '<input type="checkbox" name="yx_id[]" value="'+v.id+'" />'+v.yx_name+'　';
                        });
                        yx_checkbox +='</li>';
                        $("#yx_lst").after(yx_html);
                        //设置印象复选框
                        $('#yx_checkbox_use').after(yx_checkbox);
                    }                   
                }
                //alert(data.page_count);
                var htm='';
                var reply_html='';
                $(data.rel).each(function(k,v){
                      $(v.reply).each(function(k1,v1){
                                if(v.id == v1.comment_id){
                                    reply_html +='<li><img src="'+v1.face+'"/> '+v1.username+' 【'+v1.addtime+'】 回复的内容：<br/><p>'+v1.content+'</p></li>';  
                                }
                      });
                      htm += '<div class="comment_items mt10"><div class="user_pic"><dl><dt><a href=""><img src="'+v.face+'" alt="" /></a></dt><dd><a href="">'+v.username+'</a></dd></dl></div><div class="item"><div class="title"><span>'+v.addtime+'</span><strong class="star star'+v.star+'"></strong></div><div class="comment_content">'+v.content+'</div><div class="btns"><a onclick="do_reply(this,'+v.id+')" href="javascript:void(0);" class="reply">回复('+v.reply_count+')</a><a onclick="set_youyong(this,'+v.id+')" href="javascript:void(0);" class="useful">有用('+v.click_count+')</a></div><div class="reply_box"><ul class="reply_lst">'+reply_html+'</ul></div></div></div>';
                      reply_html = '';
                 });
                $('#comment_container').html(htm);
                var page_count = data.page_count;
                var a = '';
                for(var i=1;i<=page_count;++i){
                     if(p == i){
                        var cla="class='cur'";
                     }else{
                        var cla="";
                     }
                     a += ' <a onclick="ajaxGetPL('+i+')" href="javascript:void(0);" '+cla+'>'+i+'</a>';
                }
                $('#page_lst').html(a);
                
            },
        });
    }
    ajaxGetPL(1);
    
    //设置回复函数 do_reply
    function do_reply(btn,comment_id){
        var reply_box_div = $(btn).parent().next('.reply_box');
        var reply_data_html = '<form><input type="hidden" name="comment_id" value="'+comment_id+'"/><p><textarea name="content" cols="80" rows="6"></textarea></p><br/> <input type="button" onclick="post_reply(this)" href="javascript:void(0);" value="回复"/>　<input onclick="no_reply(this)" href="javascript:void(0);" type="button" value="取消"/></form>';
        $(reply_box_div).append(reply_data_html);
    }
    function post_reply(btn){
        var form_reply = $(btn).parent();
        var form_data =$(form_reply).serialize();
        $.ajax({
            type:"post",
            url:"<?php echo U('Comment/reply','',false);?>",
            data:form_data,
            dataType:"json",
            success:function(data){
                if(data.status == 1){
                    var reply_lst_ul= $(btn).parent().siblings('ul');
                    var li_reply_html ='<li><img src="'+data.info.face+'"/> '+data.info.username+' 【'+data.info.addtime+'】 回复的内容：<br/><p>'+data.info.content+'</p></li>';
                    $(reply_lst_ul).prepend(li_reply_html);
                    
                    var reply_form =  $(btn).parent();
                    $(reply_form).html('');
                }else{
                    alert(data.info);
                }
            }
        });
    }
    function no_reply(btn){
        var reply_form =  $(btn).parent();
        $(reply_form).html('');
    }
    function set_youyong(btn,id){
        $.ajax({
            type:'post',
            url:"<?php echo U('Comment/setYouYong','',false);?>",
            data:'id='+id,
            success:function(data){
                  alert(data.info);   
              }
        });
    }
</script>
		

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