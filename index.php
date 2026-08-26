<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
ini_set('display_errors', 1);
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die('require PHP > 5.3.0 !');
}

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
require_once './vendor/autoload.php';

// PATH_INFO 修复：当 PATH_INFO 为空时从 REQUEST_URI 补充，兼容 Nginx try_files 模式
if (empty($_SERVER['PATH_INFO']) && !empty($_SERVER['REQUEST_URI'])) {
    $uri = $_SERVER['REQUEST_URI'];
    if (false !== ($pos = strpos($uri, '?'))) {
        $uri = substr($uri, 0, $pos);
    }
    if ($uri !== '' && $uri !== '/') {
        $_SERVER['PATH_INFO'] = $uri;
    }
}

// 定义应用目录
define('APP_PATH', './App/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
