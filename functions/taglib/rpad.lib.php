<?php

if(!defined('XAKINC')) exit('Warning...');
require_once(XAKINC.'/taglib/mytag.lib.php');
require_once(XAKROOT.'/module/rpad/rpad_func.php');

function lib_rpad(&$ctag, &$refObj)
{
	$attlist = "typeid|0,name|";
	FillAttsDefault($ctag->CAttribute->Items,$attlist);
	extract($ctag->CAttribute->Items, EXTR_SKIP);

	global $dsql;
	if($name=='') return '';
	if(trim($typeid)=='') $typeid=0;
	if( !empty($refObj->Fields['typeid']) && $typeid==0) $typeid = $refObj->Fields['typeid'];

	$typesql = $row = '';
	if($typeid > 0) $typesql = " And typeid in(0,".GetTopids($typeid).") ";
	else $typesql = " AND typeid=0 ";
	$row = $dsql->GetOne(" Select * From `#@__rpad` where tagname like '$name' $typesql order by typeid desc ");
	if(!is_array($row)) return '';

    $body='';
	$nowtime = time();
	if($row['timeset']==1 && ($nowtime<$row['starttime'] || $nowtime>$row['endtime']) )
	{
		$body = $row['expbody'];
	}
	else
	{
        $body = rpadParser($row['adtype'],$row['normparams']);
	}

	return $body;
}

?>