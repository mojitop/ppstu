<?php
return array(
  
    //'DB_DSN'    => 'mysql:host=localhost;dbname=php39;charset=utf8',
    //'DB_HOST' =>  'localhost', // 服务器地址
    //'DB_NAME' =>  'php39',          // 数据库名
    //'DB_CHARSET' =>  'utf8',      // 数据库编码默认采用utf8
    'DEFAULT_FILTER' => 'trim,htmlspecialchars',
     'DB_TYPE'              =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'php39',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'mgs_',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',     // 数据库编码默认采用utf8
    'TMPL_CONTENT_TYPE'     =>  'text/html', // 默认模板输出类型
    
        //图片的配置
   'IMAGE_CONFIG' => array(
        'maxSize'       => 4096*1024, //上传的文件大小限制 (0-不做限制)
        'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
        'rootPath'      =>  './Public/Uploads/', //保存根路径
        'viewPath'      => '/Public/Uploads/',   //显示图片路劲
        'savePath'      =>  'Goods/', //设置附件上传子目录,保存路径
    )

);