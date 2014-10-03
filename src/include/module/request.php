<?php
/*
Project: NJUOPEN/Portal-BBS
Contributor: WHZ
*/

// 统一式样的发送申请的函数
// $dest : 请求目标
// $src  : 来源
// $method : POST 或者 GET
// $argv : POST文本,默认为空

function request($dest, $src, $method, $argv = array()) {
	$flag = 0;
	$post = '';
	$errno = '';
	$errstr = '';
	//构造要post的字符串
	foreach ($argv as $key=>$value) {
		if ($flag!=0) {
			$post .= "&";
		}
		$post.= $key."=";
		$post.= urlencode($value);
		$flag = 1;
	}
	
	$length = strlen($post);
	//创建socket连接
	$response = fsockopen("localhost",80,$errno,$errstr,10) or exit($errstr." ".$errno);
	//构造请求头
	$header  = "$method $dest HTTP/1.1\r\n";
	//TODO 主机地址要修改
	$header .= "Host:127.0.0.1\r\n";
	$header .= "Referer:$src\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: ".$length."\r\n";
	$header .= "Connection: Close\r\n\r\n";
	//添加post文本
	$header .= $post."\r\n";
	
	//发送数据
	fputs($fp,$header);
	
/*是否需要?

	//输出response
	$inheader = 1;
	while (!feof($fp)) {
		$line = fgets($fp); //去除请求包的头只显示页面的返回数据
		if ($inheader && $line == "\r\n") {
			$inheader = 0;
		}
		if ($inheader == 0) {
			echo $line;
		}
	}

*/

	fclose($fp);
}
?>
