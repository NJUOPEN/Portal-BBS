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

function showPostList($params)
{
	loadUI('general');
	if (isset($_SESSION['SysID'])) loadUI('editor');
	
	global $post_list;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	
	$listsize=getNatureNumber($params['ListSize'],10);	//ListSize是贴子列表的分页长度

	$pageNum=getNatureNumber($params['page'],1);	//page是浏览器请求显示的页面编号
	
	$start = ($pageNum - 1) * $listsize;
	
	$post_list = $PostList->getPostList($listsize, $start);

	$userDB = new SQL_User;
	
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list[$i]['PostAdd'] = unEscPost($post_list[$i]['PostAdd']);
		
		$tempUser = $userDB->getInfOfUser($post_list[$i]['IDofUsers']);
		$post_list[$i]['AuthorName']=$tempUser['Name'];
	}
	
	global $page_link;
	$page_link=pagination($pageNum,ceil($PostList->getTotalNumOfPost()/$listsize),7);
	for($i=0;$i<count($page_link);$i++)	//将页面编号进一步扩展成编号+链接
	{
		$temp=$page_link[$i];
		if ($temp=='...')
			$page_link[$i]=array($temp,'#');
		else
			$page_link[$i]=array($temp,'?page='.$temp);
	}
}
function showPostView($params)
{
	loadUI('postView');
	if (isset($_SESSION['SysID'])) loadUI('editor');
	if (!isset($params['PostID'])) return;
	
	global $post_list;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	
	$viewsize=getNatureNumber($params['ViewSize'],10);	//ViewSize是回贴列表的分页长度
	
	$pageNum=getNatureNumber($params['page'],1);	//page是浏览器请求显示的页面编号
	
	$start = ($pageNum - 1) * $viewsize;
	
	
		$post_list=array();
		array_push($post_list,$PostList->getPost($params['PostID'])); //根据PostID获取到的帖子记录是单个元素，所以用push
		
		$post_list=array_merge($post_list, $PostList->getFollowedList($params['PostID'],$viewsize,$start));//而这里获取到的跟帖列表是数组，所以用merge;
		//print_r($post_list);
	
	$userDB = new SQL_User;
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list[$i]['PostAdd'] = unEscPost($post_list[$i]['PostAdd']);
		
		$tempUser = $userDB->getInfOfUser($post_list[$i]['IDofUsers']);
		$post_list[$i]['AuthorName']=$tempUser['Name'];
	}
	
	global $page_link;
	$page_link=pagination($pageNum,ceil($post_list[0]['FollowNum']/$viewsize),7);
	for($i=0;$i<count($page_link);$i++)	//将页面编号进一步扩展成编号+链接
	{
		$temp=$page_link[$i];
		if ($temp=='...')
			$page_link[$i]=array($temp,'#');
		else
			$page_link[$i]=array($temp,'?action=postView&PostID='.$params['PostID'].'&page='.$temp);
	}
}
// 发布帖子
function doPost($params) {
	if (!isset($_SESSION['SysID'])) return;
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
	if (!isset($_SESSION['SysID'])) return;
	if (!isset($params['PostID'])) return;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$time=gmdate(SQL_Post::SQL_DATE_FORMAT); //同上
	$newPost->writePost($_SESSION['SysID'], $time, NULL, EscPost($params['content']),true, $params['PostID']);
}
?>
