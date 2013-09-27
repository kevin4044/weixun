<?php
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_RP广告管理');
require_once(XAKINC.'/typelink.class.php');
if(empty($dopost))
{
	$dopost = '';
}
$aid = ereg_replace('[^0-9]','',$aid);
$ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? "rpad_main.php" : $_COOKIE['ENV_GOBACK_URL'];

if($dopost=='del')
{
	include XAKINClude('templets/rpad_del.htm');
	exit();
}
if($dopost=='delete')
{
	if($okdel=='xak.cn')
	{
		$dsql->ExecuteNoneQuery("Delete From `#@__rpad` where aid='$aid' ");
		ShowMsg("成功删除一则广告代码！",$ENV_GOBACK_URL);
		exit();
	}
	else
	{
		ShowMsg("删除确认码不正确！",$ENV_GOBACK_URL);
		exit();
	}
}
else if($dopost=="getjs")
{
	require_once(XAKINC.'/oxwindow.class.php');
	$jscode = "<script src='{$cfg_phpurl}/rpad/js.php?aid=$aid' language='javascript'></script>";
	$showhtml = "<xmp style='color:#333333;background-color:#ffffff'>\r\n\r\n$jscode\r\n\r\n</xmp>";
	$showhtml .= "预览：<iframe name='testfrm' frameborder='0' src='rpad_edit.php?aid={$aid}&dopost=testjs' id='testfrm' width='100%' height='200'></iframe>";
	$wintitle = "广告管理-获取JS";
	$wecome_info = "<a href='rpad_main.php'><u>广告管理</u></a>::获取JS";
	$win = new OxWindow();
	$win->Init();
	$win->AddTitle("以下为选定广告的JS调用代码：");
	$winform = $win->GetWindow("hand",$showhtml);
	$win->Display();
	exit();
}
else if($dopost=='testjs')
{
	echo "<script src='{$cfg_phpurl}/rpad/js.php?aid=$aid&nocache=1' language='javascript'></script>";
	exit();
}
else if($dopost=='saveedit')
{
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
	$query = "Update `#@__rpad`
	 set
	 typeid='$typeid',
	 adname='$adname',
	 timeset='$timeset',
	 starttime='$starttime',
	 endtime='$endtime',
     adtype='$adtype',
	 normparams='$normparams',
	 expbody='$expbody'
	 where aid='$aid'
	 ";
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("成功更改一则广告代码！",$ENV_GOBACK_URL);
	exit();
}
$row = $dsql->GetOne("Select * From `#@__rpad` where aid='$aid'");
$codeparams = $slideparams = $flashparams = $imageparams = $textparams = array();
if($row['adtype'] == 'code')
{
    $codeparams['code'] = $row['normparams'];
}
else if($row['adtype'] == 'slide')
{
    $slideparams = unserialize($row['normparams']);
}
else if($row['adtype'] == 'flash')
{
    $flashparams = unserialize($row['normparams']);
}
else if($row['adtype'] == 'image')
{
    $imageparams = unserialize($row['normparams']);
}
else if($row['adtype'] == 'text')
{
    $textparams = unserialize($row['normparams']);
}
include XAKINClude('templets/rpad_edit.htm');

?>