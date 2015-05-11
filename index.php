<?php
//入口文件
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('需要PHP版本>=5.4，低于5.4将无法运行！');
}
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
define('BUILD_DIR_SECURE', false);
// 定义应用目录
define('APP_PATH', './App/');
// 引入ThinkPHP入口文件
require './System/ThinkPHP.php';
