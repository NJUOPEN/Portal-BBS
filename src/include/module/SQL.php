<?php
/*
Project: NJUOPEN/Portal-BBS
Contributor:ZFY,WTZ
Note:
本模块包含SQL操作类，利用下列的类可以对用户、贴子等具体信息进行操作；

<类继承关系图>
SQL_Operator：临时类，外部请勿使用；待设计完善后须删除；
SQL_Obj(基类，包含基本的添加[add]、读取[get]、写入[set]、删除[delete]记录的操作)
 |
 |--SQL_Info(信息操作类，用于需要频繁读取，但不需要频繁更新的内容)
 |   |--SQL_User(用户信息管理)
 |   |--SQL_Area(板块管理)
 |
 |--SQL_Msg(消息操作类,用于需要频繁读取和更新的内容)
 |   |--SQL_Post(贴子管理)
 |
 |--SQL_Log(日志操作类，需要频繁写入，但不需要频繁读取的内容)
     |--SQL_SysLog(系统日志管理)

********************************************************
 外部应当只使用SQL_User、SQL_Area、SQL_Post、SQL_SysLog，
                避免破坏对SQL操作的封装。
********************************************************
*/

/*
此模块被加载前，以下常量应当已经初始化：
	SQL_HOST:数据库IP地址；
	SQL_ACCOUNT：数据库用户名；
	SQL_PASSWORD：数据库密码；
	SQL_DB：数据库名；
*/


class SQL_Obj
{
	const SQL_DATE_FORMAT='Y-m-d h:m:s';
	
	protected $db; //数据库对象的句柄
	
	public $OK;//指示当前状态是否正常
	private $state;//指示当前状态，外部不可更改
	
	public function __construct() //构造函数，初始化SQL接口并设置状态变量($OK,$state)
	{
		$this->OK=false;	$this->state=false;
		/*
		$this->db=mysql_connect(SQL_HOST,SQL_ACCOUNT,SQL_PASSWORD);
		if (!$this->db)  return;
		if (!mysql_select_db(SQL_DB,$this->db)) return;
		*/
		$this->db = mysqli_connect(SQL_HOST, SQL_ACCOUNT, SQL_PASSWORD, SQL_DB);
		if ($this->db == null)
		{
			return;
		}
		$this->OK=true;
		$this->state=true;
	}
	
	protected function checkTable($tableName) //检测表是否存在；若不存在，则创建之；返回值：true/false
	{
		if (!$this->state) return false;
		mysqli_query($this->db, 'CREATE TABLE IF NOT EXISTS '.$tableName.';');
		if(mysqli_num_rows(mysqli_query($this->db, "SHOW TABLES LIKE '".$tableName."'"))==1)
			return true;
		else
			return false;
	}
	
	protected static function resourceToArray($resID) //将SQL查询返回的资源ID转变成可用的字符串数组;若查询失败则返回NULL
	{
		if (!$resID) return NULL;
		$result=array();//用于存放查询结果的数组
		while($temp=mysqli_fetch_array($resID))//判断每次取出的记录是否为空
		{
			array_push($result,$temp);
		}
		return $result;	
	}
	
	protected static function buildCondition($fieldName,$fieldValue)
	{
	/*
	    功能：
	    通过字段名与给定值之间的关系来构建查询条件（WHERE子句）；
		参数:
			$fieldName:要进行比较的字段；
			$fieldValue:要进行比较的值；
		返回值：
			构建好的查询条件（单个）；
	*/
		if ($fieldName==NULL || $fieldName=='')
		{
			return '';
		}
		else
		{
			return ' WHERE `'.$fieldName.'` = \''.$fieldValue.'\'';
		}
	}
	
	protected static function buildConditions($fieldList)
	{
	/*	
		功能：
			通过字段名与给定值之间的关系来构建查询条件（WHERE子句）；
		参数:
			$fieldList:要进行比较的条件数组，其中每一个元素都应包括如下的MAP结构：
				name：字段名称；
				condition：比较条件，可以是'>  =  <  >=  <=  !='中的任何一个；
				value：进行比较的值（string类型）；
				//TODO：还可以添加不同比较之间的逻辑关系，如AND、OR、NOT；
		返回值：
			构建好的查询条件（多个）
	*/
		foreach ($fieldList as $field)
		{
			if ($field['name']!='' && $field['value']!='')
				$condition.='`'.$field['name'].'`'.$field['condition'].'\''.$field['value'].'\' AND ';
				//这里使用单引号界定记录值，插入前需要做好转义工作！！！
		}
		if ($condition=='')
			return '';
		else
			return ' WHERE '.substr($condition,0,strlen($condition)-5);//截去末尾多余的' AND '
	}
	
	protected function addRecord($tableName,$value)
	{
	/*	
		功能：
			添加一条记录；
		参数:
			$tableName:需要操作的表的名称；
			$value:要添加的记录；
		返回值：
			true/false：操作成功或失败；
	*/
		if (count($value)<1) return false;
		if (!$this->checkTable($tableName)) return false;
		$query='INSERT INTO `'.$tableName.'` (';
		foreach (array_keys($value) as $temp) {
			$query.='`'.$temp.'`,'; //这里使用反引号来界定字段名
		}
		if (substr($query,-1)==',') $query=substr($query,0,strlen($query)-1);
		$query.=') VALUES (';
		foreach (array_values($value) as $temp) {
			$query.='\''.$temp.'\','; //这里使用单引号界定记录值，插入前需要做好转义工作！！！
		}
		if (substr($query,-1)==',') $query=substr($query,0,strlen($query)-1);
		$query.=');';
		mysql_query($query,$this->db);
		if (mysql_affected_rows()>0) return true; else return false;
	}
	
	protected function getRecordByField($tableName,$fieldName,$value) 
	{
	/*	
		功能：
			查找具有与给定值相等的某个字段的记录；
		参数:
			$tableName:需要操作的表的名称；
			$fieldName:要进行比较的字段名称；
			$value:要进行比较的值；
		返回值：
			记录数组，每一个记录对应数组中的每一个元素
	*/
		if (!$this->checkTable($tableName)) return NULL;
		return self::resourceToArray(mysqli_query($this->db, 'SELECT * FROM `'.$tableName.'`'.self::buildCondition($fieldName,$value).';'));
	}
	
	protected function setRecordByField($tableName,$fieldName,$value,$record) 
	{
	/*	
		功能：
			查找具有与给定值相等的某个字段的记录，并更新该记录；
		参数:
			$tableName:需要操作的表的名称；
			$fieldName:要进行比较的字段名称；
			$value：要进行比较的值；
			$record：新的记录值（包含所有字段）；
		返回值：
			true/false：操作成功或失败；
	*/
		if (count($record)<1) return false;
		if (!$this->checkTable($tableName)) return false;
		$query='UPDATE FROM `'.$tableName.'`(';
		foreach (array_keys($value) as $temp)
		{
			$query.='`'.$temp.'`,';
		}
		if (substr($query,-1)==',') $query=substr($query,0,strlen($query)-1);
		$query.=') VALUES(';
		foreach (array_values($value) as $temp)
		{
			$query.='\''.$temp.'\',';
		}
		if (substr($query,-1)==',') $query=substr($query,0,strlen($query)-1);
		$query.=')'.self::buildCondition($fieldName,$value).';';
		mysql_query($query,$this->db);
		if (mysql_affected_rows()>0) return true; else return false;
	}
	
	protected function setFieldByField($tableName,$fieldName,$value,$newFieldName,$newFieldValue) 
	{
	/*	
		功能：
			查找具有与给定值相等的某个字段的记录，并更新该记录的指定字段；是setRecordByField的简化版；
		参数:
			$tableName:需要操作的表的名称；
			$fieldName:要进行比较的字段名称；
			$value:要进行比较的值；
			$newFieldName：需要更新的字段名称（单个字段）；
			$newFieldName：需要更新的字段的值；
		返回值：
			true/false：操作成功或失败；
	*/
		if (!$this->checkTable($tableName)) return false;
		mysql_query('UPDATE `'.$tableName.'` SET `'.$newFieldName.'` = \''.$newFieldValue.'\''.self::buildCondition($fieldName,$value).';',$this->db);
		if (mysql_affected_rows()>0) return true; else return false;
	}
	
	protected function deleteRecordByField($tableName,$fieldName,$value) 
	{
	/*	
		功能：
			查找具有与给定值相等的某个字段的记录，并删除该记录；
		参数:
			$tableName:需要操作的表的名称；
			$fieldName:要进行比较的字段名称；
			$value:要进行比较的值；
		返回值：
			true/false：操作成功或失败；
	*/
		if (!$this->checkTable($tableName)) return false;
		mysql_query('DELETE FROM `'.$tableName.'`'.self::buildCondition($fieldName,$value).';',$db);
		if (mysql_affected_rows()>0) return true; else return false;
	}
	protected function countRecordByField($tableName,$fieldName,$value)
	{
	/*	
		功能：
			查找具有与给定值相等的某个字段的记录，并统计记录的个数；
		参数:
			$tableName:需要操作的表的名称；
			$fieldName:要进行比较的字段名称；
			$value:要进行比较的值；
		返回值：
			整数表示的记录个数；
	*/
		if (!$this->checkTable($tableName)) return false;
		$count=self::resourceToArray(mysql_query('SELECT COUNT(`'.$fieldName.'`) FROM `'.$tableName.'`'.self::buildCondition($fieldName,$value).';',$this->db));
		return (int)$count[0][0];
	}
}

class SQL_Info extends SQL_Obj
{
	/*
		功能：
			根据某个字段的值是否相等来查找记录
		参数:
			$tableName:需要操作的表的名称；
			$fieldList:要进行比较的字段列表数组，其中每一个元素都应包括如下的MAP结构：
				name：字段名称；
				condition：比较条件，可以是'> = < >= <= !='中的任何一个；
				value：进行比较的值（string类型）；
				//TODO：还可以添加不同比较之间的逻辑关系，如AND、OR、NOT；
		返回值：（同getRecordByField）			
	*/
	protected function getRecordByFields($tableName,$fieldList)  //根据某几个字段的值是否相等来查找记录
	{
		if (!$this->checkTable($tableName)) return NULL;
		$query='SELECT * FROM `'.$tableName.'`'.buildConditions($fieldList);
		return self::resourceToArray(mysql_query($query,$this->db));
	}
}

class SQL_Msg extends SQL_Obj
{
	/*
		功能：
			将满足给定条件的记录按给定字段排序，并返回前数个记录
		参数:
			$tableName:需要操作的表的名称；
			$fieldName:要进行排序的字段；
			$descendent:(可选)是否为降序排列；
			$count:(可选)记录的个数；
			$conditions:(可选)限定条件的数组，其中每个元素都应包括如下的MAP结构：
				name：字段名称；
				condition：比较条件，可以是'> = < >= <= !='中的任何一个；
				value：进行比较的值（string类型）；
				//TODO：还可以添加不同比较之间的逻辑关系，如AND、OR、NOT；
		返回值：（同getRecordByField）			
	*/
	protected function getTopRecord($tableName,$fieldName,$descendent=true,$count=-1,$conditions=null)  //
	{
		if (!$this->checkTable($tableName)) return NULL;
		$query='SELECT * FROM `'.$tableName.'` ';		
		if ($conditions) $query.=self::buildConditions($conditions);
		$query.=' ORDER BY `'.$fieldName.'` '.($descendent?'DESC':'ASC').';';		
		if ($count>=0 && $count != NULL && is_numeric($count))	{
		    $query.=' LIMIT '.$count;
		}
		return self::resourceToArray(mysqli_query($this->db, $query));
	}
}

class SQL_Log extends SQL_Obj
{
}

class SQL_User extends SQL_Info //用户操作类
{
	private $tableOfUsers='BaseInfOfUsers';
	
	public function getInfOfUser($idOfUser){//返回知道ID的用户的所有信息：字符串数组
		$result=$this->getRecordByField($this->tableOfUsers,'SysId',$idOfUser);
		if (count($result)>0) return $result[0]; else return NULL; //只返回满足条件的第一个记录
	}
	public function getInfOfUserByName($nameOfUser){//返回知道Name的用户的所有信息：字符串数组
		$result=$this->getRecordByField($this->tableOfUsers,'Name',$nameOfUser);
		if (count($result)>0) return $result[0]; else return NULL; //只返回满足条件的第一个记录
	}
	public function delectUser($IDOfUser){//删除知道ID的用户
		return $this->deleteRecordByField($this->tableOfUsers,'SysId',$IDOfUser);
	}	
	public function addUser($Name ,$Code ,$Picture ,$Root ,$Rank ,
$Email ,$Gender ,$Age ){//新建用户
		//FIXME:请将用户信息放到一个统一的class中，参数太多不便于调用
		return $this->addRecord($this->tableOfUsers,array('Name'=>$Name,'Code'=>$Code,'Picture'=>$Picture,'Root'=>$Root,'Rank'=>$Rank,'Email'=>$Email,'Gender'=>$Gender,'Age'=>$Age));
	}
	public function resetUserName($idOfUser,$name){//更改用户名
		return $this->setFieldByField($this->$tableOfUsers,'SysID',$idOfUser,'Name',$name);
	}
	public function resetUserCode($idOfUser,$code){//更改密码
		return $this->setFieldByField($this->tableOfUsers,'SysID',$idOfUser,'Code',$code);
	}
	public function resetUserRank($idOfUser,$rank){//更改排名
		return $this->setFieldByField($this->tableOfUsers,'SysID',$idOfUser,'Rank',$rank);
	}
	public function resetUserRoot($idOfUser,$root){//更改权限
		return $this->setFieldByField($this->tableOfUsers,'SysID',$idOfUser,'Root',$root);		
	}
	public function resetUserPicture($idOfUser,$picture){//更改头像
		return $this->setFieldByField($this->tableOfUsers,'SysID',$idOfUser,'Picture',$picture);
	}
}

class SQL_Area extends SQL_Info //板块操作类
{
}

class SQL_Post extends SQL_Msg //贴子操作类
{
	private $tableOfPost='PostOfUsers';



	//FIXME:刷新跟贴数不起作用
	private function resetPost($idOfPost) {//更新跟贴数目
		$num=$this->countRecordByField($this->tableOfPost,'FollowAdd',$idOfPost);
		return $this->setFieldByField($this->tableOfPost,'PostID',$idOfPost,'FollowNum',$num+1);
	}

	public function delectPost($IDofPost) {//删除知道ID的帖子
		return $this->deleteRecordByField($this->tableOfPost,'PostID',$IDofPost);
	}
	
	public function writePost($IDofUser,$Time,$Title,$content,$isFollow=false,$idOfFollow='0') {//发帖
		//FIXME:请将贴子信息放到一个统一的class中，参数太多不便于调用
		if ($isFollow) {
			if (!$this->resetPost($idOfFollow)) return false;
		}
		$result = $this->addRecord($this->tableOfPost,array('IDofUsers'=>$IDofUser,'Time'=>$Time,'IfFollow'=>$isFollow?'1':'0','Title'=>$Title,'PostAdd'=>$content,'FollowNum'=>0,'FollowAdd'=>$idOfFollow));
		if ($result) return true;
		else {
			echo 'Failed<br/>';
			return false;
		}
	}
	public function setPost($PostID,$IDofUser,$Time,$Title,$content,$isFollow=false,$idOfFollow='0') {//修改帖子
		//FIXME:请将贴子信息放到一个统一的class中，参数太多不便于调用	
		if ($isFollow) {
			if (!$this->resetPost($idOfFollow)) return false;
		}
		$result = $this->setRecordByField($this->tableOfPost,'PostID',$PostID,array('IDofUsers'=>$IDofUser,'Time'=>$Time,'IfFollow'=>$isFollow?'1':'0','Title'=>$Title,'PostAdd'=>$content,'FollowAdd'=>$idOfFollow));
		if ($result) return true;
		else {
			echo 'Failed<br/>';
			return false;
		}
	}
	public function getPost($IDofPost) {
		$postList=$this->getRecordByField($this->tableOfPost,"PostID",$IDofPost);
		if (count($postList)>0) return $postList[0]; else return NULL;
	}

	public function getPostByTitle($title) {
		$postList=$this->getRecordByField($this->tableOfPost,"Title",$title);
		if (count($postList)>0) return $postList[0]; else return NULL;
	}

	public function getTotalNumOfPost() {
		return $this->countRecordByField($this->tableOfPost,NULL,NULL);
	}

	public function getLastInfofPost($number) {
		return $this->getTopRecord($this->tableOfPost,'PostID',true,$number,array(array('name'=>'IfFollow','condition'=>'=','value'=>'0')));
	}

	public function getFollowedList($FollowAdd) {
		return $this->getRecordByField($this->tableOfPost,"FollowAdd",$FollowAdd);
	}

}

class SQL_SysLog extends SQL_Log //系统日志操作类
{
}
