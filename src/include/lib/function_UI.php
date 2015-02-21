<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WTZ
 * Filename: function_UI.php
 */

function loadUI($param) //加载特定的CSS/JS
{
	global $cssList,$jsList;
	__add_to_list($cssList,'stylesheet-general.css');
	switch($param)
	{
		case 'general'://主页
			__add_to_list($cssList,'stylesheet-newOpen.css');
			__add_to_list($jsList,'js-newOpen.js');
			break;
		case 'postView'://单贴页面
			__add_to_list($cssList,'stylesheet-newSinglePost.css');
			//__add_to_list($jsList,'js-newSinglePost.js');	//貌似在正式输出时不需要
			break;
		case 'information'://个人信息
			__add_to_list($cssList,'stylesheet-infomation.css');
			break;
		case 'register'://注册页
			__add_to_list($cssList,'stylesheet-register.css');
			break;
		case 'editor'://KindEditor编辑器
			__add_to_list($cssList,'editor/kindeditor/themes/default/default.css');
			__add_to_list($jsList,'editor/kindeditor/kindeditor-min.js');
			__add_to_list($jsList,'editor/kindeditor/lang/zh_CN.js');
			__add_to_list($jsList,'KE.js');
			break;
		default:
		
	}
			
}

//初始化前端需要用到的CSS和JS列表
$cssList=array();
$jsList=array();
?>
