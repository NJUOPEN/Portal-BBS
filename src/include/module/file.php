<?php

//功能：保存文件
//需要变量：存放文件内容的变量
function save_file(&$file_content)
{
	$file_id=md5(time());//生成文件的md5
    //检验$file_id是否重复，若重复则重新生成，最多重新生成50次
    $count=0;
    while(file_exists(BBS_USERFILE.$file_id) && $count<50)
    {
        $count++;
        $file_id=md5(time());
    }
    if (file_exists(BBS_USERFILE.$file_id)) return null;

	$fp=fopen(BBS_USERFILE.$file_id,"wb");
	fwrite($fp, $file_content);
	fclose($fp);
	return $file_id;//保存成功
}


//功能：读取文件
//需要变量：文件id、用于存放文件内容的变量
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
//需要变量：文件id
function remove_file($file_id)
{
	if(file_exists(BBS_USERFILE.$file_id)==false)
		return -1;//表示文件不存在
	else{
		unlink(BBS_USERFILE.$file_id);
		return 1;//删除成功
	}
}


function upload_file() {
	if (!isset($_SESSION['SysID'])) return;
	if (empty($_FILES)) return;
	$userID=$_SESSION['SysID'];
    if ($_FILES["file"]["error"] > 0) {
	echo "Error: ".$_FILES["file"]["error"]."<br />";
    }
	else {
	$filename = $_FILES["file"]["name"];
	$filetype = $_FILES["file"]["type"];
	$filesize = $_FILES["file"]["size"] / 1024;
	$fileaddr = $_FILES["file"]["tmp_name"];


	//TODO:确定一个保存路径,以及和数据库的配合
	//move_uploaded_file($fileaddr, BBS_ROOT."/".$filename);
	$fp=fopen($fileaddr,"rb");
	$file_content=fread($fp,filesize($fileaddr));
	fclose($fp);
	$file_id=save_file($file_content);
	unlink($fileaddr);
	return $file_id;
    }
}


//备注: 试作型
//功能: 保存用户头像并在数据库中记录
//  userID   - number - 用户ID, 即SysID
//  filename - string - 文件名, 不包括路径
//  source   - string - 完整路径, 一般是php缓存的地址
//返回值: 无
function save_avatar()
{
	if (!isset($_SESSION['SysID'])) return;
	if (empty($_FILES)) return;
	$userID=$_SESSION['SysID'];
	$source=$_FILES['imgUP']['tmp_name'];
    $content = file_get_contents($source);
    $file_id=save_file($content);
    unlink($source);
    if ($file_id == null) return;

    require_once(BBS_ROOT.'/include/module/SQL.php');
    $user = new SQL_User;
    $user->resetUserPicture($userID,$file_id);

    //更新$_SESSION
    $old_avatar = $_SESSION['avatar'];
    $_SESSION['avatar'] = BBS_WEB_USERFILE.$file_id;
    //删除旧头像
    $old_filename = basename($old_avatar);
    if ($old_filename != 'default-avatar')
    {
        remove_file($old_filename);
    }
}
?>
