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
			$p2=strpos($content,$split_key,$p1);
			if ($split_value!='')
			{
				$f=fopen($target.$split_value,'wb');
				if (!$f) {echo 'Writing to file failed. Please check for privileage.<br />'; break;}
				echo '<textarea>'.substr($content,$p1,$p2-$p1).'</textarea>';
				fwrite($f,substr($content,$p1,$p2-$p1));
				fclose($f);
				echo ' Write to '.$split_value.'<br />';
			}
			$p1=$p2+strlen($split_key);
	}
}

echo '<meta charset="utf-8" />';
//拆分后的模板存放路径
define('TARGET_FOLDER','../src/include/template/');


//TODO:将需要分割的[HTML文件名]写在这里，$fileList顺序须与下面的$split_args相对应
$fileList=array('./frame.html','./Open.html','./SinglePost.html','./register.html','./infomation.html');


//TODO:将文件名和对应分割标签写在这里，参数顺序必须与标签顺一致；值留空表示该段不写入到模版
$split_args=array(
    /*分割HTML标准格式页面的参数*/
    array(
	'<!-- head -->' => 'html_head.html',
	'<!-- body -->' => '',
	'<!-- footer -->' => ''),
    /*分割主页的参数*/
    array(
	'<!-- head -->' => '',
	'<!-- logo-field -->' => 'header.html',
	'<!-- postList-field -->' => 'forum.html',
	'<!-- login-link-info-field -->' => 'login.html',
	'<!-- footer -->' => 'footer.html'),
    /*分割单贴页面的参数*/
    array(
	'<!-- head -->' => '',
	'<!-- post-head -->' => 'header_post.html',
	'<!-- post-login-info-field -->' => 'login_post.html',
	'<!-- post-field -->' => 'areaControl.html',
	'<!-- footer -->' => ''),
    /*分割注册页面的参数*/
    array(
	'<!-- head -->' => '',
	'<!-- register-area -->' => 'register.html',
	'<!-- footer -->' => ''),
    /* infomation 暂不分割 */
    array(
    '<!-- head -->' => '',
    '<!-- pic-field -->' => 'information.html',
    '<!-- footer -->' => '')
);


//TODO:将需要[替换的字符]写在这里，如：相对路径替换为绝对路径，调试信息替换为空字符串等
//过滤顺序：绝对字符（如调试信息、完整的HTML标签）->动态信息->相对路径
$replace_args=array(
	'<form id="postForm" name="postForm" method="post" action="?">' => '<form id="postForm" name="postForm" method="post" action="<?php echo $act;?>">',
	'<a class="register-chain" href="./register.html" target="_blank">' => '<a class="register-chain" href="?action=register">',
	'<form onsubmit="javascript:return false;"' => '<form ',
	'./newOPEN.html' => '<?php echo BBS_WEB_ROOT; ?>',
	'./information.html' => '<?php echo "?action=information"; ?>',
	'<span class="login-field-2-name">这里是用户名</span>' => '<span class="login-field-2-name"><?php echo $_SESSION["Name"]; ?></span>',
	'<span class="post-login-field-2-name">这里是用户名</span>' => '<span class="post-login-field-2-name"><?php echo $_SESSION["Name"]; ?></span>',
	'<link rel="stylesheet" href="" type="text/css">' => '',
	'<script src="" type="text/javascript"></script>' => '',
	'src="./' => 'src="<?php echo BBS_WEB_TEMPLATE.\'/\';?>',
	'<a href="./' => '<a href="<?php echo BBS_WEB_ROOT.\'/\';?>',	
	'<link rel="stylesheet" href="./' => '<link rel="stylesheet" href="<?php echo BBS_WEB_TEMPLATE.\'/\'; ?>',
	
);


echo 'Split begin...<br />';

for($i=0; $i<count($fileList); $i++)
{
	echo '<br />Processing on '.$fileList[$i].'<br />';
	$f=fopen($fileList[$i],'rb');
	$content=fread($f,filesize($fileList[$i]));
	fclose($f);
	foreach ($replace_args as $replace_from => $replace_to)
	{
		//根据$replace_args的参数替换相对路径为绝对路径
		$content=str_replace($replace_from,$replace_to,$content);
	}
	if (count($split_args[$i])>0)	//如果提供了分割参数，则进行分割后存储
	{
		splitFile($content,TARGET_FOLDER,$split_args[$i]);
	}
	else	//否则就直接存储
	{
		$f=fopen(TARGET_FOLDER.basename($fileList[$i]),'wb');
		fwrite($f,$content);
		fclose($f);
		echo $fileList[$i].' copied.<br />';
	}
}


echo '<br />Split finished.';
exit(0);
?>
