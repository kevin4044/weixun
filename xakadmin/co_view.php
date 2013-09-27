<?php
/**
 * @version        $Id: co_url.php 1 14:31 2010年7月12日Z
 */
require_once(dirname(__FILE__)."/config.php");
require_once(XAKINC."/xakcollection.class.php");
$backurl = isset($_COOKIE['ENV_GOBACK_URL']) ? $_COOKIE['ENV_GOBACK_URL'] : "co_url.php";
if(empty($action)) $action='';
if($aid=='')
{
    ShowMsg('参数无效!','-1');
    exit();
}

//保存更改
if($action=="save")
{
    $result = '';
    for($i=0;$i < $endid;$i++)
    {
        $result .= "{xak:field name=\\'".${"noteid_$i"}."\\'}".${"value_$i"}."{/xak:field}\r\n";
    }
    $dsql->ExecuteNoneQuery("UPDATE `#@__co_htmls` SET result='$result' WHERE aid='$aid'; ");
    ShowMsg("成功保存一条记录！",$backurl);
    exit();
}
$dsql->SetSql("SELECT * FROM `#@__co_htmls` WHERE aid='$aid'");
$dsql->Execute();
$row = $dsql->GetObject();
$isdown = $row->isdown;
$nid = $row->nid;
$url = $row->url;
$dtime = $row->dtime;
$body = $row->result;
$litpic = $row->litpic;
$fields = array();
if($isdown == 0)
{
    $co = new XakCollection();
    $co->LoadNote($nid);
    $co->DownUrl($aid, $url, $litpic);
    $co->dsql->SetSql("SELECT * FROM `#@__co_htmls` WHERE aid='$aid'");
    $co->dsql->Execute();
    $row = $co->dsql->GetObject();
    $isdown = $row->isdown;
    $nid = $row->nid;
    $url = $row->url;
    $dtime = $row->dtime;
    $body = $row->result;
    $litpic = $row->litpic;
}
$dtp = new XakTagParse();
$dtp->SetNameSpace("xak", "{", "}");
$dtp->LoadString($body);
include XAKINClude('templets/co_view.htm');