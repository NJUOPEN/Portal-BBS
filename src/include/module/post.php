<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: post.php
 */

function showPostList($params)
{
	echo 'Func Post start';
	echo '<br />';
	global $cssList;  //引用函数外定义的全局变量需要先申明为global
	array_push($cssList,'PostListUI.css');

	include(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	$result = $PostList->getLastInfofPost($params['num']);
	for($i=0;$i<count($result);$i++)
	{
		echo $result[$i]['PostID'].':'.$result[$i]['Title'].'<br />';
	}
}
function showPostView()
{
	global $cssList;
	array_push($cssList,'SinglePostUI.css');
}
?>
