<?php
/**
 * 插件管理
 *
 * @version        $Id: plus_main.php 1 15:46 2010年7月20日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_plus');
require_once(XAKINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$xakNowurl,time()+3600,"/");

$sql = "SELECT aid,plusname,writer,isshow FROM #@__plus ORDER BY aid ASC";
$dlist = new DataListCP();
$dlist->SetTemplet(XAKADMIN."/templets/plus_main.htm");
$dlist->SetSource($sql);
$dlist->display();

function GetSta($sta,$id,$title)
{
    if($sta==1)
    {
        return " &nbsp; <a href='plus_edit.php?dopost=edit&aid=$id'><u>修改</u></a> &nbsp; 启用  &gt; <a href='plus_edit.php?dopost=hide&aid=$id'><u>禁用</u></a> &nbsp; <a href='plus_edit.php?dopost=delete&aid=$id&title=".urlencode($title)."'><u>删除</u></a>";
    }
    else
    {
        return " &nbsp; <a href='plus_edit.php?aid=$id'><u>修改</u></a> &nbsp; 禁用 &gt; <a href='plus_edit.php?dopost=show&aid=$id'><u>启用</u></a> &nbsp; <a href='plus_edit.php?dopost=delete&aid=$id&title=".urlencode($title)."'><u>册除</u></a>";
    }
}