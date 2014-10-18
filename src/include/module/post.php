<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: post.php
 */
function showPostList($params)
{
	global $cssList,$jsList;  //引用函数外定义的全局变量需要先申明为global
	array_push($cssList,'PostListUI.css');
	array_push($cssList,'editor/kindeditor/themes/default/default.css');
	array_push($jsList,'editor/kindeditor/kindeditor-min.js');
	array_push($jsList,'editor/kindeditor/lang/zh_CN.js');
	array_push($jsList,'KE.js');	
	
	global $post_list;
	echo isset($post_list);
	print_r($params);
	// if ($params['num'] == NULL) $params['num'] = 0;;

	include(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	$post_list = $PostList->getLastInfofPost($params['num']);
}
function showPostView()
{
	global $cssList,$jsList;
	array_push($cssList,'SinglePostUI.css');
	array_push($cssList,'PostListUI.css');
	array_push($cssList,'editor/kindeditor/themes/default/default.css');
	array_push($jsList,'editor/kindeditor/kindeditor-min.js');
	array_push($jsList,'editor/kindeditor/lang/zh_CN.js');
	array_push($jsList,'KE.js');	
}
// 发布帖子
function doPost($params) {
	include(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$date = getdate();
	$time = $date['year'];
	$time = $time.'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'];
	$newPost->writePost($_SESSION['SysID'], $time, $params['title'], $params['content']);
}
?>
