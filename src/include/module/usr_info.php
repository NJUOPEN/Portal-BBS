<?php
require_once(BBS_ROOT.'/include/module/SQL.php');
$usrInfo = new SQL_User;
$usrInfoList = $usrInfo->getInfOfUser($_SESSION['SysID']);
$usrID = $_SESSION['SysID'];
$usrName = $usrInfoList['Name'];
$usrRank = $usrInfoList['Rank'];
$usrEmail = $usrInfoList['Email'];
$usrGender = $usrInfoList['Gender'];
$usrAge = $usrInfoList['Age'];
$usrPW = $usrInfoList['Code'];
?>
