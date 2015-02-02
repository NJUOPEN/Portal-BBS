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
    $_SESSION['Name']  = $check_result['Name'];
    $_SESSION['SysID'] = $check_result['SysID'];
    echo 'Login success<br />';
    //exit;
    } else {
        echo("Login failed<br />");
    }
    loadUI('general');
	if (isset($_SESSION['SysID'])) loadUI('editor');
}

/**
 * 登出
 */
function logout() {
    unset($_SESSION['SysID']);
    unset($_SESSION['Name']);
    echo "Log out success<br />";
    loadUI('general');
	if (isset($_SESSION['SysID'])) loadUI('editor');
}

function register($params) {
    $email = $params['email'];
    $name = $params['username'];
    $pw = $params['password'];
    $repw = $params['repassword'];
    if ($email=='' || $name=='' || $pw=='' || $repw=='') return;
    if ($pw == $repw) {
        require_once(BBS_ROOT."/include/module/SQL.php");
        $pw = sha1($pw);
        $newUser=new SQL_User;
        $newUser->addUser($name, $pw, NULL, 1, 0, $email, 0, 18);
        echo "User Registered.<br />";
    } else {
        echo "password not match<br/>";
    }
}
?>
