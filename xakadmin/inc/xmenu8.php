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
<m:top item='1_' name='系统设置' display='none' rank='sys_User,sys_Group,sys_Edit,sys_Log,sys_Data' class='xtsz'>
  <m:item name='系统基本参数' link='sys_info.php' rank='sys_Edit' target='main' class='xtjbcs' />
  <m:item name='系统用户管理' link='sys_admin_user.php' rank='sys_User' target='main' class='xtyhgl' />
  <m:item name='用户组设定' link='sys_group.php' rank='sys_Group' target='main' class='yhzsd' />
  <m:item name='系统日志管理' link='log_list.php' rank='sys_Log' target='main' class='xtrzgl' />
  <m:item name='验证安全设置' link='sys_safe.php' rank='sys_verify' target='main' class='yzaqsz' />
  <m:item name='图片水印设置' link='sys_info_mark.php' rank='sys_Edit' target='main' class='tpsysz' />
  <m:item name='自定义文档属性' link='content_att.php' rank='sys_Att' target='main' class='zdywdsx' />
  <m:item name='数据库备份/还原' link='sys_data.php' rank='sys_Data' target='main' class='sjkbf' />
  <m:item name='SQL命令行工具' link='sys_sql_query.php' rank='sys_Data' target='main' class='sql' />
  <m:item name='系统错误修复[S]' link='sys_repair.php' rank='sys_verify' target='main' class='xtcwxf' />
</m:top>
-----------------------------------------------
";
?>