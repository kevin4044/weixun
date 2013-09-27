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
<m:top item='1_' name='栏目管理' display='block' class='lmgl'>
	<m:item name='网站栏目管理' link='catalog_main.php' target='main' class='wzlmgl' />
	<m:item name='添加栏目' link='catalog_add.php?listtype=all' target='main' class='tjlm' />
</m:top>
<m:top item='1_' name='批量维护' display='block' class='plwh'>
  <m:item name='更新系统缓存' link='sys_cache_up.php' rank='sys_ArcBatch' target='main' class='gxxthc' />
  <m:item name='文档批量维护' link='content_batch_up.php' rank='sys_ArcBatch' target='main' class='wdplwh' />
  <m:item name='搜索关键词维护' link='search_keywords_main.php' rank='sys_Keyword' target='main' class='ssgjcwh' />
  <m:item name='文档关键词维护' link='article_keywords_main.php' rank='sys_Keyword' target='main' class='wdgjcwh' />
  <m:item name='重复文档检测' link='article_test_same.php' rank='sys_ArcBatch' target='main' class='cfwdjc' />
  <m:item name='自动摘要|分页' link='article_description_main.php' rank='sys_Keyword' target='main' class='zdzy' />
  <m:item name='数据库内容替换' link='sys_data_replace.php' rank='sys_ArcBatch' target='main' class='sjknrth' />
</m:top>
-----------------------------------------------
";
?>