<?php
return array(
    //'配置项'=>'配置值'
    'MULTI_MODULE'         => false,
    'DEFAULT_MODULE'       => 'Tieba',
    'URL_CASE_INSENSITIVE' =>true,
    //数据库配置信息
    'DB_TYPE'              => 'mysqli', // 数据库类型
    'DB_HOST'              => 'localhost', // 服务器地址
    'DB_NAME'              => 'tieba', // 数据库名
    'DB_USER'              => 'root', // 用户名
    'DB_PWD'               => '', // 密码
    'DB_PORT'              => 3306, // 端口
    'DB_PREFIX'            => 'tb_', // 数据库表前缀
    'DB_CHARSET'           => 'utf8', // 字符集
    'DB_DEBUG'             => false, // 调试模式
    //'TMPL_TRACE_FILE' => './App/Tieba/View/Public/trace.php',
    'SHOW_PAGE_TRACE'      => true, // 显示页面Trace信息
    //伪静态后缀
    'URL_HTML_SUFFIX'      => '',
    //自定义错误页面
    'TMPL_EXCEPTION_FILE'  => './App/Tieba/View/Public/exception.html',
    //默认错误跳转对应的模板文件
    'TMPL_ACTION_ERROR'    => 'Public:error',
    //URL模式
    'URL_MODEL'            => 2,
);
