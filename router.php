<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// 真实存在的静态文件（非 .php）直接返回
if ($uri !== '/' && file_exists($file) && !is_dir($file) && pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
    return false;
}

// 让 ThinkPHP 以为入口是 /index.php，使 URL 生成正确
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
$_SERVER['PHP_SELF']        = '/index.php';
$_SERVER['PATH_INFO']       = $uri;

require __DIR__ . '/index.php';
