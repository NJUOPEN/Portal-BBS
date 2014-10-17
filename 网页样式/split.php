<?php
/*
 *type:PHP维护脚本
 *function:将完整的HTML样式页面拆分成数个HTML文件
 *Contributor:WTZ
*/

function findSection($source,$tag,$from=0)  //根据给定标签截取对应段落
{
	if ($tag=='') return '';
	$p=strpos($source,$tag,$from);
	return substr($source,$from,$p-$from);
}


define('SOURCE_FILE','./Open.html');
define('TARGET_FOLDER','../src/include/template/');
//define('SPLIT_TAG_BEGIN','<!-- 以上是');

$split_args=array('header.html'=>'<!-- 以上是主页头部 -->','announcement.html'=>'<!-- 以上是通知栏 -->','official.html'=>'<!-- 以上是官方动态 -->','hot.html'=>'<!-- 以上是热帖 -->','forum.html'=>'<!-- 以上是交流区 -->','search.html'=>'<!-- 以上是死去的搜索 -->','footer.html'=>'<!-- 以上是网页信息和html结尾 -->'); //将文件名和对应分割标签写在这里


$f=fopen(SOURCE_FILE,'rb');
$content=fread($f,filesize(SOURCE_FILE));
fclose($f);

$p1=0;$p2=0;
foreach ($split_args as $split_key=>$split_value)
{
	$f=fopen(TARGET_FOLDER.$split_key,'wb');
	if (!$f) {echo 'Writing to file failed. Please check for privileage.<br />'; break;}
	$p2=strpos($content,$split_value,$p1);
	echo '<textarea>'.substr($content,$p1,$p2-$p1).'</textarea>';
	fwrite($f,substr($content,$p1,$p2-$p1));
	fclose($f);
	echo ' Write to '.$split_key.'<br />';
	$p1=$p2+strlen($split_value);
}
echo 'Finished.';
exit(0);
?>
