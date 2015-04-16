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
	
	if (isset($params['ListSize']))	//ListSize是贴子列表的分页长度
		$listsize=(int)$params['ListSize'];
		if ($listsize<1) $listsize=10;
	else
		$listsize=10;	

	if (isset($params['page']))	//page是浏览器请求显示的页面编号
	{
		$pageNum=(int)$params['page'];
		if ($pageNum<1) $pageNum=1;
	}
	else
		$pageNum=1;	
	
	if ($pageNum>0)
		$start = ($pageNum - 1) * $listsize;
	else
		$start=0;		
		
	if (isset($params['section']))	//section是浏览器请求显示的版块编号
	{
		$secNum=(int)$params['section'];
		if ($secNum<1) $secNum=1;		
	}
	else
	{
		if (isset($_SESSION['SectionID']))
			$secNum=$_SESSION['SectionID'];
		else
			$secNum=1;
	}
	$_SESSION['SectionID']=$secNum;	//将当前浏览的版块编号缓存于SESSION
	
	$post_list = $PostList->getPostList($listsize, $start, $secNum);

	$userDB = new SQL_User;
	
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list[$i]['PostAdd'] = unEscPost($post_list[$i]['PostAdd']);
		
		$tempUser = $userDB->getInfOfUser($post_list[$i]['IDofUsers']);
		$post_list[$i]['AuthorName']=$tempUser['Name'];
	}
	
	global $page_link;
	$page_link=pagination($pageNum,ceil($PostList->getSectionNumOfPost($secNum)/$listsize),7);
	for($i=0;$i<count($page_link);$i++)	//将页面编号进一步扩展成编号+链接
	{
		$temp=$page_link[$i];
		if ($temp=='...')
			$page_link[$i]=array($temp,'#');
		else
			$page_link[$i]=array($temp,'?page='.$temp.'&section='.$secNum);
	}
}
function showPostView($params)
{
	loadUI('postView');
	if (isset($_SESSION['SysID'])) loadUI('editor');
	
	global $post_list;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;
	if (!isset($params['ViewSize']) || $params['ViewSize']<1) $params['ViewSize']=10;	//ViewSize是回贴列表的分页长度
	if (isset($params['PostID'])) {
		$post_list=array();
		array_push($post_list,$PostList->getPost($params['PostID'])); //根据PostID获取到的帖子记录是单个元素，所以用push
		
		if (isset($params['replyPage']) && $params['replyPage']>0)
			$start = ($params['replyPage'] - 1) * $params['ViewSize'];
		else
			$start=0;		
		$post_list=array_merge($post_list, $PostList->getFollowedList($params['PostID'],$params['ViewSize'],$start));//而这里获取到的跟帖列表是数组，所以用merge;
		//print_r($post_list);
	}
	$userDB = new SQL_User;
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list[$i]['PostAdd'] = unEscPost($post_list[$i]['PostAdd']);
		
		$tempUser = $userDB->getInfOfUser($post_list[$i]['IDofUsers']);
		$post_list[$i]['AuthorName']=$tempUser['Name'];
	}
}
// 发布帖子
function doPost($params) {
	if (!isset($_SESSION['SysID'])) return;
	if (!isset($_SESSION['SectionID'])) return;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	/*
	$date = getdate();
	$time = $date['year'];
	$time = $time.'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'];
	*/
	$time=gmdate(SQL_Post::SQL_DATE_FORMAT); //更简洁的日期获取方式；参见gmdate()和SQL_Obj的定义
	$newPost->writePost($_SESSION['SysID'], $time, $params['title'], EscPost($params['content']),false,'0',$_SESSION['SectionID']);
}

function doReply($params) {
	if (!isset($_SESSION['SysID'])) return;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$followedPost=$newPost->getPost($params['PostID']);
	if ($followedPost==NULL) return;	//检查所跟帖子是否合法
	$time=gmdate(SQL_Post::SQL_DATE_FORMAT); //同上
	$newPost->writePost($_SESSION['SysID'], $time, NULL, EscPost($params['content']),true, $params['PostID'],$followedPost->$SectionID);
}
?>
