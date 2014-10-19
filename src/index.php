<?php
/**
 *本文件为论坛前台操作的公共入口
 *运行时，依次进行以下操作：
 *	系统基本配置
 *	加载数据库/前端样式配置文件；
 *	分发请求；
 *	输出样式；
**/

session_start();	//开启会话控制
error_reporting(7);	//设置错误提示等级

//加载全局配制
include_once('./config.php');

//初始化前端需要用到的CSS和JS列表
$cssList=array();
$jsList=array();

//帖子相关缓冲
$post_list=array();
$num_buf = $_POST['num'];
//进行请求分发(dispatch)
include_once(BBS_ROOT.'/include/lib/dispatcher.php');

//输出
header("Content-type: text/html; charset=utf-8");

include_once(BBS_TEMPLATE.'/header.html');//显示通用顶部
switch($action)//以下内容为可变部分，根据前端的ACTION进行选择性加载
{
	
	case 'postList':
	case 'doPost':
		include_once(BBS_TEMPLATE.'/areaControl.html');//显示板块位置
		include_once(BBS_TEMPLATE.'/listControl.html');//显示贴子列表
		include_once(BBS_TEMPLATE.'/addPost.html');//显示发帖模块
		break;		
	case 'postView':
		include_once(BBS_TEMPLATE.'/areaControl.html');//显示板块位置
		include_once(BBS_TEMPLATE.'/viewControl.html');//显示贴子内容
		include_once(BBS_TEMPLATE.'/replyPost.html');//显示回帖模块
		break;		
	default:
		//显示默认主页
		include_once(BBS_TEMPLATE.'/announcement.html');//显示公告
		include_once(BBS_TEMPLATE.'/official.html');
		include_once(BBS_TEMPLATE.'/hot.html');
		include_once(BBS_TEMPLATE.'/new.html');
		include_once(BBS_TEMPLATE.'/forum.html');
		include_once(BBS_TEMPLATE.'/search.html');
		//TODO:添加登录、登出提示框，将login、logout的样式与默认主页分离；
}
include_once(BBS_TEMPLATE.'/footer.html');//显示底部通用样式

exit(0);
?>
