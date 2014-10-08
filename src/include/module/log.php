<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: log.php
 */

//参考:blog.csdn.net/sysprogram/article/details/21107041
if (!session_id()) session_start();

function login($params) {
		$username = $params['Name'];
		$password = sha1($params['Code']);
		//TODO 数据库存储的是明码还是hash值?
		//连接数据库
		include(BBS_ROOT.'include/module/SQL.php');
		$data = new SQL_Operator;
		//认证
		$check_result = $data->getInfOfUserByName($username);
		if(!empty($check_result)) { //登录成功
    		$_SESSION['Name']   = $check_result['Name'];
    		$_SESSION['SysID'] = $check_result['SysID'];
    		echo 'Login success<br />';
    		exit;
		} else {
    		exit("Login failed<br />");
		}
	}

	/**
	 * 登出
	 */
function logout() {
	//echo "$_SESSION[userid]<br />";
	//echo "$_SESSION[username]<br />";
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo "Log out success<br />";
    exit;
    }
?>
