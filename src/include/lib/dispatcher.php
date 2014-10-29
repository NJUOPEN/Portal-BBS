<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor: WHZ
 * Filename: dispatcher.php
 */

/*
 申明了以下全局变量：
	$action:前端提交的动作；
	$params:前端提交的参数；
*/
$action = $_REQUEST['action'];
$params = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    foreach ($_POST as $key=>$val) {
    //FIXED:通过$_POST获取数据，可能导致部分由GET提交的数据被遗漏，如$params['num']
        if ($key != 'action') {
            $params[$key]=$val;
        }
    }
} else if ($method == 'GET') {
    foreach ($_GET as $key=>$val) {
		if ($key != 'action') {
		    $params[$key]=$val;
		}
    }
} else {
    echo 'Unexpected request!<br />';
    $action = 'invalid';
}

switch ($action) {
    case 'login' :
        include_once(BBS_ROOT.'/include/module/log.php');
        login($params);
        break;
    case 'logout' :
        include_once(BBS_ROOT.'/include/module/log.php');
        logout();
        break;
    case 'doPost' :
    	include_once(BBS_ROOT.'/include/module/post.php');
    	doPost($params);
    	showPostList($params);
    	break;
    case 'doReply' :
    	include_once(BBS_ROOT.'/include/module/post.php');
    	$params['PostID'] = $_SESSION['PostID'];
    	doReply($params);
    	showPostView($params);
    	break;
    case 'postList' :
    	include_once(BBS_ROOT.'/include/module/post.php');
    	showPostList($params);
    	break;
    case 'postView' :
    	include_once(BBS_ROOT.'/include/module/post.php');
    	$_SESSION['PostID'] = $params['PostID'];
    	showPostView($params);
    	break;
    case 'upload' :
	    include_once(BBS_ROOT.'/include/module/file.php');
	    upload_file();
	    break;
    case 'invalid' :
		echo 'action is set invalid<br />';
    // TODO add more
}
?>
