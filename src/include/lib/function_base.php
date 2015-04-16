<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor:WTZ
 * Filename: function_base.php
 */

function __add_to_list(&$list,$item)
{
	if (!in_array($item,$list)) array_push($list,$item);
}

/*
	功能：
		生成分页页码
	参数：
		$current:当前页码
		$total:总页码
		$limit:允许显示的页码数
		$ellipsis:(可选)用于显示省略页的记号
	返回值：
		包含所有页码的数组（string型）
*/
function pagination($current,$total,$limit,$ellipsis='...')
{
	$left=$current-floor($limit/2);
	if ($left<1) $left=1;
	$right=$current+ceil($limit/2);
	if ($right>$total) $right=$total;
	
	$list=array();
	if ($left>1) array_push($list,$ellipsis);
	for($i=$left;$i<=$right;$i++)
	{
		array_push($list,(string)$i);
	}
	if ($right<$total) array_push($list,$ellipsis);
	return $list;	
}

/*
	功能：
		判断数值是否为自然数，并返回有效值（用于解析传入的$params）
	参数：
		$var:待分析值
		$default:当$var无效时采用的默认值
	返回值：
		有效的自然数（int型）
*/
function getNatureNumber(&$var,$default)
{
	if (isset($var) && $var!=NULL)
		if ((int)$var < 1)	return $default; else return (int)$var;
	else
		return $default;	
}

require_once(BBS_ROOT.'/include/lib/function_UI.php');
?>
