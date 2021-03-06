<?php
/**
 *本文件为论坛前台操作的公共入口
 *运行时，依次进行以下操作：
 *  初始化操作
 *  分发请求
 *  输出结果
**/

//初始化操作
require_once('./init.php');

$outputView='';

//进行请求分发(dispatch)
require_once(BBS_ROOT.'/include/lib/dispatcher.php');

//若分发过程中未指定具体的outputView，则将action作为outputView
if ($outputView=='') $outputView=$action;

//输出
header("Content-type: text/html; charset=utf-8");

require_once(BBS_TEMPLATE.'/html_head.html');//显示通用顶部
switch($outputView)//以下内容为可变部分，根据前端的ACTION进行选择性加载
{		
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
	case 'change_info':
	case 'information':
		require_once(BBS_TEMPLATE.'/information.html');
		break;
	case 'postList':
	case 'doPost':
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
