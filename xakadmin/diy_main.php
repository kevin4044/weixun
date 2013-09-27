<?php
/**
 * 自定义表单列表管理
 *
 * @version        $Id: diy_main.php 1 18:31 2010年7月12日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('c_List');
require_once(XAKINC."/datalistcp.class.php");
require_once(XAKINC."/common.func.php");
setcookie("ENV_GOBACK_URL",$xakNowurl,time()+3600,"/");
$sql = "Select `diyid`,`name`,`table` From #@__diyforms order by diyid asc";
$dlist = new DataListCP();
$dlist->SetTemplet(XAKADMIN."/templets/diy_main.htm");
$dlist->SetSource($sql);
$dlist->display();
$dlist->Close();