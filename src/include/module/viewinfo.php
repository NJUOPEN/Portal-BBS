<?php
session_start();
//TODO �����·��...
require_once('../../config.php');

require_once(BBS_ROOT.'/include/module/usr_info.php');

//TODO ��� $action �о��е��Ť����value=INFO_MODҲ������
if (isset($_POST['action']))
{
	$action = $_POST['action'];
}
else
{
	$action = 'default';
}
switch($action)
{
case 'INFO_MOD':
	$newPW = $_POST['newPW'];
	$checkPW = $_POST['checkPW'];
	$newEmail = $_POST['newEmail'];
	$curPW = sha1($_POST['curPW']);

	if ($curPW != $usrPW)
	{
	    echo "wrong password<br />";
	    break;
	}

	if ($newPW != $checkPW)
	{
	    echo "not consistent<br />";
	    break;
	}

	$tempUsr = new SQL_User;
	if ($newPW != null)
	{
		$tempUsr->resetUserCode($usrID, sha1($newPW));
		echo "password changed<br />";
	}

	if ($newEmail != null)
	{
		$regex = "/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/";
		if (preg_match($regex, $newEmail))
		{
			$tempUsr->resetUserEmail($usrID, $newEmail);
			echo "email changed<br />";
		}
		$usrEmail = $newEmail;
	}
default:
}
require_once(BBS_ROOT.'/include/template/infomation.html');
?>
