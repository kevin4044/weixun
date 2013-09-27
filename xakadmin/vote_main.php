<?php
/**
 * 投票管理
 *
 * @version        $Id: vote_main.php 1 23:54 2010年7月20日Z 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(XAKINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$xakNowurl,time()+3600,"/");
$sql = "SELECT aid,votename,starttime,endtime,totalcount,isenable FROM #@__vote ORDER BY aid DESC";
$dlist = new DataListCP();
$issel = isset($issel) ? $issel : 0;
$aid = isset($aid) ? $aid : 0;
if($issel == 1)
{
    $dlist->SetParameter('issel',$issel);
    $dlist->SetTemplet(XAKADMIN."/templets/vote_select.htm");
} else {
    $dlist->SetTemplet(XAKADMIN."/templets/vote_main.htm");
}
$dlist->SetSource($sql);
$dlist->display();