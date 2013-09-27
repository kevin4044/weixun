<?php
/**
 * 日志列表
 *
 * @version        $Id: log_list.php 1 8:48 2010年7月13日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Log');
require_once(XAKINC."/datalistcp.class.php");
require_once(XAKINC."/common.func.php");
setcookie("ENV_GOBACK_URL",$xakNowurl,time()+3600,"/");
$sql = $where = "";

if(empty($adminid)) $adminid = 0;
if(empty($cip)) $cip = "";
if(empty($dtime)) $dtime = 0;
if($adminid>0) $where .= " AND #@__log.adminid='$adminid' ";
if($cip!="") $where .= " AND #@__log.cip LIKE '%$cip%' ";

if($dtime>0)
{
    $nowtime = time();
    $starttime = $nowtime - ($dtime*24*3600);
    $where .= " AND #@__log.dtime>'$starttime' ";
}
$sql = "SELECT `#@__log`.*,`#@__admin_list`.userid FROM #@__log
     LEFT JOIN `#@__admin_list` ON `#@__admin_list`.id=`#@__log`.adminid
     WHERE 1=1 $where ORDER BY `#@__log`.lid DESC";
$adminlist = "";
$dsql->SetQuery("SELECT id,uname FROM `#@__admin_list`");
$dsql->Execute('admin');
while($myrow = $dsql->GetObject('admin'))
{
    $adminlist .="<option value='{$myrow->id}'>{$myrow->uname}</option>\r\n";
}
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("adminid",$adminid);
$dlist->SetParameter("cip",$cip);
$dlist->SetParameter("dtime",$dtime);
$dlist->SetTemplate(XAKADMIN."/templets/log_list.htm");
$dlist->SetSource($sql);
$dlist->Display();