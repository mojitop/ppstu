<?php

//去除URL 中参数的指代的 参数名  以及值  返回一个新的 URL 
function getNewUrl($get_name){ 
    $url = $_SERVER['PHP_SELF'];
    $reg ="/\/$get_name\/[^\/]+/";
    $newUrl = preg_replace($reg,'',$url);
    echo $newUrl;
    
}
// 有选择性的过滤XSS --》 说明：性能非常低-》尽量少用
function removeXSS($data)
{
	require_once './HtmlPurifier/HTMLPurifier.auto.php';
	$_clean_xss_config = HTMLPurifier_Config::createDefault();
	$_clean_xss_config->set('Core.Encoding', 'UTF-8');
	// 设置保留的标签
	$_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
	$_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
	$_clean_xss_config->set('HTML.TargetBlank', TRUE);
	$_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
	// 执行过滤
	return $_clean_xss_obj->purify($data);
}
function makeAlipayBtn($orderID,$btname='支付宝支付'){
            return require '/alipay/alipayapi.php';
        }
function showImage($url,$title='我是php程序“媛”老王',$width = '50'){
    //$url  传递二级目录到结尾的信息
    
   $link = C('IMAGE_CONFIG')['viewPath'];
   echo "<img src='{$link}$url' width='$width'  title='$title'/>";
}

//删除硬盘上的图片  一维数组  $data
function delImage($data){
    $link = C("IMAGE_CONFIG")['rootPath'];
    foreach($data as $k => $v){
        $rel = unlink("$link".$v);
    }
    return $rel;
}
//生成缩略图
/**
 * 上传图片并生成缩略图
 * 用法：
 * $ret = uploadOne('logo', 'Goods', array(
			array(600, 600),
			array(300, 300),
			array(100, 100),
		));
	返回值：
	if($ret['ok'] == 1)
		{
			$ret['images'][0];   // 原图地址
			$ret['images'][1];   // 第一个缩略图地址
			$ret['images'][2];   // 第二个缩略图地址
			$ret['images'][3];   // 第三个缩略图地址
		}
		else 
		{
			$this->error = $ret['error'];
			return FALSE;
		}
 *
 */
function uploadOne($imgName, $dirName, $thumb = array())
{
	// 上传LOGO
	if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0)
	{
		$ic = C('IMAGE_CONFIG');
		$upload = new \Think\Upload(array(
			'rootPath' => $ic['rootPath'],
			'maxSize' => $ic['maxSize'],
			'exts' => $ic['exts'],
		));// 实例化上传类
		$upload->savePath = $dirName . '/'; // 图片二级目录的名称
		// 上传文件 
		// 上传时指定一个要上传的图片的名称，否则会把表单中所有的图片都处理，之后再想其他图片时就再找不到图片了
		$info   =   $upload->upload(array($imgName=>$_FILES[$imgName]));
		if(!$info)
		{
			return array(
				'ok' => 0,
				'error' => $upload->getError(),
			);
		}
		else
		{
			$ret['ok'] = 1;
		    $ret['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];
		    // 判断是否生成缩略图
		    if($thumb)
		    {
		    	$image = new \Think\Image();
		    	// 循环生成缩略图
		    	foreach ($thumb as $k => $v)
		    	{
		    		$ret['images'][$k+1] = $info[$imgName]['savepath'] . 'thumb_'.$k.'_' .$info[$imgName]['savename'];
		    		// 打开要处理的图片
				    $image->open($ic['rootPath'].$logoName);
				    $image->thumb($v[0], $v[1])->save($ic['rootPath'].$ret['images'][$k+1]);
		    	}
		    }
		    return $ret;
		}
	}
}
function buildSelect($tableName,$selecte_name,$valueName,$textName,$selectedId=''){
    $model = D($tableName);
    $info = $model->field("$valueName,$textName")->select();
    $sel = "<select name=$selecte_name > <option>请选择</option>";
    foreach($info as $k => $v){
            $text = $v[$textName];
            $id = $v[$valueName];
            if($selectedId && $id==$selectedId){
                $selected = 'selected="selected"';
            }else{
                $selected = '';
            }
            $sel .='<option '.$selected.'value="'.$id.'">'.$text.'</option>';
    }
    $sel.='</select>';
    echo $sel;
} 