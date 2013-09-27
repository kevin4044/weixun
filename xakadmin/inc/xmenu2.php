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
<m:top item='1_' name='常用操作' display='block' class='cycc'>
  <m:item name='所有档案列表' link='content_list.php' rank='a_List,a_AccList' target='main' class='sydalb' />
  <m:item name='内容回收站' link='recycling.php' ischannel='1' addalt='清空回收站' addico='images/gtk-del.png' linkadd='archives_do.php?dopost=clear&aid=no' rank='a_List,a_AccList,a_MyList' target='main' class='nrhsz' />  
  <m:item name='友情链接' link='friendlink_main.php' target='main' class='yqlj' />
  <m:item name='广告管理' link='rpad_main.php' target='main' class='gggl' />
  
</m:top>
<m:top item='1_' name='内容管理' display='block' class='cycc'>		
	$addset		
</m:top>
<m:top item='1_' name='附件管理' display='block' rank='sys_Upload,sys_MyUpload,plus_文件管理器' class='fjgl'>
  <m:item name='上传新文件' link='media_add.php' rank='' target='main' class='scxwj' />
  <m:item name='附件数据管理' link='media_main.php' rank='sys_Upload,sys_MyUpload' target='main' class='fjsjgl' />
  <m:item name='文件式管理器' link='media_main.php?dopost=filemanager' rank='plus_文件管理器' target='main' class='wjsglq' />
</m:top>
-----------------------------------------------
";
?>