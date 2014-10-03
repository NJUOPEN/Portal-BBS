<?php
/*
Project: NJUOPEN/Portal-BBS
Contributor:WHZ
*/

//登录:POST,username=username&password=password&action=login
//登出:POST,action=logout
//参考:blog.csdn.net/sysprogram/article/details/21107041

header("Content-type: text/html; charset=utf-8");

//登录
if ($_POST['action']=='login') {
	$username = $_POST['username'];
	$password = $_POST['password'];//TODO 散列函数

	//连接数据库
	include('SQL.php');
	$data = new SQL_Operator;
	$data->__construct();

	//认证
	$check_result = $data->get('user_list', $username, $password);//TODO 表的名称
	if(!empty($check_result)){
    	//登录成功
   		session_start();
    	$_SESSION['username'] = $username;
    	$_SESSION['userid'] = $check_result['userid'];
    	echo "登录成功<br />";
    	exit;
	} else {
    	exit("登录失败<br />");
	}
}

//登出
if($_POST['action'] == "logout"){
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo "注销<br />";
    exit;
}

?>
