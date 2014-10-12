<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: post.php
 */

function showPostList()
{
	global $cssList;  //引用函数外定义的全局变量需要先申明为global
	array_push($cssList,'PostListUI.css');
}
function showPostView()
{
	global $cssList;
	array_push($cssList,'SinglePostUI.css');
}
?>
