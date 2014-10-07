<?php

define("USERFILE","./userfile/");

//需要变量：id（用户的或帖子的）、附件名、附件类型、附件内容
//$file_type=1,头像；$file_type=2,附件
function save_file($id,$file_name,$file_type,$file_content)
{
	$file_id=md5(time());//生成附件的md5
	//数据库检验$file_id是否重复，若重复则重新生成，最多重新生成50次
	//数据库写入($id,$file_name,$file_type,$file_id);
	$fp=fopen(USERFILE.$file_id,"wb");
	fwrite($fp,$file_content);
	fclose($fp);
	return true;
}

//需要变量：附件md5、附件内容
//附件内容保存在$file_content中
function load_file($file_id,&$file_content)
{
	if(file_exists(USERFILE.$file_id)==false)
		return -1;//表示文件不存在
	else{
		$fp=fopen(USERFILE.$file_id,"rb");
		$file_content=fread($fp,filesize($file_id));
		fclose($fp);
		return 1;
	}
}

//需要变量：附件md5
function remove_file($file_id)
{
	if(file_exists(USERFILE.$file_id)==false)
		return -1;//表示文件不存在
	else{
		unlink(USERFILE.$file_id);
		return 1;//删除成功
	}
}
?>