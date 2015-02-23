<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WHZ
 * Filename: log.php
 */

//参考:blog.csdn.net/sysprogram/article/details/21107041
function login_check($params)
{

}
function login($params) {
    //print_r($params);
    $username = $params['username'];
    $password = sha1($params['password']);
    //连接数据库
    require_once(BBS_ROOT.'/include/module/SQL.php');
    $data = new SQL_User;
    //认证
    $check_result = $data->getInfOfUserByName($username);
    if(!empty($check_result) && $check_result['Name']==$username && $check_result['Code']==$password) { //登录成功
    $_SESSION['Name']  = $check_result['Name'];
    $_SESSION['SysID'] = $check_result['SysID'];
    echo 'Login success<br />';
    // 记录头像路径
    $_SESSION['avatar'] = BBS_WEB_ROOT.'/userfile/'.$_SESSION['SysID'].'/avatar.jpg';
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

//备注：注册时创建用户文件目录
//功能：检查用户文件目录是否存在，如果不存在，则创建之
//参数：
//  userID - 用户ID，即SysID
//返回值：无
function userfile_mkdir($userID)
{
    if (!file_exists(BBS_ROOT.'/userfile/'))
    {
        echo 'Create '.BBS_ROOT.'/userfile/<br />';
        mkdir(BBS_ROOT.'/userfile/');
    }
    if (!file_exists(BBS_ROOT.'/userfile/'.$userID.'/'))
    {
        echo 'Create '.BBS_ROOT.'/userfile/'.$userID.'/<br />';
        mkdir(BBS_ROOT.'/userfile/'.$userID.'/');
    }
}

function register_show_form() {
	loadUI('register');
}

function register($params) {
	loadUI('general');
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

    // mkdir
    require_once(BBS_ROOT.'/include/module/SQL.php');
    $data = new SQL_User;
    $check_result = $data->getInfOfUserByName($name);
    userfile_mkdir($check_result['SysID']);
}
?>
