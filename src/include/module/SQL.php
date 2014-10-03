<?php
/*
Project: NJUOPEN/Portal-BBS
Type:Model
Contributor:ZFY,WTZ
Software Licence: GPLv2 or later
*/

//此模块加载前，数据库配置信息（主机、用户名、密码、数据库名等）应当已经加载

class SQL_Operator
{
	const SQL_DATE_FORMAT='Y-m-d h:m:s';
	private $tableOfUsers;
	private $tableOfPost;
	
	private $db;
	
	public $OK;//指示当前状态是否正常
	private $state;//指示当前状态，外部不可更改
	
	public function __construct()//构造函数
	{
		$OK=false;	$state=false;
		$db=mysql_connect(SQL_HOST,SQL_ACCOUNT,SQL_PASSWORD);
		if (!$db)  return;
		if (!mysql_select_db(SQL_DB,$db)) return;
		define($tableOfUsers,'BaseInfOfUsers');
	        define($tableOfPost,'PostOfUsers');
		$OK=true;	$state=true;
	}
	public function checkTable($tableName)//检测表是否存在；若不存在，则创建之；返回值：true/false
	{
		mysql_query('CREATE TABLE IF NOT EXISTS '.$tableName.';',$db);
		if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tableName."'",$db)==1)
			return true;
		else
			return false;
	}
	public function get($tableName,$fieldName,$value) //返回值：字符串数组
	{
		if (!$state) return NULL;
		if (!checkTable($tableName)) return NULL;
		$hResult=mysql_query('SELECT * FROM '.$tableName.';',$db);//返回SQL查询结果的资源ID
		$result=array();//用于存放查询结果的数组
		while($temp=mysql_fetch_array($hResult))//判断每次取出的记录是否为空
		{
			array_push($result,$temp);
		}
		return $result;
	}
	public function getInfOfPost($idOfPost){//返回帖子的信息
	       if(!$state)return null;
	       $IDofUser=mysql_query('select * from '.$tableOfPost.' where PostID='.$idOfPost.';',$db);
	       $result=array();
	       while($temp=mysql_fetch_array($IDofUser))
		{
			array_push($result,$temp);
		}
		return $result;
	}
	public function getInfOfUser($idOfUser){//返回知道ID的用户的所有信息：字符串数组
		if(!$state)return null;
		$hResult=mysql_query('select * from '.$tableOfUsers.' where SysID='.$idOfUser.';',$db);
		$result=array();
	       while($temp=mysql_fetch_array($hResult))
		{
			array_push($result,$temp);
		}
		return $result;
	}
	public function delectUser($IDOfUser){//删除知道ID的用户
		if(!$state)return null;
		mysql_query('delect from '.$tableOfUsers.' where SysID='.$IDOfUser.';',$db);
	
		
	}
	public function delectPost($IDofPost){//删除知道ID的帖子
		if(!$state)return null;
        	mysql_query('delect from '.$tableOfPost.' where Name='.$IDofPost.';',$db);

	}
	public function writePost($ID,$Time,$IDofUser,$ifFollow,$addOfPost,$numOfFellow,$idOfFellow){//发帖
		if(!$state)return null;
		$num=getTotalNumOfPost();
		mysql_query('insert into '.$tableOfPost.' values('.$ID.','.$IDofUser.','.$Time.$ifFollow.','.$addOfPost.','.$numOfFellow.','.$idOfFellow.');',$db);
	}
	public function addUser(){//新建用户
		if(!$state)return null;
		mysql_query('insert into '.$tableOfUsers);
	}
	public function resetUserName($idOfUser,$name){//更改用户名
				if(!$state)return null;
		mysql_query('update '.$tableOfUsers.' set Name='.$name.' where SysID='.$idOfUser.';');	
	}
	public function resetUserCode($idOfUser,$code){//更改密码
			if(!$state)return null;
		mysql_query('update '.$tableOfUsers.' set Code='.$code.' where SysID='.$idOfUser.';');		
	}
	public function resetUserRank($idOfUser,$rank){//更改排名
			if(!$state)return null;
	
		mysql_query('update '.$tableOfUsers.' set Rank='.$rank.' where SysID='.$idOfUser.';');
	}
	public function resetUserRoot($idOfUser,$root){//更改权限
			if(!$state)return null;
		mysql_query('update '.$tableOfUsers.' set Root='.$root.' where SysID='.$idOfUser.';');	
		
	}
	public function resetUserPicture($idOfUser,$picture){//更改头像
			if(!$state)return null;
	
		mysql_query('update '.$tableOfUsers.' set Picture='.$picture.' where SysID='.$idOfUser.';');
	}
	public function resetPost($idOfPost){//更新更贴数目
		if(!$state)return null;
		$InfOfPost=getInfOfPost($idOfPost);
		$NumOfPost=(int)$InfOfPost[5];
		$NumOfPost=$NumOfPost+1;
		mysql_query('update '.$tableOfPost.' set FellowNum='.$NumOfPost.' where PostID='.$idOfPost.';');
	}
	public function getTotalNumOfPost(){//统计总的帖子数目
		if(!$state)return null;
		$count=mysql_query('select count(PostID) from '.$tableOfPost.';',$db);
		$result=array();
	       while($temp=mysql_fetch_array($count))
		{
			array_push($result,$temp);
		}
		return $result;
	}

	
	
}
