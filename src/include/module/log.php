<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: log.php
 */

//参考:blog.csdn.net/sysprogram/article/details/21107041

class log {
	/**
	 * 登录
	 */
	public function login($params) {
		$username = $params['username'];
		$password = sha1($params['password']);
		//TODO 数据库存储的是明码还是hash值?
		//连接数据库
		include('SQL.php');
		$data = new SQL_Operator;
		//认证
		$check_result = $data->get('BaseInfOfUsers', $username, $password);
		if(!empty($check_result)) { //登录成功
   			session_start();
    		$_SESSION['username'] = $username;
    		$_SESSION['userid'] = $check_result['userid'];
    		echo "登录成功<br />";
    		exit;
		} else {
    		exit("登录失败<br />");
		}
	}

	/**
	 * 登出
	 */
	public function logout() {
    		unset($_SESSION['userid']);
    		unset($_SESSION['username']);
    		echo "注销成功<br />";
    		exit;
    }
}

?>
