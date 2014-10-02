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
	
	private $db;
	
	public $OK;//指示当前状态是否正常
	private $state;//指示当前状态，外部不可更改
	
	public function __construct()//析构函数
	{
		$OK=false;	$state=false;
		$db=mysql_connect(SQL_HOST,SQL_ACCOUNT,SQL_PASSWORD);
		if (!$db)  return;
		if (!mysql_select_db(SQL_DB,$db)) return;
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
}