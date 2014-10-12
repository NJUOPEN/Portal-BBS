<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor: WHZ
 * Filename: dispatcher.php
 *
 * 研究了emlog和网上的一些dispatcher例子,对于路由表的概念不太理解,
 * 不明白如何直接通过一个method变量就能来创造类,暂时只能将就着用switch罗列出来
 */

$action;
$params;
$action = $_POST['action'];
$params = array();
foreach ($_POST as $key=>$val) {
    if ($key != 'action') {
        $params[$key]=$val;
    }
}
switch ($action) {
    case 'login' :
        //echo "Into Login case<br />";
        include(BBS_ROOT.'/include/module/log.php');
        login($params);
        break;
    case 'logout' :
        //echo "Into Logout case<br />";
        include(BBS_ROOT.'/include/module/log.php');
        logout();
        break;
        // TODO add more
}
?>
