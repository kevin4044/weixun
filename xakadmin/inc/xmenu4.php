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
<m:top item='1_' name='自动任务' notshowall='1'  display='block' rank='sys_MakeHtml' class='zdrw'>
  <m:item name='一键更新网站' link='makehtml_all.php' rank='sys_MakeHtml' target='main' class='yjgxwz' />
  <m:item name='更新系统缓存' link='sys_cache_up.php' rank='sys_ArcBatch' target='main' class='gxxthc' />
</m:top>
<m:top item='1_' name='HTML更新' notshowall='1' display='none' rank='sys_MakeHtml' class='htmlgx'>
  <m:item name='更新主页HTML' link='makehtml_homepage.php' rank='sys_MakeHtml' target='main' class='gxzyhtml' />
  <m:item name='更新栏目HTML' link='makehtml_list.php' rank='sys_MakeHtml' target='main' class='gxlmhtml' />
  <m:item name='更新文档HTML' link='makehtml_archives.php' rank='sys_MakeHtml' target='main' class='gxwdhtml' />
</m:top>
-----------------------------------------------
";
?>