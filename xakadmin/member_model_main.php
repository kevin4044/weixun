<?php
/**
 * 会员模型管理
 *
 * @version        $Id: member_model_main.php 1 11:24 2010年7月20日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Type');
require_once(XAKINC."/datalistcp.class.php");
require_once(XAKINC."/common.func.php");
setcookie("ENV_GOBACK_URL",$xakNowurl,time()+3600,"/");
function GetTotalMember($mtable=''){
    global $dsql;
    if($dsql->IsTable($mtable)){
        $row =$dsql->GetOne("SELECT COUNT(*) AS nums FROM {$mtable}");
        return empty($row['nums'])? "0" : $row['nums'];        
    }else{
        return '0';
    }
}

$sql = "SELECT `id`,`name`,`table`,`description`,`state`,`issystem` FROM `#@__member_model` ORDER BY id ASC";
$dlist = new DataListCP();
$dlist->SetTemplet(XAKADMIN."/templets/member_model_main.htm");
$dlist->SetSource($sql);
$dlist->display();
$dlist->Close();