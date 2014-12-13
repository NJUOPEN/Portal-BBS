<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ,WTZ
 * Filename: post.php
 */

function EscPost($content) {
	if (is_string($content)) {
		str_replace("'", "\\'", $content);
	}
	return $content;
}

function unEscPost($content) {
	if (is_string($content)) {
		str_replace("\\'", "'", $content);
	}
	return $content;
}

function loadCommonUI()	//加载通用CSS/JS等
{
	global $cssList;
	array_push($cssList,'GeneralUI.css');
}

function loadEditorUI()	//加载帖子编辑所需CSS/JS等
{
	global $cssList,$jsList;
	if(isset($_SESSION['SysID']))	//只有登录以后才显示编辑器有关脚本，以便加快加载速度
	{
		array_push($cssList,'editor/kindeditor/themes/default/default.css');
		array_push($jsList,'editor/kindeditor/kindeditor-min.js');
		array_push($jsList,'editor/kindeditor/lang/zh_CN.js');
		array_push($jsList,'KE.js');
	}
}

function showPostList($params)
{
	loadCommonUI();
	global $cssList;
	array_push($cssList,'PostListUI.css');
	loadEditorUI();
	
	global $post_list;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	$post_list = $PostList->getLastInfofPost($params['ListSize']);
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list['PostAdd'] = unEscPost($post_list['PostAdd']);
	}
}
function showPostView($params)
{
	loadCommonUI();
	global $cssList;
	array_push($cssList,'PostListUI.css');
	array_push($cssList,'SinglePostUI.css');
	loadEditorUI();
	
	global $post_list;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	if (isset($params['PostID'])) {
		$post_list=array();
		array_push($post_list,$PostList->getPost($params['PostID'])); //根据PostID获取到的帖子记录是单个元素，所以用push
		$post_list=array_merge($post_list, $PostList->getFollowedList($params['PostID']));//而这里获取到的跟帖列表是数组，所以用merge;
		//DELETEME
		//print_r($post_list);
	}
}
// 发布帖子
function doPost($params) {
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	/*
	$date = getdate();
	$time = $date['year'];
	$time = $time.'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'];
	*/
	$time=gmdate(SQL_Post::SQL_DATE_FORMAT); //更简洁的日期获取方式；参见gmdate()和SQL_Obj的定义
	$newPost->writePost($_SESSION['SysID'], $time, $params['title'], EscPost($params['content']),false,'0');
}

function doReply($params) {
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$date = getdate();
	$time = $date['year'];
	$time = $time.'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'];
	$newPost->writePost($_SESSION['SysID'], $time, NULL, EscPost($params['content']),true, $params['PostID']);
}
?>
