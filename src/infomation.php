<?php
session_start();
print_r($_SESSION);
require_once('./config.php');
require_once(BBS_ROOT.'/include/module/SQL.php');
?>
<html>
  <body>
<?php
  $usrInfo = new SQL_User;
  $usrInfoList = $usrInfo->getInfOfUser($_SESSION['SysID']);
  echo '<br />';
  $cnt = 0;
  foreach($usrInfoList as $key => $val)
  {
  	if ($cnt % 2 != 0)
  	{
  		echo "$key: $val<br />\n";
  	}
  	$cnt = $cnt + 1;
  }
?>
  </body>
</html>