<?php
/**
 * 管理一个模板
 *
 * @version        $Id: templets_one.php 1 23:07 2010年7月20日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('temp_One');
require_once(XAKINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$xakNowurl,time()+3600,"/");

$addquery = '';
$keyword = (!isset($keyword) ? '' : $keyword);
$likeid = (!isset($likeid) ? '' : $likeid);
$addq = $likeid!='' ? " AND likeid LIKE '$likeid' " : '';
$sql = "SELECT aid,title,ismake,uptime,filename,likeid FROM `#@__sgpage` WHERE title LIKE '%$keyword%' $addq ORDER BY aid DESC";
$dlist = new DataListCP();
$dlist->SetTemplet(XAKADMIN."/templets/templets_one.htm");
$dlist->SetSource($sql);
$dlist->display();

function GetIsMake($im)
{
    return $im==1 ? '需编译' : '不编译';
}