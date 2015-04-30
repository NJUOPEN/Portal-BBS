<?php
/**
 *本文件为论坛公用初始化文件
 *若要与后台独立交互（如JSON），请先加载该文件
**/

session_start();    //开启会话控制
error_reporting(7); //设置错误提示等级

//加载全局配制
require_once(dirname(__FILE__).'/config.php');

//加载库函数
require_once(BBS_ROOT.'/include/lib/function_base.php');

?>