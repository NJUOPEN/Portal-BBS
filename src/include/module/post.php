<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ,WTZ
 * Filename: post.php
**/

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
	
	if (isset($_SESSION['PostID'])) unset($_SESSION['PostID']);

	$listsize=getNatureNumber($params['ListSize'],10);	//ListSize是贴子列表的分页长度

	$pageNum=getNatureNumber($params['page'],1);	//page是浏览器请求显示的页面编号

	$start = ($pageNum - 1) * $listsize;

	$secNum=getNatureNumber($params['section'],-1);	//section是浏览器请求显示的版块编号,-1用于标示传入的参数无效
	if ($secNum==-1 && isset($_SESSION['SectionID']))
		$secNum=$_SESSION['SectionID'];
	else
	{
		$secNum=getNatureNumber($params['section'],1);
		if ($secNum > BBS_SECTION_NUMBER) $secNum=1;
		$_SESSION['SectionID']=$secNum;	//将当前浏览的版块编号缓存于SESSION
	}

	$post_list = $PostList->getPostList($listsize, $start, $secNum);

	$userDB = new SQL_User;

	for ($i = 0; $i < count($post_list); $i++) {
		$post_list[$i]['title'] = unEscPost($post_list[$i]['title']);
		$post_list[$i]['PostAdd'] = unEscPost($post_list[$i]['PostAdd']);

		$tempUser = $userDB->getInfOfUser($post_list[$i]['IDofUsers']);
		$post_list[$i]['AuthorName']=$tempUser['Name'];
		$post_list[$i]['AuthorAvatar']=BBS_WEB_USERFILE.$tempUser['Picture'];
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
	$params['PostID']=getNatureNumber($params['PostID'],-1);
	if ($params['PostID']==-1) //PostID不合法
	{
		if (!isset($_SESSION['PostID'])) return;	//且SESSION中无缓存，则返回
		$params['PostID'] = $_SESSION['PostID'];
	}
	$_SESSION['PostID'] = $params['PostID'];	//将当前浏览的帖子ID缓存于SESSION中

	global $post_list;
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$PostList = new SQL_Post;

	$viewsize=getNatureNumber($params['ViewSize'],10);	//ViewSize是回贴列表的分页长度
	// TODO 暂时在这里在 $_SESSION 里缓存 顶楼的层号
	if (array_key_exists('page', $params))
	{
		$_SESSION['PostOffset'] = ($params['page'] - 1) * $viewsize;
	}
	else
	{
		$_SESSION['PostOffset'] = 0;
	}

	$pageNum=getNatureNumber($params['page'],1);	//page是浏览器请求显示的页面编号

	$start = ($pageNum - 1) * $viewsize;

	$post_list=array();
	array_push($post_list,$PostList->getPost($params['PostID'])); //根据PostID获取到的帖子记录是单个元素，所以用push

	//而这里获取到的跟帖列表是数组，所以用merge;
	$post_list=array_merge($post_list, $PostList->getFollowedList($params['PostID'],$viewsize,$start));
	//print_r($post_list);

	$userDB = new SQL_User;
	$post_list[0]['Title'] = unEscPost($post_list[0]['Title']);	//只有主题帖子的标题需要解码
	for ($i = 0; $i < count($post_list); $i++) {
		$post_list[$i]['PostAdd'] = unEscPost($post_list[$i]['PostAdd']);

		$tempUser = $userDB->getInfOfUser($post_list[$i]['IDofUsers']);
		$post_list[$i]['AuthorName']=$tempUser['Name'];
		$post_list[$i]['AuthorAvatar']=BBS_WEB_USERFILE.$tempUser['Picture'];
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

function showPost($params) {	//根据Session中缓存PostID决定访客所处位置（帖子列表/帖子内容）
	if (isset($_SESSION['PostID']))
	{
		showPostView($params);		
		global $outputView;	
		$outputView='postView';
	}
	else
		showPostList($params);
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
	$newPost->writePost($_SESSION['SysID'], $time, EscPost($params['title']), EscPost($params['content']),false,'0',$_SESSION['SectionID']);
}

function doReply($params) {
	if (!isset($_SESSION['SysID'])) return;
	$params['PostID']=getNatureNumber($params['PostID'],-1);
	if ($params['PostID'] == -1)	//PostID不合法
	{
		if (!isset($_SESSION['PostID'])) return;	//且SESSION中无缓存，则返回
		$params['PostID'] = $_SESSION['PostID'];	//否则就使用缓存
	}
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$newPost = new SQL_Post;
	$followedPost=$newPost->getPost($params['PostID']);
	if ($followedPost==NULL) return;	//检查所跟帖子是否合法
	$time=gmdate(SQL_Post::SQL_DATE_FORMAT); //同上
	$newPost->writePost($_SESSION['SysID'], $time, NULL, EscPost($params['content']),true, $params['PostID'],$followedPost->$SectionID);
}
?>
