<?php
/**
 * 浏览记录
 * 
 * @version        $Id: visit-history.php 1 8:38 2010年7月9日Z
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
$menutype = 'xakmenu';
if(!isset($dopost)) $dopost = '';

require_once(XAKINC."/datalistcp.class.php");
$wsql = '';
if($dopost=='meview')
{
    $wsql = " v.vid='{$cfg_ml->M_ID}' ";
    $tname = "我最近访问";
    $osql="ON v.mid=m.mid ";
}
else
{
    $wsql = " v.mid='{$cfg_ml->M_ID}' ";
    $tname = "关注我的人";
    $osql="ON v.vid=m.mid ";
}
$query = "SELECT v.*,m.sex,face FROM `#@__member_vhistory` AS v  LEFT JOIN `#@__member_list` AS m $osql WHERE $wsql ORDER BY vtime DESC";
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("dopost",$dopost);
$dlist->SetTemplate(XAKMEMBER.'/templets/visit-history.htm');
$dlist->SetSource($query);
$dlist->Display();