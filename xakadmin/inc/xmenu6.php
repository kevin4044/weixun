<?php
require_once(dirname(__FILE__)."/../config.php");

//载入可发布频道
$addset = '';

//检测可用的内容模型
if($cfg_admin_channel = 'array' && count($admin_catalogs) > 0)
{
	$admin_catalog = join(',', $admin_catalogs);
	$dsql->SetQuery(" Select channeltype From `#@__arctype` where id in({$admin_catalog}) group by channeltype ");
}
else
{
	$dsql->SetQuery(" Select channeltype From `#@__arctype` group by channeltype ");
}
$dsql->Execute();
$candoChannel = '';
while($row = $dsql->GetObject())
{
	$candoChannel .= ($candoChannel=='' ? $row->channeltype : ','.$row->channeltype);
}
if(empty($candoChannel)) $candoChannel = 1;
$dsql->SetQuery("Select id,typename,addcon,mancon From `#@__channeltype` where id in({$candoChannel}) And id<>-1 And isshow=1 order by id asc");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$addset .= "  <m:item name='{$row->typename}' ischannel='1' link='{$row->mancon}?channelid={$row->id}' linkadd='{$row->addcon}?channelid={$row->id}' channelid='{$row->id}' rank='' target='main' />\r\n";
}
//////////////////////////
$menusMain = "
-----------------------------------------------
<m:top item='1_' name='采集管理' display='none' rank='co_NewRule,co_ListNote,co_ViewNote,co_Switch,co_GetOut' class='cjgl'>
  <m:item name='采集节点管理' link='co_main.php' rank='co_ListNote' target='main' class='cjjdgl' />
  <m:item name='临时内容管理' link='co_url.php' rank='co_ViewNote' target='main' class='lsnrgl' />
  <m:item name='导入采集规则' link='co_get_corule.php' rank='co_GetOut' target='main' class='drcjgz'/>
  <m:item name='监控采集模式' link='co_gather_start.php' rank='co_GetOut' target='main' class='jkcjms'/>
  <m:item name='采集未下载内容' link='co_do.php?dopost=coall' rank='co_GetOut' target='main' class='cjwxznr'/>
</m:top>
-----------------------------------------------
";
?>