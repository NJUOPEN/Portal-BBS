<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: post.php
 */
function showPostList($params)
{
	global $cssList;  //引用函数外定义的全局变量需要先申明为global
	global $new_posts;
	array_push($cssList,'PostListUI.css');

	include(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	$new_posts = $PostList->getLastInfofPost($params['num']);
}
function showPostView()
{
	global $cssList;
	array_push($cssList,'SinglePostUI.css');
}
?>
