<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
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

function showPostList($params)
{
	global $cssList,$jsList;  //引用函数外定义的全局变量需要先申明为global
	array_push($cssList,'PostListUI.css');
	array_push($cssList,'editor/kindeditor/themes/default/default.css');
	array_push($jsList,'editor/kindeditor/kindeditor-min.js');
	array_push($jsList,'editor/kindeditor/lang/zh_CN.js');
	array_push($jsList,'KE.js');
	
	global $post_list;
	// if ($params['num'] == NULL) $params['num'] = 0;;

	include_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	$post_list = $PostList->getLastInfofPost($params['ListSize']);
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list['PostAdd'] = unEscPost($post_list['PostAdd']);
	}
}
function showPostView($PostID)
{
	global $cssList,$jsList;
	array_push($cssList,'SinglePostUI.css');
	array_push($cssList,'PostListUI.css');
	array_push($cssList,'editor/kindeditor/themes/default/default.css');
	array_push($jsList,'editor/kindeditor/kindeditor-min.js');
	array_push($jsList,'editor/kindeditor/lang/zh_CN.js');
	array_push($jsList,'KE.js');
	
	global $post_list;
	include_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	
	if (isset($PostID)) {
		$post_list = $PostList->getPost($PostID);
		$post_list = array_merge($post_list, $PostList->getFollowedList($PostID));
	}
}
// 发布帖子
function doPost($params) {
	include_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$date = getdate();
	$time = $date['year'];
	$time = $time.'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'];
	$newPost->writePost($_SESSION['SysID'], $time, $params['title'], EscPost($params['content']));
}

function doReply($params) {
	include_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$date = getdate();
	$time = $date['year'];
	$time = $time.'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'];
	$newPost->writePost($_SESSION['SysID'], $time, NULL, EscPost($params['content']),true, $params['PostID']);
}
?>
