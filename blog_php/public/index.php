<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 定义运行时目录
define('RUNTIME_PATH',APP_PATH.'index/runtime/');

// 定义日志目录
define('LOG_PATH',APP_PATH.'index/runtime/log/');

// 定义项目模板缓存目录
define('CACHE_PATH',APP_PATH.'index/runtime/cache/');

// 定义应用缓存目录
define('TEMP_PATH',APP_PATH.'index/runtime/temp/');

// 定义SESSION
define('SESSION_PATH',APP_PATH.'index/runtime/session/');

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

// 读取自动生成定义文件
$build = include '../build.php';  
// 运行自动生成  
\think\Build::run($build); 
