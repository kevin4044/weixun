<?php
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_RP广告管理');
require_once XAKINC."/typelink.class.php";
if(empty($dopost))
{
	$dopost = "";
}

if($dopost=="save")
{
	//timeset tagname typeid normbody expbody
	$tagname = trim($tagname);
	if($tagname=='' || $adname=='')
	{
		ShowMsg("广告标识或广告名称不能为空！","-1");
		exit();
	}
	$row = $dsql->GetOne("Select typeid From #@__rpad where typeid='$typeid' And tagname like '$tagname'");
	if(is_array($row))
	{
		ShowMsg("在相同栏目下已经存在同名的标记！","-1");
		exit();
	}
	$starttime = GetMkTime($starttime);
	$endtime = GetMkTime($endtime);
    //将内容数组序列化
	if($adtype=='code')
	{
		$normparams = $htmlcode;
	}
	elseif($adtype=='text')
	{
		$normparams = serialize($text);
	}
	elseif($adtype=='image')
	{
		$normparams = serialize($image);
	}
	elseif($adtype=='slide')
	{
		$normparams = serialize($slide);
	}
	elseif($adtype=='flash')
	{
		$normparams = serialize($flash);
	}
    else
    {
        ShowMsg("未知广告类型！","-1");
		exit();
    }
	$query = "
	 Insert Into #@__rpad(typeid,tagname,adname,timeset,starttime,endtime,adtype,normparams,expbody)
	 Values('$typeid','$tagname','$adname','$timeset','$starttime','$endtime','$adtype','$normparams','$expbody');
	";
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("成功增加一个广告！","rpad_main.php");
	exit();
}
$startDay = time();
$endDay = AddDay($startDay,30);
$startDay = GetDateTimeMk($startDay);
$endDay = GetDateTimeMk($endDay);
include XAKINClude('templets/rpad_add.htm');

?>