<?php
/*
该文件定义整个论坛运行所需的常量，应当首先被加载
*/

//以下定义PHP内部调用时的引用路径
define('BBS_ROOT',dirname(__FILE__));
define('BBS_TEMPLATE',BBS_ROOT.'/include/template');

//以下定义前端网页的引用路径，调试时请修改为本地服务器URL
define('BBS_WEB_ROOT','http://127.0.0.1/Portal-BBS/src');
define('BBS_WEB_TEMPLATE',BBS_WEB_ROOT.'/include/template');

define('SQL_HOST','localhost');
define('SQL_ACCOUNT','test');
define('SQL_PASSWORD','password');
define('SQL_DB','UsersOfOPENBBS');

?>
