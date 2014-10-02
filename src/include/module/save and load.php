<?php

define("USERFILE","./userfile/");

//需要变量：用户id、附件名、附件类型、附件内容
//$file_type=1,头像；$file_type=2,附件
function save_userfile($user_id,$file_name,$file_type,$file_content)
{
	$file_id=md5(time());
	//数据库检验$file_id是否重复，若重复则重新生成，最多重新生成50次
	//数据库写入($user_id,$file_name,$file_type,$file_id);
	$fp=fopen(USERFILE.$file_id,"wb");
	fwrite($fp,$file_content);
	fclose($fp);
	return true;
}

//需要变量：用户id、附件名、附件类型、附件内容
//附件内容保存在$file_content中
//$file_type=1,头像；$file_type=2,附件
function load_userfile($user_id,$file_name,$file_type,&$file_content)
{
	//根据$user_id和$file_name从数据库读出$file_id
	if(file_exists(USERFILE.$file_id)==false)
		return -1;//表示文件不存在
	else{
		$fp=fopen(USERFILE.$file_id,"rb");
		$file_content=fread($fp,filesize($file_id));
		fclose($fp);
		return 1;
	}
}
?>