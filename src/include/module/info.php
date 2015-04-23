<?php

function getUserInfo($params)
{
	loadUI('information');
	if (!isset($_SESSION['SysID'])) return;
	$usrID = $_SESSION['SysID'];
	require_once(BBS_ROOT.'/include/module/SQL.php');
	$usrInfo = new SQL_User;
	global $usrInfoList;
	$usrInfoList = $usrInfo->getInfOfUser($usrID);
	$usrInfoList['Code']='';	//密码信息不通过global共享
}

function updateUserInfo($params)
{
if (!isset($_SESSION['SysID'])) return;
$usrID = $_SESSION['SysID'];
require_once(BBS_ROOT.'/include/module/SQL.php');
$usrInfo = new SQL_User;
$usrInfoList = $usrInfo->getInfOfUser($usrID);

if (isset($params['INFO_ACTION']))
{
    $info_action = $params['INFO_ACTION'];
    switch($info_action)
    {
    case 'change_all_info':
	$newPW = $params['newPW'];
	$checkPW = $params['checkPW'];
	$newEmail = $params['newEmail'];
	$curPW = sha1($params['curPW']);
	
	if ($params['curPW'] == '')
	{
		echo 'Please input original password!<br />';
		break;
	}
	
	if ($curPW != $usrInfoList['Code'])
	{
	    echo "wrong password<br />";
	    break;
	}

	if ($newPW != $checkPW)
	{
	    echo "not consistent<br />";
	    break;
	}

	if ($newPW != null)
	{
		$usrInfo->resetUserCode($usrID, sha1($newPW));
		echo "password changed<br />";
	}

	if ($newEmail != null && $newEmail!=$usrInfoList['Email'])
	{
		$regex = "/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/";
		if (preg_match($regex, $newEmail))
		{
			$usrInfo->resetUserEmail($usrID, $newEmail);
			echo "email changed<br />";
		}
		$usrInfoList['Email'] = $newEmail;
	}
    }
}
}
?>
