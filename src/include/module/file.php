<?php

define('AVATAR', 1);       // 头像
define('ATTACHMENT', 0);   // 附件


//功能：保存文件
//需要变量：id（用户的或帖子的）、文件名、文件类型、文件内容
//$file_type=1, 头像; $file_type=2, 附件
function save_file($id, $file_name, $file_type, &$file_content)
{
    require_once(BBS_ROOT.'/include/module/SQL.php');

	$file_id=md5(time());//生成文件的md5
	//数据库检验$file_id是否重复，若重复则重新生成，最多重新生成50次
	//TODO: 数据库写入($id,$file_id,$file_name);
	if($file_type==1){
        $user = new SQL_User;
		$ret = $user->resetUserPicture($id,$file_id);
		if($ret == false)
			return false;//保存失败
	}

	$fp=fopen(BBS_USERFILE.$file_id,"wb");
	fwrite($fp, $file_content);
	fclose($fp);
	return true;//保存成功
}


//功能：读取文件
//需要变量：文件md5、文件内容
//文件内容保存在$file_content中
function load_file($file_id,&$file_content)
{
	if(file_exists(BBS_USERFILE.$file_id)==false)
		return -1;//表示文件不存在
	else{
		$fp=fopen(BBS_USERFILE.$file_id,"rb");
		$file_content=fread($fp,filesize($file_id));
		fclose($fp);
		return 1;//读取成功
	}
}


//功能：删除文件
//需要变量：文件md5
function remove_file($file_id)
{
	if(file_exists(BBS_USERFILE.$file_id)==false)
		return -1;//表示文件不存在
	else{
		unlink(BBS_USERFILE.$file_id);
		return 1;//删除成功
	}
}


function upload_file($id,$file_type) {
    if ($_FILES["file"]["error"] > 0) {
	echo "Error: ".$_FILES["file"]["error"]."<br />";
    }
	else {
	$filename = $_FILES["file"]["name"];
	$filetype = $_FILES["file"]["type"];
	$filesize = $_FILES["file"]["size"] / 1024;
	$fileaddr = $_FILES["file"]["tmp_name"];

	/* debug
	echo $filetype."<br />";
	echo $fileaddr."<br />";

	echo "Is uploaded file: ".is_uploaded_file($fileaddr)."<br />";
	 */

	//TODO:确定一个保存路径,以及和数据库的配合
	//move_uploaded_file($fileaddr, BBS_ROOT."/".$filename);
	$fp=fopen($fileaddr,"rb");
	$file_content=fread($fp,filesize($fileaddr));
	fclose($fp);
	unlink($fileaddr);
	$a=save_file($id,$filename,$file_type,$file_content);
	return $a;
    }
}


//备注: 试作型
//功能: 保存用户头像并在数据库中记录
//参数:
//  userID   - number - 用户ID, 即SysID
//  filename - string - 文件名, 不包括路径
//  source   - string - 完整路径, 一般是php缓存的地址
//返回值: 无
function save_avatar($userID, $filename, $source)
{
    require_once(BBS_ROOT.'/include/module/SQL.php');
    $content = file_get_contents($source);
    save_file($userID, $filename, AVATAR, $content);
    //更新$_SESSION
    $user = new SQL_User;
    $all_info = $user->getInfOfUser( $_SESSION['SysID'] );
    $old_avatar = $_SESSION['avatar'];
    $_SESSION['avatar'] = BBS_USERFILE.$all_info['Picture'];
    //删除旧头像
    $old_filename = basename($old_avatar);
    if ($old_filename != 'default-avatar')
    {
        remove_file($old_filename);
    }
}
?>
