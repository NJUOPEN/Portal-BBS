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


/* 将需要分割的HTML文件名写在这里*/
define('SOURCE_FILE','./Open.html'); 
define('TARGET_FOLDER','../src/include/template/');
//define('SPLIT_TAG_BEGIN','<!-- 以上是');


/*
 *将文件名和对应分割标签写在这里：键名是template文件夹下的HTML文件名，键值为分割标签内容
 *参数顺序必须与标签顺一致
 *使用时仅取消所需参数的注释
*/

//以下为分割主页的参数
$split_args=array('header.html'=>'<!-- 以上是主页头部 -->','announcement.html'=>'<!-- 以上是通知栏 -->','official.html'=>'<!-- 以上是官方动态 -->','hot.html'=>'<!-- 以上是热帖 -->','forum.html'=>'<!-- 以上是交流区 -->','search.html'=>'<!-- 以上是死去的搜索 -->','footer.html'=>'<!-- 以上是网页信息和html结尾 -->'); 

//以下为分割单贴页面的参数
//$split_args=array('header_post.html'=>'<!-- 以上是单帖样式头部 -->','areaControl.html'=>'<!-- 以上是返回上一级连接 -->','viewControl.html'=>'<!-- 以上是看回复与翻页 -->','replyPost.html'=>'<!-- 以上是回帖部分 -->','footer.html'=>'<!-- 以上是网页信息及html结束 -->');

//以下为分割帖子浏览页面的参数
//$split_args=array('header_post.html'=>'<!-- 以上是帖子列表头部 -->','areaControl.html'=>'<!-- 以上是返回上一级连接，但是和另外一个不一样 -->','listControl.html'=>'<!-- 以上是帖子列表以及翻页 -->','replyPost.html'=>'<!-- 以上是发布主题 -->','footer.html'=>'<!-- 以上是网页信息以及html结束 -->');


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
