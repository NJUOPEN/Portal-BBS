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
require_once('./config.php');

//加载库函数
require_once(BBS_ROOT.'/include/lib/function_base.php');

//帖子相关缓冲
$post_list=array();
$num_buf = $_POST['num'];
//进行请求分发(dispatch)
require_once(BBS_ROOT.'/include/lib/dispatcher.php');

//输出
header("Content-type: text/html; charset=utf-8");

require_once(BBS_TEMPLATE.'/html_head.html');//显示通用顶部
switch($action)//以下内容为可变部分，根据前端的ACTION进行选择性加载
{
	/*
	case 'postList':
	case 'doPost':
		require_once(BBS_TEMPLATE.'/areaControl.html');//显示板块位置
		require_once(BBS_TEMPLATE.'/listControl.html');//显示贴子列表
		require_once(BBS_TEMPLATE.'/addPost.html');//显示发帖模块
		break;
	*/		
	case 'postView':
	case 'doReply' :
		require_once(BBS_TEMPLATE.'/header_post.html');
		require_once(BBS_TEMPLATE.'/login_post.html');//显示贴子内容
		require_once(BBS_TEMPLATE.'/areaControl.html');//显示板块位置
		break;
	case 'register':
		require_once(BBS_TEMPLATE.'/register.html');
		break;
	case 'change_avatar':
	case 'information':
		require_once(BBS_TEMPLATE.'/information.html');
		break;
	default:
		//显示默认主页
		require_once(BBS_TEMPLATE.'/header.html');
		require_once(BBS_TEMPLATE.'/forum.html');
		require_once(BBS_TEMPLATE.'/login.html');
		//TODO:添加登录、登出提示框，将login、logout的样式与默认主页分离；
}
require_once(BBS_TEMPLATE.'/footer.html');//显示底部通用样式

exit(0);
?>
