<?php
/*
 *type:PHP维护脚本
 *function:将完整的HTML样式页面拆分成数个HTML文件
 *Contributor:WTZ
*/

function splitFile($content,$target,$args)
{
	$p1=0;$p2=0;
	foreach ($args as $split_key=>$split_value)
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
}

//拆分后的模板存放路径
define('TARGET_FOLDER','../src/include/template/');


//TODO:将需要分割的[HTML文件名]和[段落标签]写在这里，$fileList顺序须与下面的$split_args相对应
$fileList=array('./Open.html','./SinglePost.html','./PostList.html');


//TODO:将文件名和对应分割标签写在这里，参数顺序必须与标签顺一致
$split_args=array(
	/*分割主页的参数*/array('header.html'=>'<!-- 以上是主页头部 -->',
						/*'announcement.html'=>'<!-- 以上是通知栏 -->',*/
						'official.html'=>'<!-- 以上是官方动态 -->',
						'hot.html'=>'<!-- 以上是热帖 -->',
						'forum.html'=>'<!-- 以上是交流区 -->',
						'search.html'=>'<!-- 以上是死去的搜索 -->',
						'footer.html'=>'<!-- 以上是网页信息和html结尾 -->'),
	/*分割单贴页面的参数*/array('header_post.html'=>'<!-- 以上是单帖样式头部 -->',
							'areaControl.html'=>'<!-- 以上是返回上一级连接 -->',
							'viewControl.html'=>'<!-- 以上是看回复与翻页 -->',
							'replyPost.html'=>'<!-- 以上是回帖部分 -->',
							'footer.html'=>'<!-- 以上是网页信息及html结束 -->'),
	/*分割帖子列表页面的参数*/array('header_post.html'=>'<!-- 以上是帖子列表头部 -->',
								'areaControl.html'=>'<!-- 以上是返回上一级连接，但是和另外一个不一样 -->',
								'listControl.html'=>'<!-- 以上是帖子列表以及翻页 -->',
								'addPost.html'=>'<!-- 以上是发布主题 -->',
								'footer.html'=>'<!-- 以上是网页信息以及html结束 -->')
				);


//TODO:将需要[替换的字符]写在这里，如：相对路径替换为绝对路径，调试信息替换为空字符串等
$replace_args=array('src=\'./'=>'src=\'<?php echo BBS_WEB_TEMPLATE.\'/\';?>',
					'href="./'=>'href="<?php echo BBS_WEB_TEMPLATE.\'/\';?>',
					'src=\'../src/include/template/'=>'src=\'<?php echo BBS_WEB_TEMPLATE.\'/\';?>',
					'帖子列表样式'=>'OPEN社团 - 帖子列表',
					'贴子名字'=>'OPEN社团 - 帖子内容'
					);


echo 'Split begin...<br />';

for($i=0; $i<count($fileList); $i++)
{
	echo '<br />Processing on '.$file.'<br />';
	$f=fopen($fileList[$i],'rb');
	$content=fread($f,filesize($fileList[$i]));
	fclose($f);
	foreach ($replace_args as $replace_from => $replace_to)
	{
		//根据$replace_args的参数替换相对路径为绝对路径
		$content=str_replace($replace_from,$replace_to,$content);
	}	
	splitFile($content,TARGET_FOLDER,$split_args[$i]);	
}


echo '<br />Split finished.';
exit(0);
?>
