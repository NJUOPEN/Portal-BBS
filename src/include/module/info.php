<?php
loadUI('information');
require_once(BBS_ROOT.'/include/module/SQL.php');

/* Get infomation */
$usrInfo = new SQL_User;
$usrInfoList = $usrInfo->getInfOfUser($_SESSION['SysID']);
$usrID = $_SESSION['SysID'];
$usrName = $usrInfoList['Name'];
$usrRank = $usrInfoList['Rank'];
$usrEmail = $usrInfoList['Email'];
$usrGender = $usrInfoList['Gender'];
$usrAge = $usrInfoList['Age'];
$usrPW = $usrInfoList['Code'];

if (isset($_POST['INFO_ACTION']))
{
    $info_action = $_POST['INFO_ACTION'];
    switch($info_action)
    {
    case 'change_info':
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
    }
}
?>
