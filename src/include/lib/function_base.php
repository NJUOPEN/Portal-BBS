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

require_once(BBS_ROOT.'/include/lib/function_UI.php');
?>
