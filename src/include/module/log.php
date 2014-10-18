<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: log.php
 */

//参考:blog.csdn.net/sysprogram/article/details/21107041
function login($params) {
		//print_r($params);
		$username = $params['Name'];
		$password = sha1($params['Code']);
		//连接数据库
		include(BBS_ROOT.'/include/module/SQL.php');
		$data = new SQL_User;
		//认证
		$check_result = $data->getInfOfUserByName($username);
		if(!empty($check_result) && $check_result['Name']==$username && $check_result['Code']==$password) { //登录成功
    		$_SESSION['Name']   = $check_result['Name'];
    		$_SESSION['SysID'] = $check_result['SysID'];
    		echo 'Login success<br />';
    		//exit;
		} else {
    		echo("Login failed<br />");
		}
	}

	/**
	 * 登出
	 */
function logout() {
    unset($_SESSION['SysID']);
    unset($_SESSION['Name']);
    echo "Log out success<br />";
    exit;
    }
?>
