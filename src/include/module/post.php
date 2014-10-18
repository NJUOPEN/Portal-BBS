<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: post.php
 */
function showPostList($params)
{
	global $cssList;  //引用函数外定义的全局变量需要先申明为global
	global $post_list;
	array_push($cssList,'PostListUI.css');

	// if ($params['num'] == NULL) $params['num'] = 0;;

	include(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	$post_list = $PostList->getLastInfofPost($params['num']);
}
function showPostView()
{
	global $cssList;
	array_push($cssList,'SinglePostUI.css');
	array_push($cssList,'PostListUI.css');
}
?>
