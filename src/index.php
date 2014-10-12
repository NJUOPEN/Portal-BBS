<?php
/*
本文件为论坛前台操作的公共入口
运行时，依次进行以下操作：
	加载配置文件；
	分发请求；
	输出样式；
*/

//加载全局配制
include_once('./config.php');

//初始化前端需要用到的CSS和JS列表
$cssList=array();
$jsList=array();

//进行请求分发(dispatch)
include_once(BBS_ROOT.'/include/lib/dispatcher.php');

//输出
header("Content-type: text/html; charset=utf-8");
include_once(BBS_TEMPLATE.'/header.html');//显示顶部通用样式
include_once(BBS_TEMPLATE.'/search.html');
include_once(BBS_TEMPLATE.'/announcement.html');

switch($action)//以下内容为可变部分，根据前端的ACTION进行选择性加载
{
	
	case 'postList':
		include_once(BBS_TEMPLATE.'/postList.html');//显示贴子列表页
	case 'postView':
		include_once(BBS_TEMPLATE.'/postView.html');//显示贴子内容页
	default:
		//显示默认主页
		include_once(BBS_TEMPLATE.'/official.html');
		include_once(BBS_TEMPLATE.'/hot.html');
		include_once(BBS_TEMPLATE.'/forum.html');
	//TODO:添加登录、登出提示框，将login、logout的样式与默认主页分离；
}
include_once(BBS_TEMPLATE.'/footer.html');//显示底部通用样式

exit(0);
?>
